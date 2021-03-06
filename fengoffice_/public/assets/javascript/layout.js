Ext.onReady(function(){
	Ext.QuickTips.init();
	Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

	var menuItems = [{
			contentEl: 'menuOverview',
			title: 'Overview',
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
			title: 'Documents',
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
			title: 'Projects',
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
			title: 'Administration',
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
				title: 'Help',
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
				title: 'Menu',
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
			contentPanel = new Ext.Panel({
				id: 'contentPanel',
				region:'center',
				layout: 'fit',
				contentEl:'content',
				title: Ext.getDom('pageTitle').innerHTML,
				autoShow: true,
				autoScroll: true})
		 ]
	});
	
	contentPanel.on('resize', function() {
		if (window.onresize) {
			window.onresize();
		}
	});
});

Ext.opengoo = function(){
    var msgCt;

    function createBox(t, s){
        return ['<div class="msg">',
                '<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
                '<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><h3>', t, '</h3>', s, '</div></div></div>',
                '<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
                '</div>'].join('');
    }
    return {
        msg : function(title, format){
            if(!msgCt){
                msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
            }
            msgCt.alignTo(document, 't-t');
            var s = String.format.apply(String, Array.prototype.slice.call(arguments, 1));
            var m = Ext.DomHelper.append(msgCt, {html:createBox(title, s)}, true);
            m.slideIn('t').pause(1).ghost("t", {remove:true});
        }
    };
}();

var Cookies = {};
Cookies.set = function(name, value, expires, path, domain, secure){
	document.cookie = name + "=" + escape (value) +
		(expires ? "; expires=" + expires.toGMTString() : "") +
		(path ? "; path=" + path : "") +
		(domain ? "; domain=" + domain : "") +
		(secure ? "; secure" : "");
};

Cookies.get = function(name){
	var start = document.cookie.indexOf(name + "=");
	if (start < 0) {
		return "";
	}
	var temp = document.cookie.substring(start + name.length + 1);
	var end = temp.indexOf(';');
	if (end < 0) {
		return unescape(temp);
	} else {
		return unescape(temp.substring(0, end));
	}
};

Cookies.clear = function(name) {
	if (Cookies.get(name)) {
		document.cookie = name + "=" +
		"; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
};

function toggle(id) {
	var obj = Ext.getDom(id);
	var img = Ext.getDom(id + "_img");
	if (obj.style.display == 'block') {
		obj.style.display = 'none';
		if (img) {
			img.src = Ext.getDom('toggle_plus').src;
		}
	} else {
		obj.style.display = 'block';
		if (img) {
			img.src = Ext.getDom('toggle_minus').src;
		}
	}
}

function showHelp() {
	helpPanel.toggleCollapse();
}