window.yii.app.wilayah = (function ($) {
    var el;
    var dg;

    var frm;
    var dlg;
    var namaInput;
    var frmDlg = function (row) {
        var title = 'Tambah Wilayah';
        var url;
        if (row) {
            title = 'Edit Wilayah';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/wilayah/update',
                id: row.kode
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/wilayah/create' }, true);
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
                content: '<div style="padding: 20px"><form id="wilayah-form" method="post"></form></div>'
            });

            frm = dlg.find('#wilayah-form');

            namaInput = $('<input name="nama" />');
            frm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            if (row) {
                frm.form('load', row);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            el = $('#wilayah-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="wilayah-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="wilayah-dg"></table>'
            });

            dg = $('#wilayah-dg');
            dg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/wilayah' }),
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
                        { field: 'kode', title: 'Kode', sortable: true },
                        { field: 'nama', title: 'Nama', sortable: true },
                        {
                            field: 'level',
                            title: 'Tingkat', sortable: true,
                            formatter: function (value, row, index) {
                                return yii.app.getRef('levelWilayah', value);
                            }
                        },
                        {
                            field: 'kategori',
                            title: 'Kategori', sortable: true,
                            formatter: function (value, row, index) {
                                return yii.app.getRef('kategoriWilayah', value);
                            }
                        },
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
                yii.app.filter.customize(dg, 'kode', 'contains'),
                yii.app.filter.customize(dg, 'nama', 'contains', true),
                yii.app.filter.customize(dg, 'level', 'equal'),
            ]);

        }
    };
})(window.jQuery);