/**
 *  WebpageManager
 */
og.WebpageManager = function() {
	var actions;
	this.doNotDestroy = true;
	this.active = true;
	
	this.store = new Ext.data.Store({
        proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
			method: 'GET',
            url: og.getUrl('webpage', 'list_all')
        })),
        reader: new Ext.data.JsonReader({
            root: 'webpages',
            totalProperty: 'totalCount',
            id: 'id',
            fields: [
                'name', 'description', 'url', 'tags', 'project', 'projectId'
            ]
        }),
        remoteSort: true,
		listeners: {
			'load': function() {
				if (this.getTotalCount() <= og.pageSize) {
					this.remoteSort = false;
				} else {
					this.remoteSort = true;
				}
				var d = this.reader.jsonData;
				og.processResponse(d);
			}
		}
    });
    this.store.setDefaultSort('name', 'asc');
    this.store.webpageManager = this;
    
    //--------------------------------------------
    // Renderers
    //--------------------------------------------

    function renderName(value, p, r) {
    	return String.format('<a href="" onclick="window.open(\'{1}\'); return false">{0}</a>', value, r.data.url);
    }

	function renderProject(value, p, r) {
		return String.format('<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select({1})">{0}</a>', value, r.data.projectId);
	}
    
	function getSelectedIds() {
		var selections = sm.getSelections();
		if (selections.length <= 0) {
			return '';
		} else {
			var ret = '';
			for (var i=0; i < selections.length; i++) {
				ret += "," + selections[i].id;
			}	
			return ret.substring(1);
		}
	}
	
	function getFirstSelectedId() {
		if (sm.hasSelection()) {
			return sm.getSelected().id;
		}
		return '';
	}

	var sm = new Ext.grid.CheckboxSelectionModel();
	sm.on('selectionchange',
		function() {
			if (sm.getCount() <= 0) {
				actions.tag.setDisabled(true);
				actions.delWebpage.setDisabled(true);
				actions.editWebpage.setDisabled(true);
			} else {
				actions.editWebpage.setDisabled(sm.getCount() != 1);
				actions.tag.setDisabled(false);
				actions.delWebpage.setDisabled(false);
			}
		});
    var cm = new Ext.grid.ColumnModel([
		sm,{
			id: 'project',
			header: lang("project"),
			dataIndex: 'project',
			width: 120,
			renderer: renderProject,
			sortable: false
        },{
			id: 'name',
			header: lang("title"),
			dataIndex: 'name',
			width: 120,
			sortable: false,
			renderer: renderName
        },{
			id: 'description',
			header: lang("description"),
			dataIndex: 'description',
			sortable: false,
			width: 120
		},{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			sortable: false
        }]);
    cm.defaultSortable = true;
	
	actions = {
		newWebpage: new Ext.Action({
			text: lang('new'),
            tooltip: lang('add new webpage'),
            iconCls: 'ico-webpages',
            handler: function() {
				var url = og.getUrl('webpage', 'add');
				og.openLink(url, null);
			}
		}),
		delWebpage: new Ext.Action({
			text: lang('delete'),
            tooltip: lang('delete selected webpages'),
            iconCls: 'db-ico-delete',
			disabled: true,
			handler: function() {
				if (confirm(lang('confirm delete webpages'))) {
					this.load({
						action: 'delete',
						webpages: getSelectedIds()
					});
				}
			},
			scope: this
		}),
		editWebpage: new Ext.Action({
			text: lang('edit'),
            tooltip: lang('edit selected webpage'),
            iconCls: 'db-ico-new',
			disabled: true,
			handler: function() {
				var url = og.getUrl('webpage', 'edit', {id:getFirstSelectedId()});
				og.openLink(url, null);
			},
			scope: this
		}),
		refresh: new Ext.Action({
			text: lang('refresh'),
            tooltip: lang('refresh desc'),
            iconCls: 'db-ico-refresh',
			handler: function() {
				this.store.reload();
			},
			scope: this
		}),
		tag: new Ext.Action({
			text: lang('tag'),
	        tooltip: lang('tag selected webpages'),
	        iconCls: 'db-ico-tag',
			disabled: true,
			menu: new og.TagMenu({
				listeners: {
					'tagselect': {
						fn: function(tag) {
							this.load({
								action: 'tag',
								webpages: getSelectedIds(),
								tagTag: tag
							});
						},
						scope: this
					}
				}
			})
		})
    };
    
	og.WebpageManager.superclass.constructor.call(this, {
        store: this.store,
		layout: 'fit',
        cm: cm,
        closable: true,
		stripeRows: true,
        loadMask: true,
        bbar: new Ext.PagingToolbar({
            pageSize: og.pageSize,
            store: this.store,
            displayInfo: true,
            displayMsg: lang('displaying webpages of'),
            emptyMsg: lang("no webpages to display")
        }),
		viewConfig: {
            forceFit: true
        },
		sm: sm,
		tbar:[
			actions.newWebpage,
			'-',
			actions.tag,
			actions.delWebpage,
			actions.editWebpage,
			'-',
			actions.refresh
        ]
    });

	og.eventManager.addListener("tag changed", function(tag) {
		if (this.active) {
			this.load({start: 0});
		} else {
    		this.needRefresh = true;
    	}
	}, this);
	og.eventManager.addListener("workspace changed", function(ws) {
		cm.setHidden(cm.getIndexById('project'), this.store.lastOptions.params.active_project != 0);
		
	}, this);
};

Ext.extend(og.WebpageManager, Ext.grid.GridPanel, {
	load: function(params) {
		if (!params) params = {};
		this.store.load({
			params: Ext.apply(params, {
				start: 0,
				limit: og.pageSize,
				tag: Ext.getCmp('tag-panel').getSelectedTag().name,
				active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id
			})
		});
		this.needRefresh = false;
	},
	
	activate: function() {
		this.active = true;
		if (this.needRefresh) {
			this.load({start: 0});
		}
	},
	
	deactivate: function() {
		this.active = false;
	}
});

og.WebpageManager.getInstance = function() {
	if (!og.WebpageManager.instance) {
		og.WebpageManager.instance = new og.WebpageManager();
	}
	return og.WebpageManager.instance;
}