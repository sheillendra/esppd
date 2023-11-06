window.yii.easyuiLogin = (function ($) {
    var elUsername;
    var elPassword;
    var elCaptcha;
    var elForm;
    var elOkBtn;
    return {
        isActive: false,
        init: function () {
            window.localStorage.removeItem('token');
            $('#login-dialog').dialog({
                title: yii.easyuiLogin.dialogTitle,
                width: window.innerWidth < yii.easyuiLogin.dialogWidth ? window.innerWidth - 10 : yii.easyuiLogin.dialogWidth,
                height: yii.easyuiLogin.dialogHeight,
                content: yii.easyuiLogin.content,
                closable: !1,
                minimizable: !1,
                maximizable: !1,
                collapsible: !1,
                draggable: !1,
                resizable: !1,
                iconCls: 'icon-lock',
                toolbar: yii.easyuiLogin.header,
                buttons: '#login-btn'
            });

            elUsername = $(yii.easyuiLogin.usernameSelector);
            elPassword = $('#loginform-password');
            elCaptcha = $('#loginform-verifycode');
            elForm = $('#login-form');
            elOkBtn = $('#login-btn-ok');

            elUsername.textbox({
                prompt: 'Username',
                required: 1,
                fit: true
            }).textbox('textbox').bind('keydown', function (e) {
                if (e.keyCode === 13) {
                    elForm.form('submit');
                }
                e.stopPropagation();
            });
            elUsername.textbox('textbox').attr('autocomplete', 'on');

            elPassword.passwordbox({
                prompt: 'Password',
                required: 1,
                fit: true
            }).passwordbox('textbox').bind('keydown', function (e) {
                if (e.keyCode === 13) {
                    elForm.form('submit');
                }
                e.stopPropagation();
            });
            
            //elCaptcha.textbox({
            //    prompt: 'Verify Code',
            //    required: 1,
            //    fit: true,
            //    buttonText: elCaptcha[0].dataset.img,
            //    validType: 'captcha'
            //}).textbox('textbox').bind('keydown', function (e) {
            //    if (e.keyCode === 13) {
            //        elForm.form('submit');
            //    }
            //    e.stopPropagation();
            //});
            
            elForm.form({
                url: yii.easyuiLogin.url,
                novalidate: true,
                onSubmit: function () {
                    $(this).form('enableValidation');
                    if (!$(this).form('validate')) {
                        return false;
                    }
                    //return false;
                    elOkBtn.linkbutton({iconCls: 'icon-lock', disabled: true});
                },
                success: function (res) {
                    res = JSON.parse(res);

                    try {
                        if (res.data) {
                            for (var key in res.data) {
                                window.localStorage.setItem(key, res.data[key]);
                            }
                        }
                    } catch (e) {
                        $.messager.alert('Application', 'Application no support storage, maybe you run in private mode browser.', 'error');
                    }

                    if (res.redirect) {
                        window.location = res.redirect;
                        return;
                    }
                    elOkBtn.linkbutton({iconCls: 'icon-ok', disabled: false});
                    if (res.loginerror) {
                        var message = '';
                        for (var k in res.loginerror) {
                            if (typeof res.loginerror[k] === 'object') {
                                for (var kk in res.loginerror[k]) {
                                    message += res.loginerror[k][kk];
                                }
                            }else{
                                message = res.loginerror[k];
                            }
                            
                        }
                        $.messager.alert('Login', message, 'error', () => {
                            elUsername.textbox('textbox').focus();
                        });
                    }
                },
                error: function () {
                    elOkBtn.linkbutton({iconCls: 'icon-ok'});
                }
            });

            elOkBtn.linkbutton({
                iconCls: 'icon-ok',
                text: 'Login',
                onClick: function () {
                    elForm.form('submit');
                }
            });

            $('#login-btn-reset').linkbutton({
                iconCls: 'icon-cancel',
                text: 'Reset',
                onClick: function () {
                    elUsername.textbox({value: ''});
                    elPassword.passwordbox({value: ''});
                }
            });

            elUsername.textbox('clear').textbox('textbox').focus();
            
        },
        content: ''
    };
})(window.jQuery);

$.extend($.fn.validatebox.defaults.rules, {
    justText: {
        validator: function (value, param) {
            return !value.match(/[0-9]/);
        },
        message: 'Please enter a text.'
    },
    captcha: {
        validator: function (value, param) {
            console.log($('body').data());
            //var hash = $('body').data(options.hashKey);
            //hash = hash == null ? options.hash : hash[options.caseSensitive ? 0 : 1];
            //var v = options.caseSensitive ? value : value.toLowerCase();
            //for (var i = v.length - 1, h = 0; i >= 0; --i) {
            //    h += v.charCodeAt(i);
            //}
            //if (h != hash) {
            //    pub.addMessage(messages, options.message, value);
            //}
        },
        message: 'Captcha'
    }
});
