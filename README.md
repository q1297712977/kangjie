### 2019.04.09 更新说明
* 实现1对1会员和管理员连表查询，可展示管理员的用户名昵称等
*创建机器人管理，数据表还未修改
 *会员组模块功能修改仍不好使，在点击修改时，指定管理员默认admin 不能根据点击的自动默认

### 2019.04.04 更新说明

* 会员模块 -- 添加流程
  * 将会员功能进一步完善，初步可以实现增删改查，不过查询略慢，支持搜索功能
* 会员分组模块 -- 查看列表
  * 只能查看当前登陆的管理员及其组内成员名下的会员以及根据权限进行显示，只显示本身及旗下分组和会员。
  * 解决在分组添加和修改时多选的问题
  * 实现流程：首先获取当前登陆的管理员的组员Ids，查询user_group表(admin_id in ids) 获得会员分组，通过得到的分组查询分组下的会员
* 注意： 
  * 修改模块没有做。还是之前的代码，直接使用会出现问题。
  * 删除功能没有做控制，功能是可以用的。不过如果删除了某个会员分组，会导致查询不到所删除的分组下的会员。
### 2019.04.03 更新说明

* 会员模块 -- 添加流程
  * 需要先添加会员分组，添加分组时需要指定管理员，只可以指定当前管理员及其组内的管理员，可以多选，默认选中当前管理员
  * 添加会员，给会员分配角色组，只能分配当前管理员及其组内的管理员所拥有的角色
  * 数据表 kj_user_group中添加了新字段 admin_id  (int类型)
* 会员模块 -- 查看列表
  * 只能查看当前登陆的管理员及其组内成员名下的会员
  * 实现流程：首先获取当前登陆的管理员的组员Ids，查询user_group表(admin_id in ids) 获得会员分组，通过得到的分组查询分组下的会员
* 注意： 
  * 修改模块没有做。还是之前的代码，直接使用会出现问题。
  * 删除功能没有做控制，功能是可以用的。不过如果删除了某个会员分组，会导致查询不到所删除的分组下的会员。





FastAdmin是一款基于ThinkPHP5+Bootstrap的极速后台开发框架。


## **主要特性**

* 基于`Auth`验证的权限管理系统
    * 支持无限级父子级权限继承，父级的管理员可任意增删改子级管理员及权限设置
    * 支持单管理员多角色
    * 支持管理子级数据或个人数据
* 强大的一键生成功能
    * 一键生成CRUD,包括控制器、模型、视图、JS、语言包、菜单等
    * 一键压缩打包JS和CSS文件，一键CDN静态资源部署
    * 一键生成控制器菜单和规则
    * 一键生成API接口文档
* 完善的前端功能组件开发
    * 基于`AdminLTE`二次开发
    * 基于`Bootstrap`开发，自适应手机、平板、PC
    * 基于`RequireJS`进行JS模块管理，按需加载
    * 基于`Less`进行样式开发
    * 基于`Bower`进行前端组件包管理
* 强大的插件扩展功能，在线安装卸载升级插件
* 通用的会员模块和API模块
* 共用同一账号体系的Web端会员中心权限验证和API接口会员权限验证
* 二级域名部署支持，同时域名支持绑定到插件
* 多语言支持，服务端及客户端支持
* 强大的第三方模块支持([CMS](https://www.fastadmin.net/store/cms.html)、[博客](https://www.fastadmin.net/store/blog.html)、[文档生成](https://www.fastadmin.net/store/docs.html))
* 整合第三方短信接口(阿里云、腾讯云短信)
* 无缝整合第三方云存储(七牛、阿里云OSS、又拍云)功能
* 第三方富文本编辑器支持(Summernote、Tinymce、百度编辑器)
* 第三方登录(QQ、微信、微博)整合
* Ucenter整合第三方应用

## **安装使用**

https://doc.fastadmin.net

## **在线演示**

https://demo.fastadmin.net

用户名：admin

密　码：123456

提　示：演示站数据无法进行修改，请下载源码安装体验全部功能

## **界面截图**
![控制台](https://gitee.com/uploads/images/2017/0411/113717_e99ff3e7_10933.png "控制台")

## **问题反馈**

在使用中有任何问题，请使用以下联系方式联系我们

交流社区: https://forum.fastadmin.net

QQ群: [636393962](https://jq.qq.com/?_wv=1027&k=487PNBb)(满) [708784003](https://jq.qq.com/?_wv=1027&k=5ObjtwM)(满) [964776039](https://jq.qq.com/?_wv=1027&k=59qjU2P)(3群)

Email: (karsonzhang#163.com, 把#换成@)

Github: https://github.com/karsonzhang/fastadmin

Gitee: https://gitee.com/karson/fastadmin

## **特别鸣谢**

感谢以下的项目,排名不分先后

ThinkPHP：http://www.thinkphp.cn

AdminLTE：https://adminlte.io

Bootstrap：http://getbootstrap.com

jQuery：http://jquery.com

Bootstrap-table：https://github.com/wenzhixin/bootstrap-table

Nice-validator: https://validator.niceue.com

SelectPage: https://github.com/TerryZ/SelectPage


## **版权信息**

FastAdmin遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2017-2018 by FastAdmin (https://www.fastadmin.net)

All rights reserved。
