window.yii.app.rekening = (function ($) {
    var el;
    var dg;

    var rekeningForm;
    var rekeningDlg;
    var rekeningKodeRekeningInput;
    var rekeningJumlahInput;
    var rekeningOpdInput;
    var rekeningProdukHukumInput;
    var rekeningKeteranganInput;
    var rekeningFormDlg = function (row) {
        var title = 'Tambah Rekening';
        var url;
        if (row) {
            title = 'Edit Rekening';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/rekening/update',
                id: row.kode
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/rekening/create' }, true);
        }

        if (rekeningDlg) {
            rekeningDlg.dialog('setTitle', title);
            rekeningDlg.dialog('open');
            rekeningForm.form({ url: url });
            if (row) {
                rekeningForm.form('load', row);
                rekeningKodeRekeningInput.textbox({ readonly: true });
            } else {
                rekeningForm.form('reset');
                rekeningKodeRekeningInput.textbox({ readonly: false });
            }
        } else {
            rekeningDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            rekeningForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="rekening-form" method="post"></form></div>'
            });

            rekeningForm = rekeningDlg.find('#rekening-form');

            rekeningOpdInput = $('<input name="opd_id" style="border: none"/>');
            rekeningForm.append(rekeningOpdInput);
            yii.app.refDropdown('opd', rekeningOpdInput, function () {
                if (row) {
                    rekeningOpdInput.combobox('setValue', row.opd_id);
                }
            }, { required: true });

            rekeningKodeRekeningInput = $('<input name="kode_rekening" />');
            rekeningForm.append(rekeningKodeRekeningInput);
            rekeningKodeRekeningInput.textbox({
                label: 'Kode Rekening: ',
                labelPosition: 'top',
                width: 300,
                required: true,
            });

            rekeningJumlahInput = $('<input name="jumlah" />');
            rekeningForm.append(rekeningJumlahInput);
            rekeningJumlahInput.numberbox({
                label: 'Jumlah: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                groupSeparator: '.',
                decimalSeparator: ',',
            });

            rekeningProdukHukumInput = $('<input name="produk_hukum_id" />');
            rekeningForm.append(rekeningProdukHukumInput);
            yii.app.produkHukumDropdown(rekeningProdukHukumInput, { required: true, });

            rekeningKeteranganInput = $('<input name="keterangan"/>');
            rekeningForm.append(rekeningKeteranganInput);
            rekeningKeteranganInput.textbox({
                label: 'Keterangan: ',
                labelPosition: 'top',
                width: 300,
                multiline: true,
                height: 200
            });

            rekeningForm.form({
                url: url,
                success: function (data) {
                    rekeningDlg.dialog('close');
                    dg.datagrid('reload');
                },
                error: function (xhr) {
                    return yii.easyui.ajaxError(xhr, function () {
                        //refAjax(callback, refName, route, fields);
                    });
                }
            });

            if (row) {
                rekeningForm.form('load', row);
            }
        }
    };

    var initDg = () => {
        dg = el.find('#rekening-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/rekening' }),
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
            sortName: 'kode',
            remoteSort: true,
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    { field: 'kode', title: 'Kode', sortable: true },
                    { field: 'nama', title: 'Nama', sortable: true },
                ]
            ],
            toolbar: [{
                text: 'Baru',
                iconCls: 'icon-add',
                handler: function () {
                    rekeningFormDlg();
                }
            }, {
                text: 'Edit',
                iconCls: 'icon-edit',
                handler: function () {
                    rekeningFormDlg(dg.datagrid('getSelected'));
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
            yii.app.filter.customize(dg, 'kode', 'contains', true),
            yii.app.filter.customize(dg, 'nama', 'contains', true),
        ]);
    };

    return {
        isActive: false,
        init: function () {
            el = $('#rekening-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="rekening-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="rekening-dg"></table>'
            });

            initDg();

        }
    };
})(window.jQuery);