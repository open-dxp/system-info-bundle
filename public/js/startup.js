opendxp.registerNS('opendxp.bundle.system_info.startup');

opendxp.bundle.system_info.startup = Class.create({
    user: null,
    toolbar: null,
    perspectiveConfig: null,

    initialize: function(){
        document.addEventListener(opendxp.events.preMenuBuild, this.preMenuBuild.bind(this));
    },

    preMenuBuild: function (event) {
        let menu = event.detail.menu;

        this.addSystemInfoMenu(menu);
    },

    addSystemInfoMenu: function (menu) {
        let that = this;
        const items = [];
        const user = opendxp.globalmanager.get('user');
        const perspectiveConfig = opendxp.globalmanager.get("perspective");

        if (user.admin && perspectiveConfig.inToolbar('extras.systemtools')) {
            menu.extras.items.some(function(item, index) {
                if (item.itemId === 'opendxp_menu_extras_system_info') {
                    if (perspectiveConfig.inToolbar('extras.systemtools.phpinfo')) {
                        menu.extras.items[index].menu.items.push({
                            text: t('bundle_systemInfo_php_info'),
                            iconCls: 'opendxp_nav_icon_php',
                            itemId: 'opendxp_menu_extras_system_info_php_info',
                            handler: that.showPhpInfo,
                            priority: 10,
                        });
                    }

                    if (perspectiveConfig.inToolbar('extras.systemtools.opcache')) {
                        menu.extras.items[index].menu.items.push({
                            text: t('bundle_systemInfo_php_opcache_status'),
                            iconCls: 'opendxp_nav_icon_reports',
                            itemId: 'opendxp_menu_extras_system_info_php_opcache_status',
                            handler: that.showOpcacheStatus,
                            priority: 20,
                        });
                    }
                }
            });
        }

        return items;
    },

    showPhpInfo: function () {
        opendxp.helpers.openGenericIframeWindow("phpinfo", Routing.generate('opendxp_bundle_systeminfo_settings_phpinfo'), "opendxp_icon_php", "PHP Info");
    },

    showOpcacheStatus: function () {
        opendxp.helpers.openGenericIframeWindow("opcachestatus", Routing.generate('opendxp_bundle_systeminfo_opcache_index'), "opendxp_icon_reports", "PHP OPcache Status");
    },
});

var bundle_system_info = new opendxp.bundle.system_info.startup();
