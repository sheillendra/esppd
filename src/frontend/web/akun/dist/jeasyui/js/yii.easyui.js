window.yii.easyui = (function ($) {
    var hosts = {};
    var maintabEl;
    var maintab;
    var mainMask = $('.main-mask');
    var globalError = $('#global-error');
    var navigation;
    /**
     * 
     * @param function getNavigationByTab
     * @param function selectNavigationByTab
     * @param function selectNavigationFirstTime
     * @param function createTabFirstTime
     * @return {undefined}
     */
    var initMainTab = function (getNavigationByTab, selectNavigationByTab, selectNavigationFirstTime, createTabFirstTime) {
        maintab.tabs({
            fit: true,
            border: !1,
            onSelect: function (t, i) {
                maintabOnSelect(t, i, getNavigationByTab, selectNavigationByTab);
            },
            onUnselect: function (t, i) {

            },
            onAdd: function (title, index) {
                maintabEl
                    //.tabs-header
                    .children[0]
                    //.tabs-wrap
                    .children[2]
                    //ul.tabs
                    .children[0]
                    //li
                    .children[index]
                    //a.tabs-inner
                    .children[0].onmousedown = function () {
                        clickTab(this, title, index, getNavigationByTab, selectNavigationByTab);
                        return false;
                    };

                updateFirstTabClosableState();
                runTabInit();
            },
            onLoad: function (panel) {
                runTabInit();
            },
            onClose: function (t, i) {
                updateFirstTabClosableState();
            }
        });

        //pemilihan navigasi pertama kali
        if (yii.easyui.tabOptions && yii.easyui.tabOptions.title) {
            //jika selectedNav tidak ada di navigation, seperti profile dll
            //pending, pake cara ini pembuatan gridview ada masaalah
            //coba lihat config yang dibuat denagn cara normal dan pake di sini
            //supaya ketahuan mana config yang harus ada
            yii.easyui.createTab(yii.easyui.tabOptions, yii.easyui.selectedNav);
            yii.easyui.hideMainMask();
            delete yii.easyui.tabOptions;
        } else {
            var navSelected = selectNavigationFirstTime(yii.easyui.selectedNav);
            if (navSelected !== undefined && navSelected) {
                createTabFirstTime(navSelected);
            } else {
                yii.easyui.hideMainMask();
                $.messager.alert('Error', yii.easyui.t.navigationNotFound, 'error');
            }
        }
        return true;
    };

    var clickTab = function (_this, title, index, getNavigationByTab, selectNavigationByTab) {
        if (!_this.parentElement.classList.contains('tabs-selected')) {
            var li = _this.parentElement.parentElement.children;
            for (var i = 0; i < li.length; i++) {
                if (li[i].classList.contains('tabs-selected')) {
                    li[i].classList.remove('tabs-selected');
                }
            }
            _this.parentElement.classList.add('tabs-selected');

            // mencari index yang sekarang, karena param index akan 
            // tidak sesuai kalau ada yang dihapus
            var liIndex = 0;
            for (var i = 0; i < li.length; i++) {
                if (li[i].classList.contains('tabs-selected')) {
                    liIndex = i;
                }
            }
            var tabPanels = li[0].parentElement.parentElement.parentElement.nextSibling.children;
            for (var i = 0; i < li.length; i++) {
                if (!tabPanels[i].hidden) {
                    tabPanels[i].style.display = 'none';
                }
            }
            tabPanels[liIndex].style.display = 'block';

            maintabOnSelect(title, index, getNavigationByTab, selectNavigationByTab);
        }
    };

    var runTabInit = function () {
        if (yii.easyui.tabInit !== undefined && typeof yii.easyui.tabInit === 'function') {
            yii.easyui.tabInit();
            yii.easyui.tabInit = function () {
                return;
            };
        }
    };

    var maintabOnSelect = function (t, i, getNavigationByTab, selectNavigationByTab) {
        var tab = maintab.tabs('getTab', i) || maintab.tabs('getTab', t);
        var options = tab.panel('options');
        if (options.href) {
            window.history.replaceState('', t, decodeURIComponent(options.href));
        } else if (options.data && options.data.url) {
            window.history.replaceState('', t, decodeURIComponent(options.data.url));
        }
        document.title = t;
        selectNavigationByTab(getNavigationByTab(options.data.nav));
    };

    /**
     * Jika tab cuma satu, tombol close di tab tidak muncul
     * @return {Boolean}
     * @since v2.0.0
     */
    var updateFirstTabClosableState = function () {
        var tabs = maintab.find('.tabs-header .tabs li');
        var firstTab = $(tabs[0]);
        var closeTab = firstTab.find('.tabs-close');
        var tabsTitle = firstTab.find('.tabs-title');
        var tabsPTool = firstTab.find('.tabs-p-tool');
        if (tabs.length > 1) {
            closeTab.show();
            tabsTitle.css('padding-right', '20px').addClass('tabs-closable');
            tabsPTool.attr('style', '');
        } else {
            closeTab.hide();
            tabsTitle.css('padding-right', '9px').removeClass('tabs-closable');
            tabsPTool.css('right', '5px');
        }
        return true;
    };

    var initNavigationTree = function () {
        navigation.tree({
            lines: false,
            data: yii.easyui.navItem,
            onClick: function (node) {
                if (node.attributes && node.attributes.url) {
                    yii.easyui.showMainMask();
                    var tabOptions = {
                        title: node.attributes.title || node.text,
                        href: node.attributes.url,
                        iconCls: node.iconCls
                    };
                    if (typeof node.attributes.params === 'function') {
                        tabOptions.queryParams = node.attributes.params();
                    } else if (typeof node.attributes.params === 'object') {
                        tabOptions.queryParams = node.attributes.params;
                    }
                    yii.easyui.createTab(tabOptions, node.id);
                }
            }
        });

        initMainTab(function (id) {
            return navigation.tree('find', id);
        }, function (nav) {
            //select tree
            if (nav) {
                navigation.tree('select', nav.target);
            }
        }, function (navSelected) {
            //selectNavigationFirstTime for tree
            return navigation.tree('find', navSelected);
        }, function (navSelected) {
            //createTabFirstTime for tree
            var localOptions = {
                title: navSelected.attributes.title || navSelected.text,
                iconCls: navSelected.iconCls
            };
            if (yii.easyui.tabOptions && yii.easyui.tabOptions.content) {
                localOptions.content = yii.easyui.tabOptions.content;
                if (localOptions.data === undefined) {
                    localOptions.data = {};
                }
                localOptions.data.url = navSelected.attributes.url;
                yii.easyui.hideMainMask();
            } else {
                localOptions.href = navSelected.attributes.url;
            }
            yii.easyui.createTab(localOptions, navSelected.id);
        });
    };

    var initNavigationAccordion = function () {
        navigation.accordion({
            border: !1,
            fit: !0
        });

        var createAccordionContent = function (itemNav, accordion, parentText) {
            var content = '';
            parentText = parentText || '';
            if (parentText) {
                parentText += ' - ';
            }
            itemNav.title = accordion;
            if (itemNav.children) {
                $.each(itemNav.children, function (k, v) {
                    if (v.children) {
                        content += createAccordionContent(v, accordion, parentText + v.text);
                    } else {
                        content += '<a data-accordion="' + itemNav.title +
                            '" id="' + v.id +
                            '" data-icon="' + v.iconCls +
                            '" data-url="' + v.attributes.url +
                            '" data-tabtitle="' + (v.attributes.title || v.text);
                        if (v.attributes.params) {
                            content += '" data-params="' + v.attributes.params;
                        }

                        content += '" class="nav-btn">' + parentText + v.text + '</a>';
                    }
                });
            } else {
                content += '<a data-accordion="' + itemNav.title +
                    '" id="' + itemNav.id +
                    '" data-icon="' + itemNav.iconCls +
                    '" data-url="' + itemNav.attributes.url +
                    '" data-tabtitle="' + (itemNav.attributes.title || itemNav.text) +
                    '" class="nav-btn">' + itemNav.text + '</a>';
            }
            return content;
        };

        $.each(yii.easyui.navItem, function (k, v) {
            if (v.visible === undefined || v.visible) {
                v.content = createAccordionContent(v, v.text);
                if (v.children === undefined) {
                    delete v.id;
                }
                navigation.accordion('add', v);
            }
        });

        $.each($('.nav-btn'), function (k, v) {
            $(v).linkbutton({
                toggle: !0,
                group: 'g1',
                iconCls: v.dataset.icon,
                onClick: function () {
                    yii.easyui.showMainMask();
                    var tabOptions = {
                        title: v.dataset.tabtitle,
                        href: v.dataset.url,
                        iconCls: v.dataset.icon
                    };

                    if (v.dataset.params) {
                        var params;
                        eval('params = ' + v.dataset.params);
                        if (typeof params === 'function') {
                            tabOptions.queryParams = params();
                        } else if (typeof params === 'object') {
                            tabOptions.queryParams = params;
                        }
                    }
                    yii.easyui.createTab(tabOptions, v.id);
                }
            });
        });

        initMainTab(function (id) {
            return document.getElementById(id);
        }, function (nav) {
            if (nav !== undefined && nav && !nav.classList.contains('l-btn-selected')) {
                navigation.find('.l-btn-selected').removeClass('l-btn-selected');
                nav.classList.add('l-btn-selected');
                navigation.accordion('select', nav.dataset.accordion);
            }
        }, function (navSelected) {
            //selectNavigationFirstTime
            return document.getElementById(navSelected);
        }, function (navSelected) {
            //createTabFirstTime
            var options = {
                title: navSelected.dataset.tabtitle,
                iconCls: navSelected.dataset.icon
            };
            if (yii.easyui.tabOptions && yii.easyui.tabOptions.content) {
                options.content = yii.easyui.tabOptions.content;
                if (options.data === undefined) {
                    options.data = {};
                }
                options.data.url = navSelected.dataset.url;
                yii.easyui.hideMainMask();
            } else {
                options.href = navSelected.dataset.url;
            }

            yii.easyui.createTab(options, yii.easyui.selectedNav);
        });

    };

    var initNorthUserMenu = function () {
        var northUserMenu = $('#north-user-menu');
        northUserMenu.menu({});
        var parentItem = {};
        $.each(yii.easyui.northUserMenu, function (k, v) {
            if (v.parent !== undefined) {
                if (parentItem[v.parent] === undefined) {
                    parentItem[v.parent] = northUserMenu.menu('findItem', v.parent);
                }
                if (parentItem[v.parent]) {
                    v.parent = parentItem[v.parent].target;
                } else {
                    return false;
                }
            }
            northUserMenu.menu('appendItem', v);
        });

        $('#north-user-menu-btn').menubutton({
            text: yii.easyui.username,
            iconCls: 'icon-user',
            menu: northUserMenu
        });
    };

    return {
        isActive: false,
        westContent: '',
        northContent: '',
        centerContent: '',
        southContent: '',
        reference: {},
        init: function () {

            if (yii.easyui.errorName) {
                yii.easyui.hideMainMask();
                $.messager.alert(yii.easyui.errorName, yii.easyui.errorMessage, 'error', function () {
                    window.location = yii.easyui.homeUrl;
                });
                return false;
            }

            /**
             * tampilkan indicator setelah klik link dan 
             * data dari server belum diterima, biar lebih frendly
             * 
             * @param {type} e
             * @return {undefined}
             */
            window.onbeforeunload = function (e) {
                yii.easyui.showMainMask();
            };

            $('body').layout({
                fit: !0,
                border: !1
            }).layout('add', {
                region: 'north',
                content: yii.easyui.northContent,
                collapsible: !1,
                border: !1,
                height: 40
            }).layout('add', {
                title: yii.easyui.westTitle,
                region: 'west',
                iconCls: yii.easyui.westIcon,
                split: !0,
                width: 200,
                content: yii.easyui.westContent,
                hideCollapsedContent: !1,
                onCollapse: function () {
                    yii.easyui.cookie.set('west-collapsed', 1);
                },
                onExpand: function () {
                    yii.easyui.cookie.set('west-collapsed', 0);
                }
            }).layout('add', {
                region: 'south',
                content: yii.easyui.southContent,
                border: !1
            }).layout('add', {
                region: 'center',
                content: yii.easyui.centerContent
            });
            delete yii.easyui.northContent;
            delete yii.easyui.westContent;
            delete yii.easyui.southContent;
            delete yii.easyui.centerContent;

            //            if (window.innerWidth < 1281 || ~~(yii.easyui.cookie.get('west-collapsed'))) {
            //                $('body').layout('collapse', 'west');
            //            }

            initNorthUserMenu();

            navigation = $('#navigation');
            maintabEl = document.getElementById('maintab');
            maintab = $(maintabEl);
            if (yii.easyui.sidebarPlugin === 'tree') {
                initNavigationTree();
            } else {
                initNavigationAccordion();
            }

            delete yii.easyui.selectedNav;
            delete yii.easyui.errorName;
            delete yii.easyui.errorMessage;
        },
        getTabHeader: function (title) {
            var li = maintabEl
                //.tabs-header
                .children[0]
                //.tabs-wrap
                .children[2]
                //ul.tabs
                .children[0]
                //li
                .children;
            for (var i = 0; i < li.length; i++) {
                if (li[i].children[0].children[0].innerText === title) {
                    return li[i];
                }
            }

            return null;
        },
        createTab: function (options, nav) {

            if (window.innerWidth < 1281 || ~~(yii.easyui.cookie.get('west-collapsed'))) {
                $('body').layout('collapse', 'west');
            }

            var existsTab = yii.easyui.getTabHeader(options.title);
            if (existsTab) {
                clickTab(
                    existsTab.children[0],
                    options.title,
                    null,
                    function () {
                        return false;
                    },
                    function () {
                        return false;
                    }
                );

                //fungsi select bawaannya sangat lambat karena me-resize semua
                //element, diganti dengan clickTab di atas
                //maintab.tabs('select', options.title);

                //hide dari click accordion
                yii.easyui.hideMainMask();
            } else {
                if (options.data === undefined) {
                    options.data = {};
                }
                options.closable = true;
                options.data.nav = nav;
                options.onLoadError = function (xhr) {
                    var tab = maintab.tabs('getSelected');
                    if (xhr.readyState === 0) {
                        yii.easyui.hideMainMask();
                        $.messager.confirm('Error', yii.easyui.t.connectionErrorRetryNow, function (value) {
                            if (value) {
                                yii.easyui.showMainMask();
                                tab.panel('refresh');
                            } else {
                                var localOptions = tab.panel('options');
                                localOptions.content = yii.easyui.t.connectionError;
                                localOptions.data.url = localOptions.href;
                                delete localOptions.href;
                                maintab.tabs('update', { tab: tab, options: localOptions });
                            }
                            return;
                        });
                    } else {
                        var localOptions = tab.panel('options');
                        localOptions.content = xhr.responseText;
                        localOptions.data.url = localOptions.href;
                        delete localOptions.href;
                        maintab.tabs('update', { tab: tab, options: localOptions });
                        yii.easyui.hideMainMask();
                    }
                };

                if (options.tools === undefined) {
                    options.tools = [
                        {
                            iconCls: 'icon-mini-refresh',
                            handler: function () {
                                var tabOwner = this.parentElement.parentElement;
                                if (tabOwner.classList.contains('tabs-selected')) {
                                    var tab = maintab.tabs('getSelected');
                                    var tabOptions = tab.panel('options');
                                    if (tabOptions.href) {
                                        tab.panel('refresh');
                                    } else {
                                        tab.panel('refresh', tabOptions.data.url);
                                    }
                                }
                            }
                        }
                    ];
                }
                maintab.tabs('add', options);
            }
        },
        maintabEl: function () {
            return maintabEl;
        },
        maintab: function () {
            return maintab;
        },
        activeAjax: function (route, id, data, title, reloadCallback, reload) {
            if (reload === undefined) {
                reload = true;
            }
            yii.easyui.showMainMask();
            $.ajax({
                url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                    r: route,
                    id: id
                }, true),
                type: 'POST',
                data: data,
                success: function (res) {
                    if (reload) {
                        reloadCallback();
                    }
                    yii.easyui.hideMainMask();
                    if (res.message !== undefined) {
                        $.messager.alert(title || yii.easyui.t.message, res.message, res.success ? 'info' : 'error');
                    }
                },
                error: function (xhr) {
                    yii.easyui.hideMainMask();
                    yii.easyui.ajaxError(xhr, function (r) {
                        if (r) {
                            activeAjax(route, id, data, title, reloadCallback, reload);
                        }
                    });
                }
            });
        },
        setHost: function (application, host) {
            hosts[application] = host;
        },
        getHost: function (application) {
            return hosts[application];
        },
        ajaxAuthToken: function (data, queryParam) {
            data = data || {};
            var token = window.localStorage.getItem('token');
            if (token) {
                data['access-token'] = window.localStorage.getItem('token');
                if (queryParam) {
                    return '?' + $.param(data);
                }
                return data;
            }
            yii.handleAction($('<a href="' + yii.easyui.logoutUrl + '" data-method="post"></a>'));
        },
        /**
         * example :
         *  error: function (xhr) {
         *      return yii.easyui.ajaxError(xhr, function (res) {
         *          if (res) {
         *              return dailySales(route, load);
         *          }
         *          return false;
         *      });
         *  }
         *  
         * @param {object} xhr
         * @param {function} fn callback of confirm if true
         * @return {undefined}
         */
        ajaxError: function (xhr, fn, message) {
            yii.easyui.hideMainMask();
            fn = fn || function () {
                return false;
            };
            message = message || yii.easyui.t.tryAgain;
            var opt = {
                cancel: yii.easyui.t.close,
                ok: message,
                fn: fn
            };

            if (xhr.readyState === 0) {
                opt.title = yii.easyui.t.connectionError;
                opt.msg = yii.easyui.t.connectionIsRefused;

            } else if (xhr.status === 401) {
                //masalah biasanya token dibrowser sudah hilang, tapi session di
                //web masih login.
                yii.handleAction($('<a href="' + yii.easyui.logoutUrl + '" data-method="post"></a>'));
                return;
            } else {
                if (typeof xhr.responseJSON === 'object') {
                    if (xhr.responseJSON.name) {
                        opt.title = xhr.responseJSON.name;
                        opt.msg = xhr.responseJSON.message;
                        if (xhr.responseJSON.file) {
                            opt.msg += ' file: ' + xhr.responseJSON.file + ' line: ' + xhr.responseJSON.line;
                        }
                    } else {
                        return $.messager.alert(xhr.statusText, xhr.responseJSON[0].message, 'error');
                    }
                } else {
                    opt.title = xhr.statusText + ' (#' + xhr.status + ')';
                    opt.msg = xhr.responseText;
                }
            }
            $.messager.confirm(opt);
        },
        showError: function (e) {
            var content = e.responseText !== undefined ? e.responseText : e;
            if (typeof content === 'object') {
                var temp = [];
                $.each(content, function (k, v) {
                    temp.push(v);
                });
                content = temp.join(', ');
            }
            globalError.dialog({
                title: 'Error',
                modal: true,
                minWidth: 300,
                minHeight: 200,
                maxWidth: window.innerWidth - 50,
                maxHeight: window.innerHeight - 50,
                content: content
            });
        },
        currencyFormatter: function (value, row, index) {
            if (value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            return 0;
        },
        dateBoxFormatter: function (date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            //return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
            return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
        },
        dateBoxParser: function (s) {
            if (!s) {
                return new Date();
            }
            var ss = (s.split('-'));
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(d, m - 1, y);
            } else {
                return new Date();
            }
        },
        defaults: {
            validatebox: {
                minLength: function () {
                    if ($.fn.validatebox.defaults.rules.minLength === undefined) {
                        $.fn.validatebox.defaults.rules.minLength = {
                            validator: function (value, param) {
                                return value.length >= param[0];
                            },
                            message: 'Please enter at least {0} characters.'
                        };
                    }
                },
                equals: function () {
                    if ($.fn.validatebox.defaults.rules.equals === undefined) {
                        $.fn.validatebox.defaults.rules.equals = {
                            validator: function (value, param) {
                                return value === $(param[0]).val();
                            },
                            message: 'Field do not match.'
                        };
                    }
                }
            },
            pagination: {
                displayMsg: function (msg) {
                    msg = msg || '{from} - {to} of {total}';
                    if (msg === 'reset') {
                        msg = 'Displaying {from} to {to} of {total} items';
                    }
                    $.fn.pagination.defaults.displayMsg = msg;
                },
                last: function () {
                    $.fn.pagination.defaults.last = {};
                }
            }
        },
        defaultDgOptions: {
            fit: !0,
            striped: !0,
            border: !1,
            method: 'get',
            rownumbers: !0,
            pagination: !0,
            checkOnSelect: !1,
            selectOnCheck: !1,
            singleSelect: !0,
            emptyMsg: 'No Records Found',
            onLoadSuccess: function (data) {
                $(this).datagrid('selectRow', 0);
                yii.easyui.hideMainMask();
            },
            onLoadError: function (e) {
                yii.easyui.hideMainMask();
            }
        },
        showMainMask: function () {
            mainMask.css('display', 'block');
        },
        hideMainMask: function () {
            mainMask.css('display', 'none');
        },
        cookie: {
            set: function (name, value, days, path) {
                days = days || 1;
                path = path || '';
                var expires = '';
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 86400000)); //24 * 60 * 60 * 1000
                    expires = "; expires=" + date.toGMTString();
                }
                document.cookie = name + "=" + value + expires + "; path=/" + path;
            },
            get: function (name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ')
                        c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0)
                        return c.substring(nameEQ.length, c.length);
                }
                return null;
            },
            delete: function (name, path) {
                yii.easyui.cookie.set(name, "", -1, path);
            }
        },
        requiredSelectedRow: function (row) {
            if (row) {
                return true;
            }
            $.messager.alert(yii.easyui.t.warning, yii.easyui.t.noSelectedData, 'warning');
            return false;
        },
        t: {
            close: 'Close',
            connectionError: 'Connection error',
            connectionErrorRetryNow: 'Connection error, retry now?',
            connectionIsRefused: 'Connection is refused',
            message: 'Message',
            navigationNotFound: 'Navigation not found',
            noSelectedData: 'No selected data',
            tryAgain: 'Try Again',
            warning: 'Warning',
        }
    };
})(window.jQuery);
