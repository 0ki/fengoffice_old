/**
 *  Config options:
 *  	- id
 *  	- title
 *  	- iconCls
 *  	- defaultContent
 *  	- plus all Ext.Panel options
 */
og.ContentPanel = function(config) {
	Ext.apply(config, {
		autoScroll: true,
		layout: 'fit',
		loaded: false,
		listeners: {
			activate: this.activate,
			deactivate: this.deactivate
		},
		items: [{
			xtype: 'panel',
			html: ""
		}]
	});
	og.ContentPanel.superclass.constructor.call(this, config);
	
	this.history = [];
	
	og.eventManager.addListener('workspace changed', this.workspaceChanged, this);
	if (this.active) {
		this.load(this.defaultContent);
	}
};

Ext.extend(og.ContentPanel, Ext.Panel, {

	activate: function() {
		this.active = true;
		if (!this.loaded) {
			this.load(this.defaultContent);
		}
	},
	
	deactivate: function() {
		this.active = false;
	},

	load: function(content, isBack) {
		if (this.loaded && this.content && !isBack) {
			this.history.push(this.content);
		}
		if (typeof content == 'string') {
			content = {
				type: 'html',
				data: content
			}
		}
		this.content = content;
		while (this.getComponent(0)) {
			var comp = this.getComponent(0);
			if (comp.doNotDestroy) {
				this.remove(this.getComponent(0), false);
				comp.getEl().dom.parentNode.removeChild(comp.getEl().dom);
			} else {
				this.remove(this.getComponent(0));
			}
		}
		if (content.type == 'html') {
			if (this.history.length > 0) {
				var tbar = [{
					text: lang('back'),
					handler: function() {
						this.back();
					},
					scope: this,
					iconCls: 'ico-back'
				},'-'];
			} else if (content.actions) {
				var tbar = [];
			}
			if (content.actions) {
				for (var i=0; i < content.actions.length; i++) {
					tbar.push({
						text: content.actions[i].title,
						handler: function() {
							if (this.url.indexOf('javascript:') == 0) {
								location.href = this.url;
							} else {
								og.openLink(this.url);
							}
						},
						scope: content.actions[i],
						iconCls: content.actions[i].name
					});
				}
			}
			var p = new og.HtmlPanel({
				html: og.extractScripts(content.data),
				autoScroll: true,
				tbar: tbar
			});
			this.add(p);
			this.doLayout();
			//og.captureLinks(this.id, this);
		} else if (content.type == 'url') {
			og.openLink(content.data, {caller: this});
			//og.captureLinks(this.id, this);
		} else if (content.type == 'dashboard') {
			this.add(og.Dashboard.getInstance());
			og.Dashboard.getInstance().load();
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'files') {
			this.add(og.FileManager.getInstance());
			og.FileManager.getInstance().load();
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'contacts') {
			this.add(og.ContactManager.getInstance());
			og.ContactManager.getInstance().load();
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'webpages') {
			this.add(og.WebpageManager.getInstance());
			og.WebpageManager.getInstance().load();
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'tasks') {
			this.add(og.TaskViewer.getInstance());
			og.TaskViewer.getInstance().load();
			this.doLayout();
			og.captureLinks(this.id, this);
		} else {
			var html = "<h1>Error: invalid content</h1>";
			html += "<pre>";
			html += og.debug(content);
			html += "</pre>";
			var p = new Ext.Panel({
				html: html,
				autoScroll: true
			});
			this.add(p);
			this.doLayout();
		}
		if (content.type != 'url') {
			this.loaded = true;
		}
	},
	
	back: function() {
		var prev = this.history.pop();
		if (!prev) return;
		if (prev.type == 'url') {
			this.back();
		} else {
			this.load(prev, true);
		}
	},
	
	reload: function() {
		this.load(this.content);
	},
	
	workspaceChanged: function() {
		this.reset();
	},
	
	reset: function() {
		this.loaded = false;
		this.history = [];
		if (this.active) {
			this.load(this.defaultContent);
		}
	}
});