<?php

namespace app\admin\controller\user;

use app\common\controller\Backend;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use fast\Tree;

/**
 * 会员组管理
 *
 * @icon fa fa-users
 */
class Group extends Backend
{

    /**
     * @var \app\admin\model\UserGroup
     */
    protected $model = null;
    # 管理员信息
    protected $manager_mode = null;
    //当前登录管理员所有子组别
    protected $childrenGroupIds = [];
    //当前登录管理员所有子管理员
    protected $childrenAdminIds = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('UserGroup');

        $this->manager_mode = model('Admin');

        $this->childrenAdminIds = $this->auth->getChildrenAdminIds(true);
        $this->childrenGroupIds = $this->auth->getChildrenGroupIds(true);

        $groupList = collection(AuthGroup::where('id', 'in', $this->childrenGroupIds)->select())->toArray();

        Tree::instance()->init($groupList);
        $groupdata = [];
        if ($this->auth->isSuperAdmin())
        {
            $result = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0));
            foreach ($result as $k => $v)
            {
                $groupdata[$v['id']] = $v['name'];
            }
        }
        else
        {
            $result = [];
            $groups = $this->auth->getGroups();
            foreach ($groups as $m => $n)
            {
                $childlist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray($n['id']));
                $temp = [];
                foreach ($childlist as $k => $v)
                {
                    $temp[$v['id']] = $v['name'];
                }
                $result[__($n['name'])] = $temp;
            }
            $groupdata = $result;
        }

        $this->view->assign('groupdata', $groupdata);
        $this->assignconfig("admin", ['id' => $this->auth->id]);

        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function add()
    {
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a", [], 'strip_tags');
            if ($params)
            {
                
                $result = $this->model->validate()->save($params);
                if ($result === FALSE)
                {
                    $this->error($this->model->getError());
                }
                $this->success();
            }
            $this->error();
        }
        
        # 当前管理员和所有子管理员
        $childrenGroupIds = $this->childrenGroupIds;
        # 查询数据库条件
        list($where, $sort, $order) = $this->buildparams();
        # 查询管理员数据库
        $list = collection($this->manager_mode
                ->where($where)
                ->where('id', 'in', $this->childrenAdminIds)
                ->field(['id', 'nickname'])
                ->order($sort, $order)
                ->select())->toArray();
        # 整理到下拉菜单
        foreach ($list as $key => $value) {
            $temp[$value['id']] = $value['nickname'];
        }

        $nodeList = \app\admin\model\UserRule::getTreeList();
        $this->assign("nodeList", $nodeList);
        $this->assign('manager', $temp);
        // return parent::add();
        return $this->view->fetch();
    }

    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $rules = explode(',', $row['rules']);
        $nodeList = \app\admin\model\UserRule::getTreeList($rules);
        $this->assign("nodeList", $nodeList);
        return parent::edit($ids);
    }

}
