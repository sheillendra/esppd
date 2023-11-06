window.yii.app.produkHukum = (function ($) {
    var dg;

    var frm;
    var dlg;
    var namaInput;
    var tentangInput;
    var statusInput;
    var frmDlg = function (row) {
        var title = 'Produk Hukum';
        var url;
        if (row) {
            title = 'Edit Produk Hukum';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/produk-hukum/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/produk-hukum/create' }, true);
        }

        if (dlg) {
            dlg.dialog('setTitle', title);
            dlg.dialog('open');
            frm.form({ url: url });
            if (row) {
                frm.form('load', row);
            } else {
                frm.form('reset');
                statusInput.combobox('setValue', 1);
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
                content: '<div style="padding: 20px"><form id="produk-hukum-form" method="post"></form></div>'
            });

            frm = dlg.find('#produk-hukum-form');

            namaInput = $('<input name="nama" />');
            frm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            tentangInput = $('<input name="tentang" />');
            frm.append(tentangInput);
            tentangInput.textbox({
                label: 'Tentang: ',
                labelPosition: 'top',
                width: 300,
            });

            statusInput = $('<input name="status" />');
            frm.append(statusInput);
            yii.app.refDropdown('status', statusInput);

            frm.form({
                url: url,
                success: function (data) {
                    dlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                frm.form('load', row);
            }else{
                statusInput.combobox('setValue', 1);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            var produkHukumEl = $('#produk-hukum-index');
            produkHukumEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="produk-hukum-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="produk-hukum-dg"></table>'
            });

            dg = $('#produk-hukum-dg');
            dg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/produk-hukum' }),
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
                        { field: 'nama', title: 'Nama', sortable: true },
                        { field: 'status', title: 'Status', sortable: true, formatter: yii.app.formatter.ref('status') },
                        { field: 'tentang', title: 'Tentang', sortable: true },
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
                yii.app.filter.ref(dg, 'status', 'status'),
                yii.app.filter.customize(dg, 'nama', 'contains', true),
                yii.app.filter.customize(dg, 'tentang', 'contains', true),
            ]);

        }
    };
})(window.jQuery);