define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'robot/robotcontrollercommand/index',
                    add_url: 'robot/robotcontrollercommand/add',
                    edit_url: 'robot/robotcontrollercommand/edit',
                    del_url: 'robot/robotcontrollercommand/del',
                    multi_url: 'robot/robotcontrollercommand/multi',
                    table: 'robot_control_command',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'robot_sn', title: __('Robot_sn')},
                        {field: 'command_cat', title: __('Command_cat')},
                        {field: 'command_type', title: __('Command_type')},
                        {field: 'command', title: __('Command')},
                        {field: 'ip_addr', title: __('Ip_addr')},
                        {field: 'commander', title: __('Commander')},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});