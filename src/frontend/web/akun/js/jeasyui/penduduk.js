window.yii.app.penduduk = (function ($) {
    var el;
    var dg;

    var frm;
    var dlg;
    var nikInput;
    var namaInput;
    var frmDlg = function (row) {
        var title = 'Tambah Penduduk';
        var url;
        if (row) {
            title = 'Edit Penduduk';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/penduduk/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/penduduk/create' }, true);
        }

        if (dlg) {
            dlg.dialog('setTitle', title);
            dlg.dialog('open');
            frm.form({ url: url });
            if (row) {
                frm.form('load', row);
            } else {
                frm.form('reset');
            }
        } else {
            dlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            frm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="penduduk-form" method="post"></form></div>'
            });

            frm = dlg.find('#penduduk-form');

            nikInput = $('<input name="nik" />');
            frm.append(nikInput);
            nikInput.textbox({
                label: 'NIK: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            namaInput = $('<input name="nama_tanpa_gelar" />');
            frm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            frm.form({
                url: url,
                success: function (data) {
                    dlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                frm.form('load', row);
            }
        }
    };

    var ajaxGenerateUser = function (row) {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/penduduk/generate-user',
                id: row.id
            }, true),
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                yii.easyui.hideMainMask();
                $.messager.alert('User Akun', res.message, res.success ? 'info' : 'error');
            },
            error: function (xhr) {
                yii.easyui.hideMainMask();
                return yii.easyui.ajaxError(xhr, function () {
                    ajaxGenerateUser(row);
                });
            }
        });
    };

    var initDg = () => {
        dg = $('#penduduk-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/penduduk' }),
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
            sortName: 'id',
            remoteSort: true,
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    //{ field: 'id', title: 'ID', sortable: true },
                    { field: 'nik', title: 'NIK', sortable: true },
                    { field: 'nama_tanpa_gelar', title: 'Nama', sortable: true },
                ]
            ],
            toolbar: [{
                text: 'Baru',
                iconCls: 'icon-add',
                handler: function () {
                    frmDlg();
                }
            }, {
                text: 'Edit',
                iconCls: 'icon-edit',
                handler: function () {
                    frmDlg(dg.datagrid('getSelected'));
                }
            }, '-', {
                text: 'Hapus',
                iconCls: 'icon-remove',
                handler: function () {
                    alert('delete');
                }
            }, '-',
            {
                text: 'Generate Akun',
                iconCls: 'icon-user',
                handler: function () {
                    ajaxGenerateUser(dg.datagrid('getSelected'));
                }
            }
            ],
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
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'id', 'equal'),
            yii.app.filter.customize(dg, 'nik', 'contains'),
            yii.app.filter.customize(dg, 'nama_tanpa_gelar', 'contains', true),
        ]);
    };
    
    return {
        isActive: false,
        init: function () {
            el = $('#penduduk-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="penduduk-dg"></table>'
            });

            initDg();
        }
    };
})(window.jQuery);