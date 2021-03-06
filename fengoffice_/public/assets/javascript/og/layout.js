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

	contentPanel = new Ext.TabPanel({
		id: 'contentPanel',
		region:'center',
		plugins: new og.TabCloseMenu(),
		listeners: {
			resize: function() {
				if (window.onresize) {
					window.onresize();
				}
			}
		}
	});

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
			contentPanel
		 ]
	});
	
	// link context menu
	linkContextMenu = new Ext.menu.Menu({
		id: 'linkContextMenu',
		items: [{
			text: lang('open link'),
			handler: function() {
				og.openLink(linkContextMenu.contextItem.href);
			},
			iconCls: 'admnstrtn'
		},{
			text: lang('open in new tab'),
			handler: function() {
				og.openLink(linkContextMenu.contextItem.href, null, true);
			},
			iconCls: 'fls'
		}]
	});
    
    og.captureLinks();
    
    if (og.initialURL) {
    	og.openLink(og.initialURL);
    }
});


og.showHelp = function() {
	helpPanel.toggleCollapse();
}

og.captureLinks = function(div) {
	var links = Ext.select((div?"#" + div + " ":"") + "a.internalLink");
	links.each(function() {
		var onclick = this.dom.onclick;
		this.dom.onclick = function(e) {
			if (!e) e = window.event;
			if (!onclick || onclick()) {
				if (typeof e.ctrlKey == 'undefined') {
					if (e.modifiers & Event.CONTROL_MASK) {
						e.ctrlKey = true;
					} else {
						e.ctrlKey = false;
					}
				}
				if (e.ctrlKey) {
					og.openLink(this.href, null, true);
				} else {
					og.openLink(this.href);
				}
			}
			return false;
		};
		this.dom.oncontextmenu = function(e) {
			if (!e) e = window.event;
			if (!onclick || onclick()) {
				linkContextMenu.contextItem = this;
				linkContextMenu.show(this);
			}
			return false;
		}
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
		og.openLink(url, params, true);
		return;
	}
	
	var panel = contentPanel.getActiveTab();
	while (panel.getComponent(0)) {
		panel.remove(panel.getComponent(0));
	}
	
	// this chekcs will be formalized later
	if (url.indexOf('c=files') >= 0 && url.indexOf('a=index') >= 0 || url.indexOf('c=files') >= 0 && url.indexOf('a=') < 0) {
		og.browse(url.substring(url.indexOf('?c=files&a=index')));
	} else {
		og.loadHTML(url, params);
	}
}

og.browse = function(filter) {
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
		url: og.makeAjaxUrl(url),
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
	var s = "hola";
	for (var k in obj) {
		s += k + " = " + obj[k] + "\n";
	}
	var ta = new Ext.form.TextArea();
	if (!win) {
		win = new Ext.Window({
			title: 'Debug',
	        layout:'fit',
	        width:500,
	        height:300,
	        closeAction:'hide',
	        plain: true,
	        
	        items: [ta],
	
	        buttons: [{
	            text: 'Close',
	            handler: function(){
	                win.hide();
	            }
	        }]
	    });
	}
	ta.setValue(s);
	win.show();
}

