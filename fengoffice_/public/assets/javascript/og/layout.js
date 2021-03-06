Ext.onReady(function(){
	Ext.get("loading").hide();

	Ext.QuickTips.init();
	Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

	var menuItems = [{
			contentEl: 'menuOverview',
			title: lang('overview'),
			border: false,
			autoScroll: true,
			iconCls: 'ovrvw',
			collapsed: Cookies.get('overview_state') == 'true',
			listeners: {
				'expand': {
					fn: function() { Cookies.set('overview_state', 'false'); }
				},
				'collapse': {
					fn: function() { Cookies.set('overview_state', 'true'); }
				}
			}
		},
		{
			contentEl: 'menuFiles',
			title: lang('documents'),
			border: false,
			autoScroll: true,
			iconCls: 'fls',
			collapsed: Cookies.get('files_state') == 'true',
			listeners: {
				'expand': {
					fn: function() { Cookies.set('files_state', 'false'); }
				},
				'collapse': {
					fn: function() { Cookies.set('files_state', 'true'); }
				}
			}
		},
		{
			contentEl: 'menuProject',
			title: lang('project'),
			border: false,
			autoScroll: true,
			iconCls: 'prjct',
			collapsed: Cookies.get('projects_state') == 'true',
			listeners: {
				'expand': {
					fn: function() { Cookies.set('projects_state', 'false'); }
				},
				'collapse': {
					fn: function() { Cookies.set('projects_state', 'true'); }
				}
			}
		}];
	if (Ext.get('menuAdministration')) {
		menuItems[3] = {
			contentEl: 'menuAdministration',
			title: lang('administration'),
			border: false,
			autoScroll: true,
			iconCls: 'admnstrtn',
			collapsed: Cookies.get('administration_state') == 'true',
			listeners: {
				'expand': {
					fn: function() { Cookies.set('administration_state', 'false'); }
				},
				'collapse': {
					fn: function() { Cookies.set('administration_state', 'true'); }
				}
			}
		};
	}

	var viewport = new Ext.Viewport({
		layout: 'border',
		items: [
			new Ext.BoxComponent({
				region: 'north',
				el: 'header'
			}),
			new Ext.BoxComponent({
				region: 'south',
				el: 'footer'
			}),
			helpPanel = new Ext.Panel({
				region: 'east',
				id: 'help-panel',
				title: lang('help'),
				collapsible: true,
				collapsed: true,
				split: true,
				width: 225,
				minSize: 175,
				maxSize: 400,
				layout: 'fit',
				margins: '0 5 0 0',
				html: '<iframe id="helpFrame" src="help/index.html" style="width: 100%; height: 100%"></iframe>'
			 }),
			 {
				region: 'west',
				id: 'menu-panel',
				title: lang('menu'),
				split: true,
				width: 200,
				minSize: 175,
				maxSize: 400,
				collapsible: true,
				margins: '0 0 0 0',
				layout: 'accordion',
				layoutConfig: {
					animate:true/*,
					fill: false*/
				},
				items: menuItems
					
			},
			contentPanel = new Ext.TabPanel({
				activeTab:0,
				items:[{
					layout: 'fit',
					title: Ext.getDom('pageTitle').innerHTML,
					closable:true,
					autoScroll:true,
					listeners: {
						'activate': function() {
							if (window.onresize) {
								window.onresize();
							}
						}
					},
					items:[{
						contentEl:'content',
						autoScroll: true
					}]
				}],
				id: 'contentPanel',
				region:'center',
				plugins: new og.TabCloseMenu()
			})
		 ]
	});
	
	contentPanel.on('resize', function() {
		if (window.onresize) {
			window.onresize();
		}
	});
	
	// link context menu
	linkContextMenu = new Ext.menu.Menu({
		id: 'linkContextMenu',
		items: [{
			text: lang('open link'),
			handler: function() {
				linkContextMenu.contextItem.onclick();
				if (linkContextMenu.contextItem.confirmed) {
					og.openLink(linkContextMenu.contextItem.href);
				}
			},
			iconCls: 'admnstrtn'
		},{
			text: lang('open in new tab'),
			handler: function() {
				linkContextMenu.contextItem.onclick();
				if (linkContextMenu.contextItem.confirmed) {
					og.openLink(linkContextMenu.contextItem.href, null, true);
				}
			},
			iconCls: 'fls'
		}]
	});
    
    og.captureLinks();
});


og.showHelp = function() {
	helpPanel.toggleCollapse();
}

og.captureLinks = function(div) {
	var links = Ext.select((div?"#" + div + " ":"") + "a.internalLink");
	links.each(function() {
		var onclick = this.dom.onclick;
		this.dom.onclick = function() {
			if (onclick && !onclick()) {
				this.confirmed = false;
			} else {
				this.confirmed = true;
			}
		};
		this.on('click', function(e) {
				if (!e.target.confirmed) {
					return;
				}
				if (e.ctrlKey) {
					og.openLink(e.target.href, null, true);
				} else {
					og.openLink(e.target.href);
				}
			}, this, {stopEvent: true});
		this.on('contextmenu', function(e) {
				linkContextMenu.contextItem = e.target;
				linkContextMenu.show(e.target)
			}, this, {stopEvent: true});
	});
	links = Ext.select((div?"#" + div + " ":"") + "form.internalForm");
	links.each(function() {
		var onsubmit = this.dom.onsubmit;
		this.dom.onsubmit = function() {
			if (onsubmit && !onsubmit()) {
				return false;
			} else {
				var params = Ext.Ajax.serializeForm(this);
				og.openLink(this.action, params);
			}
			return false;
		}
	});
}


og.openLink = function(url, params, newTab) {
	if (newTab) {
		var panel = new Ext.Panel({
			closable: true,
			autoScroll: true,
			layout: 'fit',
			listeners: {
				'activate': function() {
					if (window.onresize) {
						window.onresize();
					}
				}
			}
		});
		contentPanel.add(panel);
		contentPanel.activate(panel);
	}
	//contentPanel.add(new Ext.Panel({closable: true, autoScroll: true, html: params, title: "Params"}));
	if (contentPanel.items.length <= 0) {
		og.openLink(url, null, true);
		return;
	}
	
	var panel = contentPanel.getActiveTab();
	while (panel.getComponent(0)) {
		panel.remove(panel.getComponent(0));
	}
	
	if (url.indexOf('?c=files&a=index') >= 0) {
		og.browse(url.substring(url.indexOf('?c=files&a=index')));
	} else {
		og.loadHTML(url, params);
	}
}

og.browse = function(filter, newTab) {
	var fm = new og.FileManager(filter);
	var panel = contentPanel.getActiveTab();

	panel.add(fm);
	panel.setTitle(lang('documents'));
	panel.doLayout();
}

og.upload = function() {
	var uf = new og.UploadFile();
	var panel = contentPanel.getActiveTab();
	panel.add(uf);
	panel.setTitle(lang('upload'));
	panel.doLayout();
}

og.loadHTML = function(url, params) {
	var p = new Ext.Panel({autoScroll: true});
	var panel = contentPanel.getActiveTab();
	panel.setTitle(lang('loading...'));
	panel.add(p);
	panel.doLayout();
	p.load({
		url: url + "&ajax=true",
		callback: function(elem, success) {
			if (!success) {
				og.msg(lang("error loading content"));
			} else {
				var h1 = Ext.select("#" + elem.id + " .pageTitle").first();
				if (h1) {
					panel.setTitle(h1.dom.innerHTML);
				} else {
					panel.setTitle(lang('new tab'));
				}
				og.captureLinks(elem.id);
				if (window.onresize) {
					window.onresize();
				}
			}
		},
		params: params,
		text: lang("loading..."),
		scripts: true
	});
}


og.debug = function(obj) {
	var win;
	var s = "";
	for (var k in obj) {
		s += ", " + k;
	}
	if (!win) {
		win = new Ext.Window({
			title: 'Debug',
	        layout:'fit',
	        width:500,
	        height:300,
	        closeAction:'hide',
	        plain: true,
	        
	        items: new Ext.form.TextArea({
	            value: s
	        }),
	
	        buttons: [{
	            text: 'Close',
	            handler: function(){
	                win.hide();
	            }
	        }]
	    });
	}
	win.show();
}

