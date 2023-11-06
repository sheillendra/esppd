window.yii.app.pegawai = (function ($) {
    var el;
    var eastEL;
    var dg;
    var pg;

    var pegawaiForm;
    var pegawaiDlg;
    var nipInput;
    var opdInput;
    var pangkatInput;
    var eselonInput;

    var readOnlyEditor = {
        type: 'textbox',
        options: {
            readonly: true,
            multiline: true
        }
    };

    var pegawaiFormDlg = function (row) {
        var title = 'Pegawai Baru';
        var url;
        if (row) {
            title = 'Edit Pegawai';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pegawai/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/pegawai/create' }, true);
        }

        if (pegawaiDlg) {
            pegawaiDlg.dialog('setTitle', title);
            pegawaiDlg.dialog('open');
            pegawaiForm.form({ url: url });
            if (row) {
                pegawaiForm.form('load', row);
                //nipInput.textbox({ readonly: true });
                opdInput.combobox('setValue', row.opd_id);
            } else {
                pegawaiForm.form('reset');
                //nipInput.textbox({ readonly: false });
            }
        } else {
            pegawaiDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            pegawaiForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="pegawai-form" method="post"></form></div>'
            });

            pegawaiForm = pegawaiDlg.find('#pegawai-form');

            var nameInput = $('<input name="nama_tanpa_gelar" style="border: none"/>');
            pegawaiForm.append(nameInput);
            nameInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            var gelarDepanInput = $('<input name="gelar_depan" />');
            pegawaiForm.append(gelarDepanInput);
            gelarDepanInput.textbox({
                label: 'Gelar Depan: ',
                labelPosition: 'top',
                width: 300,
                required: false
            });

            var gelarBelakangInput = $('<input name="gelar_belakang" />');
            pegawaiForm.append(gelarBelakangInput);
            gelarBelakangInput.textbox({
                label: 'Gelar Belakang: ',
                labelPosition: 'top',
                width: 300,
                required: false
            });

            nipInput = $('<input name="nip" />');
            pegawaiForm.append(nipInput);
            nipInput.textbox({
                label: 'NIP: ',
                labelPosition: 'top',
                width: 300,
                required: false,
                //readonly: row ? true : false
            });

            pangkatInput = $('<input name="pangkat_golongan_id" />');
            pegawaiForm.append(pangkatInput);
            yii.app.refDropdown('pangkat', pangkatInput, function () {
                pangkatInput.combobox('setValue', row.pangkat_golongan_id);
            });

            eselonInput = $('<input name="eselon_id" />');
            pegawaiForm.append(eselonInput);
            yii.app.refDropdown('eselon', eselonInput, function () {
                eselonInput.combobox('setValue', row.eselon_id, { required: true });
            });

            opdInput = $('<input name="opd_id" />');
            pegawaiForm.append(opdInput);
            yii.app.refDropdown('opd', opdInput, function () {
                opdInput.combobox('setValue', row.opd_id);
            });

            pegawaiForm.form({
                url: url,
                success: function (data) {
                    pegawaiDlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                pegawaiForm.form('load', row);
            }
        }
    };

    var ajaxGenerateUser = function (row) {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pegawai/generate-user',
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

    var pgData = function (row) {
        row = row || {};
        return {
            rows: [
                {
                    name: 'NIP',
                    value: row.nip,
                    group: 'Umum',
                },
                {
                    name: 'Nama',
                    value: row.nama_tanpa_gelar,
                    group: 'Umum',
                },
                {
                    name: 'Gelar Depan',
                    value: row.gelar_depan,
                    group: 'Umum',
                },
                {
                    name: 'Gelar Belakang',
                    value: row.gelar_belakang,
                    group: 'Umum',
                },
                {
                    name: 'Pangkat Gol.',
                    value: yii.app.getRef('pangkat', row.pangkat_golongan_id),
                    group: 'Umum',
                },
                {
                    name: 'Eselon',
                    value: yii.app.getRef('eselon', row.eselon_id),
                    group: 'Umum',
                },
                {
                    name: 'OPD',
                    value: yii.app.getRef('opd', row.opd_id, function () {
                        pg.propertygrid('loadData', pgData(row));
                    }),
                    group: 'Umum',
                },
            ]
        };
    };

    var initDg = () => {
        dg = el.find('#pegawai-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/pegawai' }),
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
            sortName: 'nama_tanpa_gelar',
            remoteSort: true,
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    { field: 'nip', title: 'NIP', sortable: true },
                    {
                        field: 'nama_tanpa_gelar', title: 'Nama',
                        sortable: true,
                        formatter: (value, row, index) => {
                            return row.nama_lengkap;
                        }
                    },
                ]
            ],
            toolbar: [
                {
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        pegawaiFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        pegawaiFormDlg(dg.datagrid('getSelected'));
                    }
                }, '-',
                {
                    text: 'Hapus',
                    iconCls: 'icon-remove',
                    handler: function () {
                        let row = dg.datagrid('getSelected');
                        if (row) {
                            yii.app.ajax.delete({
                                id: row.id,
                                route: 'v1/pegawai/delete',
                                text: 'Pegawai',
                                callback: () => {
                                    dg.datagrid('reload');
                                }
                            });
                        } else {
                            $.messager.alert('Pegawai', 'Pilih pegawai yang akan dihapus', 'error');
                        }
                    }
                }, '-',
                {
                    text: 'Generate Akun',
                    iconCls: 'icon-user',
                    handler: function () {
                        let row = dg.datagrid('getSelected');
                        if (row) {
                            ajaxGenerateUser(row);
                        } else {
                            $.messager.alert('Pegawai', 'Pilih pegawai yang akan dibuatkan akunnya', 'error');
                        }
                    }
                },
            ],
            onSelect: function (index, row) {
                pg.propertygrid('loadData', pgData(row));
            },
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
            yii.app.filter.customize(dg, 'nip', 'equal'),
            yii.app.filter.customize(dg, 'nama_tanpa_gelar', 'contains', true),
        ]);
    };

    var initPg = () => {
        pg = eastEL.find('#pegawai-pg');
        pg.propertygrid({
            showGroup: true,
            scrollbarSize: 0,
            fit: true,
            border: false,
            nowrap: false,
            data: pgData()
        });
    };

    return {
        isActive: false,
        init: function () {
            el = $('#pegawai-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="pegawai-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="pegawai-dg"></table>'
            });

            eastEL = el.find('#pegawai-east');
            eastEL.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Jabatan',
                region: 'south',
                split: false,
                content: '<table id="pegawai-sppd-dg"></table>',
                collapsible: true,
                border: false,
                height: '40%'
            }).layout('add', {
                region: 'center',
                border: false,
                content: '<table id="pegawai-pg"></table>'
            });

            initDg();

            initPg();
        }
    };
})(window.jQuery);