window.yii.app.anggaran = (function ($) {
    var anggaranDg;

    var anggaranForm;
    var anggaranDlg;
    var anggaranKodeRekeningInput;
    var anggaranJumlahInput;
    var anggaranOpdInput;
    var anggaranProdukHukumInput;
    var anggaranKeteranganInput;
    var anggaranFormDlg = function (row) {
        var title = 'Tambah Anggaran';
        var url;
        if (row) {
            title = 'Edit Anggaran';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/anggaran/update',
                id: row.kode
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/anggaran/create' }, true);
        }

        if (anggaranDlg) {
            anggaranDlg.dialog('setTitle', title);
            anggaranDlg.dialog('open');
            anggaranForm.form({ url: url });
            if (row) {
                anggaranForm.form('load', row);
                anggaranKodeRekeningInput.textbox({ readonly: true });
            } else {
                anggaranForm.form('reset');
                anggaranKodeRekeningInput.textbox({ readonly: false });
            }
        } else {
            anggaranDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            anggaranForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="anggaran-form" method="post"></form></div>'
            });

            anggaranForm = anggaranDlg.find('#anggaran-form');

            anggaranOpdInput = $('<input name="opd_id" style="border: none"/>');
            anggaranForm.append(anggaranOpdInput);
            yii.app.refDropdown('opd', anggaranOpdInput, function () {
                if (row) {
                    anggaranOpdInput.combobox('setValue', row.opd_id);
                }
            }, { required: true });

            anggaranKodeRekeningInput = $('<input name="kode_rekening" />');
            anggaranForm.append(anggaranKodeRekeningInput);
            anggaranKodeRekeningInput.textbox({
                label: 'Kode Rekening: ',
                labelPosition: 'top',
                width: 300,
                required: true,
            });

            anggaranJumlahInput = $('<input name="jumlah" />');
            anggaranForm.append(anggaranJumlahInput);
            anggaranJumlahInput.numberbox({
                label: 'Jumlah: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                groupSeparator: '.',
                decimalSeparator: ',',
            });

            anggaranProdukHukumInput = $('<input name="produk_hukum_id" />');
            anggaranForm.append(anggaranProdukHukumInput);
            yii.app.produkHukumDropdown(anggaranProdukHukumInput, { required: true, });

            anggaranKeteranganInput = $('<input name="keterangan"/>');
            anggaranForm.append(anggaranKeteranganInput);
            anggaranKeteranganInput.textbox({
                label: 'Keterangan: ',
                labelPosition: 'top',
                width: 300,
                multiline: true,
                height: 200
            });

            anggaranForm.form({
                url: url,
                success: function (data) {
                    anggaranDlg.dialog('close');
                    anggaranDg.datagrid('reload');
                },
                error: function (xhr) {
                    return yii.easyui.ajaxError(xhr, function () {
                        //refAjax(callback, refName, route, fields);
                    });
                }
            });

            if (row) {
                anggaranForm.form('load', row);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            var anggaranEl = $('#anggaran-index');
            anggaranEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="anggaran-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="anggaran-dg"></table>'
            });

            anggaranDg = $('#anggaran-dg');
            anggaranDg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/anggaran' }),
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
                        { field: 'kode_rekening', title: 'Kode Rekening', sortable: true },
                        {
                            field: 'jumlah',
                            title: 'Jumlah',
                            sortable: true,
                            align: 'right',
                            formatter: yii.easyui.currencyFormatter,
                        },
                        {
                            field: 'saldo',
                            title: 'Saldo',
                            sortable: true,
                            align: 'right',
                            formatter: yii.easyui.currencyFormatter,
                        },
                    ]
                ],
                toolbar: [{
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        anggaranFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        anggaranFormDlg(anggaranDg.datagrid('getSelected'));
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
                            anggaranDg.datagrid('reload');
                        }
                    });
                }
            }).datagrid('enableFilter', [
                yii.app.filter.customize(anggaranDg, 'id', 'equal'),
                yii.app.filter.customize(anggaranDg, 'nama', 'contains', true),
                yii.app.filter.customize(anggaranDg, 'nama_2', 'contains', true),
            ]);

        }
    };
})(window.jQuery);