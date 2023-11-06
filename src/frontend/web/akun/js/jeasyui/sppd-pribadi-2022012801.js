window.yii.app.sppdPribadi = (function ($) {
    var sppdPribadiDg;

    var sppdPribadiForm;
    var sppdPribadiDlg;
    var nipInput;
    var opdInput;
    var pangkatInput;
    var eselonInput;
    var sppdPribadiFormDlg = function (row) {
        var title = 'Surat Tugas Baru';
        var url;
        if (row) {
            title = 'Edit SuratTugas';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/surat-tugas/update',
                id: row.sppdPribadi_code
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/surat-tugas/create' }, true);
        }

        if (sppdPribadiDlg) {
            sppdPribadiDlg.dialog('setTitle', title);
            sppdPribadiDlg.dialog('open');
            sppdPribadiForm.form({ url: url });
            if (row) {
                sppdPribadiForm.form('load', row);
                //nipInput.textbox({ readonly: true });
                opdInput.combobox('setValue', row.opd_id);
            } else {
                sppdPribadiForm.form('reset');
                //nipInput.textbox({ readonly: false });
            }
        } else {
            sppdPribadiDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            sppdPribadiForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="surat-tugas-form" method="post"></form></div>'
            });

            sppdPribadiForm = sppdPribadiDlg.find('#surat-tugas-form');

            var nameInput = $('<input name="nama_tanpa_gelar" />');
            sppdPribadiForm.append(nameInput);
            nameInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            var gelarDepanInput = $('<input name="gelar_depan" />');
            sppdPribadiForm.append(gelarDepanInput);
            gelarDepanInput.textbox({
                label: 'Gelar Depan: ',
                labelPosition: 'top',
                width: 300,
                required: false
            });

            var gelarBelakangInput = $('<input name="gelar_belakang" />');
            sppdPribadiForm.append(gelarBelakangInput);
            gelarBelakangInput.textbox({
                label: 'Gelar Belakang: ',
                labelPosition: 'top',
                width: 300,
                required: false
            });

            nipInput = $('<input name="nip" />');
            sppdPribadiForm.append(nipInput);
            nipInput.textbox({
                label: 'NIP: ',
                labelPosition: 'top',
                width: 300,
                required: false,
                //readonly: row ? true : false
            });

            pangkatInput = $('<input name="pangkat_golongan_id" />');
            sppdPribadiForm.append(pangkatInput);
            yii.app.pangkatDropdown(pangkatInput, function () {
                pangkatInput.combobox('setValue', row.pangkat_golongan_id);
            });

            eselonInput = $('<input name="eselon_id" />');
            sppdPribadiForm.append(eselonInput);
            yii.app.eselonDropdown(eselonInput, function () {
                eselonInput.combobox('setValue', row.eselon_id);
            });

            opdInput = $('<input name="opd_id" />');
            sppdPribadiForm.append(opdInput);
            yii.app.opdDropdown(opdInput, function () {
                opdInput.combobox('setValue', row.opd_id);
            });

            // var smStat = $('<input name="status" />');
            // sppdPribadiForm.append(smStat);
            // smStat.combobox({
            //     label: 'Status: ',
            //     labelPosition: 'top',
            //     editable: false,
            //     width: 300,
            //     data: yii.app.generateItem(yii.app.ref.statusText, true),
            //     required: true
            // });

            sppdPribadiForm.form({
                url: url,
                success: function (data) {
                    sppdPribadiDlg.dialog('close');
                    sppdPribadiDg.datagrid('reload');
                }
            });

            if (row) {
                sppdPribadiForm.form('load', row);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            var sppdPribadiEl = $('#surat-tugas-index');
            sppdPribadiEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="surat-tugas-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="surat-tugas-dg"></table>'
            });

            //            var sppdPribadiEastEl = $('#surat-tugas-east');
            //            sppdPribadiEastEl.layout({
            //                fit: true,
            //                border: false
            //            }).layout('add', {
            //                title: 'Available Denom',
            //                region: 'south',
            //                split: false,
            //                content: '<table id="surat-tugas-denom-dg"></table>',
            //                collapsible: true,
            //                border: false,
            //                height: '50%'
            //            }).layout('add', {
            //                region: 'center',
            //                border: false,
            //                content: '<table id="surat-tugas-subsppdPribadi-dg"></table>'
            //            });

            sppdPribadiDg = $('#surat-tugas-dg');
            sppdPribadiDg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/surat-tugas' }),
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
                        { field: 'nip', title: 'NIP' },
                        { field: 'nama_tanpa_gelar', title: 'Nama' },
                    ]
                ],
                toolbar: [{
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        sppdPribadiFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        sppdPribadiFormDlg(sppdPribadiDg.datagrid('getSelected'));
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
                            sppdPribadiDg.datagrid('reload');
                        }
                    });
                }
            })
                .datagrid('enableFilter', [
                    yii.app.filter.customize(sppdPribadiDg, 'nip', 'equal'),
                    yii.app.filter.customize(sppdPribadiDg, 'nama_tanpa_gelar', 'contains', true),
                ])
                ;

            // var sppdPribadiSubsppdPribadiDg = $('#surat-tugas-subsppdPribadi-dg');
            // sppdPribadiSubsppdPribadiDg.datagrid({
            //     fit: true,
            //     border: false,
            //     emptyMsg: 'No Records Found.',
            //     columns: [
            //         [
            //             {field: 'ck', checkbox: true},
            //             {field: 'code', title: 'Type', width: '20%'},
            //             {field: 'name', title: 'Target', width: '20%'},
            //             {field: 'current_stock', title: 'Achieve', width: '20%', align: 'right'},
            //             {field: 'average', title: 'Gap', width: '20%', align: 'right'},
            //             {field: 'stock_days', title: 'Progress', width: '20%', align: 'right'}
            //         ]
            //     ],
            //     onLoadError: function (xhr) {
            //         yii.easyui.ajaxError(xhr, function (r) {
            //             if (r) {
            //                 sppdPribadiSubsppdPribadiDg.datagrid('reload');
            //             }
            //         });
            //     }
            // });

            //            var sppdPribadiDenosppdPribadiDg = $('#surat-tugas-denom-dg');
            //            sppdPribadiDenosppdPribadiDg.datagrid({
            //                fit: true,
            //                border: false,
            //                emptyMsg: 'No Records Found.',
            //                columns: [
            //                    [
            //                        {field: 'ck', checkbox: true},
            //                        {field: 'code', title: 'Denom', width: '20%'},
            //                        {field: 'name', title: 'Status', width: '20%'}
            //                    ]
            //                ],
            //                onLoadError: function (xhr) {
            //                    yii.easyui.ajaxError(xhr, function (r) {
            //                        if (r) {
            //                            sppdPribadiDenosppdPribadiDg.datagrid('reload');
            //                        }
            //                    });
            //                }
            //            });
        }
    };
})(window.jQuery);