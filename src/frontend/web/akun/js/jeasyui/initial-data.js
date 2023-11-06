window.yii.app.initialData = (function ($) {
    var uploadFrm;
    var initFile;
    var initLog;
    var color = {
        success: '#449d44',
        error: '#b52b27',
        warning: '#e68900',
    };
    return {
        isActive: false,
        init: function () {
            var jabatanDaerahEl = $('#initial-data-index');
            jabatanDaerahEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                region: 'north',
                border: false,
                content: '<form id="initial-data-frm" enctype="multipart/form-data" method="post"><input id="initial-data-file" type="text" style="width:200px" name="fileInit">&nbsp;<button class="l-btn l-btn-small" group=""><span class="l-btn-left l-btn-icon-left"><span class="l-btn-text">Upload</span><span class="l-btn-icon icon-upload">&nbsp;</span></span></button></form>',
                height: 32
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="initial-data-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<div id="initial-data-log"></div>'
            });

            uploadFrm = $('#initial-data-frm').form({
                url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                    r: 'v1/upload/initial-data'
                }, true),
                iframe: false,
                success: function (data) {
                    var res = eval('(' + data + ')');
                    if (res.success) {
                        //$.messager.alert('Upload', 'Upload file is success', 'info');
                        initFile.filebox('clear');
                    }
                    $.each(res.message, function (k, v) {
                        $.each(v, function (kk, vv) {
                            initLog.prepend('<div style="color: ' + color[k] + '">' + vv + '</div>');
                        });
                    });

                },
                onSubmit: function (param) {
                    if (!initFile.filebox('files').length) {
                        $.messager.alert('Upload', 'Silahkan pilih file yang akan diupload.', 'error');
                        return false;
                    }
                    initLog.prepend('<div style="color: red">Sedang upload...</div>');
                    //param[yii.getCsrfParam()] = yii.getCsrfToken();
                }
            });

            initFile = $('#initial-data-file').filebox({
                accept: '.xlsx',
                buttonText: 'Excell File',
                buttonIcon: 'icon-excel',
                required: true,
                width:300,
                icons: [{
                    iconCls: 'icon-clear',
                    handler: function (e) {
                        initFile.box('clear');
                    }
                }]
            });

            initLog = $('#initial-data-log');
        }
    };
})(window.jQuery);