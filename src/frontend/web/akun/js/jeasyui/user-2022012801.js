window.yii.app.user = (function ($) {
    var el;
    var dg;

    var userForm;
    var userDlg;
    var statusInput;
    var userFormDlg = function (row) {
        title = 'Edit Pengguna: ' + row.username;
        url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
            r: 'v1/user/update',
            id: row.id
        }, true);

        if (userDlg) {
            userDlg.dialog('setTitle', title);
            userDlg.dialog('open');
            userForm.form({ url: url });
            if (row) {
                userForm.form('load', row);
                statusInput.combobox('setValue', row.status);
            } else {
                userForm.form('reset');
            }
        } else {
            userDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            userForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="user-form" method="post"></form></div>'
            });

            userForm = userDlg.find('#user-form');

            statusInput = $('<input name="status" />');
            userForm.append(statusInput);
            yii.app.refDropdown('statusUser', statusInput, function () {
                statusInput.combobox('setValue', row.status);
            });

            userForm.form({
                url: url,
                success: function (data) {
                    userDlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                userForm.form('load', row);
            }
        }
    };

    var ajaxResetPassword = function (row) {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/user/reset-password',
                id: row.id
            }, true),
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                yii.easyui.hideMainMask();
                $.messager.alert('Reset Password', res.message, 'info');
            },
            error: function (xhr) {
                return yii.easyui.ajaxError(xhr, function () {
                    ajaxGenerateUser(row);
                });
            }
        });
    };

    var ajaxAssign = function (row, role, revoke = false, callback) {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/user/assign',
                id: row.id
            }, true),
            data: {
                revoke: revoke,
                role: role,
            },
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                yii.easyui.hideMainMask();
                if (res.success) {
                    dg.datagrid('reload');
                    $.messager.alert('Assigment', res.message, 'info');
                } else {
                    $.messager.alert('Assigment', res.message, 'error');
                }
            },
            error: function (xhr) {
                return yii.easyui.ajaxError(xhr, function () {
                    ajaxAssign(row, role, revoke);
                });
            }
        });
    };

    return {
        isActive: false,
        init: function () {
            el = $('#user-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="user-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="user-dg"></table>'
            });

            //            var userEastEl = $('#user-east');
            //            userEastEl.layout({
            //                fit: true,
            //                border: false
            //            }).layout('add', {
            //                title: 'Available Denom',
            //                region: 'south',
            //                split: false,
            //                content: '<table id="user-denom-dg"></table>',
            //                collapsible: true,
            //                border: false,
            //                height: '50%'
            //            }).layout('add', {
            //                region: 'center',
            //                border: false,
            //                content: '<table id="user-subuser-dg"></table>'
            //            });

            dg = el.find('#user-dg');
            dg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/user', fields: 'id, username, status, roles, email, nama_lengkap' }),
                method: 'get',
                fit: true,
                border: false,
                striped: true,
                checkOnSelect: false,
                singleSelect: true,
                emptyMsg: 'No Records Found.',
                rownumbers: true,
                pagination: true,
                pageSize: 50,
                remoteFilter: true,
                columns: [
                    [
                        { field: 'ck', checkbox: true },
                        { field: 'username', title: 'Username' },
                        { field: 'roles', title: 'Roles' },
                        {
                            field: 't0.status',
                            title: 'Status',
                            width: 130,
                            formatter: yii.app.formatter.ref('statusUser', 'status')
                        },
                        { field: 'nama_lengkap', title: 'Nama' },
                    ]
                ],
                toolbar: '#user-tb',
                onLoadSuccess: function (data) {
                    $(this).datagrid('selectRow', 0);
                },
                onLoadError: function (xhr) {
                    yii.easyui.ajaxError(xhr, function (r) {
                        if (r) {
                            dg.datagrid('reload');
                        }
                    });
                }
            })
                .datagrid('enableFilter', [
                    yii.app.filter.ref(dg, 't0.status', 'statusUser'),
                    yii.app.filter.customize(dg, 'username', 'contains', true),
                    yii.app.filter.customize(dg, 'nama_lengkap', 'contains', true),
                    yii.app.filter.customize(dg, 'roles', 'contains', true),
                ])
                ;

            $('#user-tb-edit').linkbutton({
                text: 'Edit',
                iconCls: 'icon-edit',
                plain: true,
                onClick: function () {
                    userFormDlg(dg.datagrid('getSelected'));
                },
            });

            $('#user-tb-hapus').linkbutton({
                text: 'Hapus',
                iconCls: 'icon-remove',
                plain: true,
                onClick: function () {
                    alert('delete');
                }
            });

            $('#user-tb-reset').linkbutton({
                text: 'Reset Password',
                iconCls: 'icon-reload',
                plain: true,
                onClick: function () {
                    $.messager.confirm('Reset Password', 'Yakin untuk mereset password?', function () {
                        ajaxResetPassword(dg.datagrid('getSelected'));
                    });
                }
            });

            var userMmAssignment = $('#user-tb-assignment-mm');
            userMmAssignment.menu({ minWidth: 250 });
            $.each(yii.app.user.roles, function (k, v) {
                userMmAssignment.menu('appendItem', {
                    text: 'Assign ' + v.description,
                    onclick: function () {
                        $.messager.confirm('Assigment', 'Yakin akan memberikan akses ' + v.description + '?', function () {
                            ajaxAssign(dg.datagrid('getSelected'), v.name, 0);
                        });
                    },
                });
            });

            userMmAssignment.menu('appendItem', { separator: true });

            $.each(yii.app.user.roles, function (k, v) {
                userMmAssignment.menu('appendItem', {
                    text: 'Revoke ' + v.description,
                    onclick: function () {
                        $.messager.confirm('Assigment', 'Yakin akan membuang akses ' + v.description + '?', function () {
                            ajaxAssign(dg.datagrid('getSelected'), v.name, 1);
                        });
                    },
                });
            });

            $('#user-tb-assignment').menubutton({
                text: 'Assigment',
                iconCls: 'icon-lock',
                menu: userMmAssignment
            });

        }
    };
})(window.jQuery);