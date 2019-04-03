<?php

namespace app\admin\controller\user;

use app\common\controller\Backend;
use app\admin\model\UserGroup;
use fast\Random;
use fast\Tree;

/**
 * 会员管理
 *
 * @icon fa fa-user
 */
class User extends Backend
{

    protected $relationSearch = true;
    protected $childrenGroupIds = [];
    protected $dataLimit = 'auth';
    /**
     * @var \app\admin\model\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('User');

        $this->childrenAdminIds = $this->auth->getChildrenAdminIds(true);
        $this->childrenGroupIds = $this->auth->getChildrenGroupIds(true);

        $groupList = collection(UserGroup::where('id', 'in', $this->childrenGroupIds)->select())->toArray();

        Tree::instance()->init($groupList);
        $groupdata = [];
//        if ($this->auth->isSuperAdmin())
//        {
//            $result = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0));
//            foreach ($result as $k => $v)
//            {
//                $groupdata[$v['id']] = $v['name'];
//            }
//        }
//        else
//        {
//            $result = [];
//            $groups = $this->auth->getGroups();
//            foreach ($groups as $m => $n)
//            {
//                $childlist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray($n['id']));
//                $temp = [];
//                foreach ($childlist as $k => $v)
//                {
//                    $temp[$v['id']] = $v['name'];
//                }
//                $result[__($n['name'])] = $temp;
//            }
//            $groupdata = $result;
//        }

        $this->view->assign('groupdata', $groupdata);
        $this->assignconfig("admin", ['id' => $this->auth->id]);
    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with('group')
                    ->where($where)
                    ->order($sort, $order)
                    ->count();
            $list = $this->model
                    ->with('group')
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            foreach ($list as $k => $v)
            {
                $v->hidden(['password', 'salt']);
            }
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {

        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
//        var_dump($row);
        $this->view->assign('groupList', build_select('row[group_id]', \app\admin\model\UserGroup::column('id,name'), $row['group_id'], ['class' => 'form-control selectpicker']));
        return parent::edit($ids);
    }
    /*
     * 注册
     * */
    public function add()
    {
        $id = session('admin')['id'];
        $row = $this->model->get($id);
//        var_dump($row);
        //展示当前登录信息的所有分组
        if (!$row)
            $this->error(__('No Results were found'));
        $this->view->assign('groupList', build_select('row[group_id]', \app\admin\model\UserGroup::column('id,name'), $row['group_id'], ['class' => 'form-control selectpicker']));

        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
//            var_dump($params);
            if ($params)
            {
                $params['salt'] = Random::alnum();
                $params['password'] = md5(md5($params['password']) . $params['salt']);
                $params['avatar'] = '/assets/img/avatar.png'; //设置新管理员默认头像。
                $result = $this->model->validate('User.add')->save($params);
                if ($result === false)
                {
                    $this->error($this->model->getError());
                }
                $group = $this->request->post('row/a');
//                var_dump($group);
                //过滤不允许的组别,避免越权
//                var_dump($this->childrenGroupIds);
                $group = array_intersect($this->childrenGroupIds, $group);
                $dataset = [];
                foreach ($group as $value)
                {
                    $dataset[] = ['user_id' => $this->model->id, 'admin_id' => $id];
                }
                model('Attachment')->saveAll($dataset);
                $this->success();
            }

                $this->error();

        }
        return $this->view->fetch();
//        return parent::add();
    }

}
