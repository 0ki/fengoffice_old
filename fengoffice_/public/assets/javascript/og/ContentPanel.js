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
	
	if (config.refreshOnWorkspaceChange) {
		og.eventManager.addListener('workspace changed', this.reset, this);
	}
	if (this.active) {
		this.load(this.defaultContent);
	}
	// dirty stuff to allow refreshing a content panel when clicking on its tab
	this.on('render', function() {
		var tabs = this.ownerCt.getEl().select('.x-tab-with-icon');
		var p = this;
		og._activeTab = p.id;
		tabs.each(function() {
			if (this.dom.id == 'tabs-panel__' + p.id) {
				this.on('click', function() { 
					if (p.id == og._activeTab) {
						p.reset();
					}
					og._activeTab = p.id;
				});
			}
		});
	}, this);
};

Ext.extend(og.ContentPanel, Ext.Panel, {

	activate: function() {
		this.active = true;
		if (this.getComponent(0).activate) {
			this.getComponent(0).activate();
		}
		if (!this.loaded) {
			this.load(this.defaultContent);
		}
	},
	
	deactivate: function() {
		this.active = false;
		if (this.getComponent(0).deactivate) {
			this.getComponent(0).deactivate();
		}
	},

	load: function(content, isBack) {
		if (content.type == 'start') {
			if (this.closable) {
				this.ownerCt.remove(this);
			} else {
				this.reset();
			}
			return;
		}
	
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
		if (this.content.type != 'url') {
			while (this.getComponent(0)) {
				var comp = this.getComponent(0);
				if (comp.doNotDestroy) {
					this.remove(this.getComponent(0), false);
					comp.getEl().dom.parentNode.removeChild(comp.getEl().dom);
				} else {
					this.remove(this.getComponent(0));
				}
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
			} else if (this.closable) {
				var tbar = [{
					text: lang('cancel'),
					handler: function() {
						this.ownerCt.remove(this);
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
								if (this.target == '_blank') {
									window.open(this.url);
								} else if (this.target) {
									og.openLink(this.url, {caller: this.target});
								} else {
									og.openLink(this.url);
								}
							}
						},
						scope: content.actions[i],
						iconCls: content.actions[i].name
					});
				}
			}
			if (content.notbar){
				tbar = null;
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
		} else if (content.type == 'overview') {
			this.add(og.Overview.getInstance());
			og.Overview.getInstance().load({start:0});
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'files') {
			this.add(og.FileManager.getInstance());
			og.FileManager.getInstance().load({start:0});
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'contacts') {
			this.add(og.ContactManager.getInstance());
			og.ContactManager.getInstance().load({start:0});
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'messages') {
			this.add(og.MessageManager.getInstance());
			og.MessageManager.getInstance().load({start:0});
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'webpages') {
			this.add(og.WebpageManager.getInstance());
			og.WebpageManager.getInstance().load({start:0});
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'tasks') {
			this.add(og.TaskViewer.getInstance());
			og.TaskViewer.getInstance().load({start:0});
			this.doLayout();
			og.captureLinks(this.id, this);
		} else if (content.type == 'reporting') {
			this.add(og.ReportingManager.getInstance());
			og.ReportingManager.getInstance().load({start:0});
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
		
	reset: function() {
		this.loaded = false;
		this.history = [];
		if (this.active) {
			this.load(this.defaultContent);
		}
	}
});