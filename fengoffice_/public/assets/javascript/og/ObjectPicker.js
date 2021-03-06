og.ObjectPicker = function(config) {
	if (!config) config = {};
	var Grid = function(config) {
		if (!config) config = {};
		this.store = new Ext.data.Store({
        	proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
				method: 'GET',
            	url: og.getUrl('object', 'list_objects', {ajax: true})
        	})),
        	reader: new Ext.data.JsonReader({
            	root: 'objects',
            	totalProperty: 'totalCount',
            	id: 'id',
            	fields: [
	                'name', 'object_id', 'type', 'tags', 'createdBy', 'createdById',
	                {name: 'dateCreated', type: 'date', dateFormat: 'timestamp'},
					'updatedBy', 'updatedById',
					{name: 'dateUpdated', type: 'date', dateFormat: 'timestamp'},
					'icon', 'project', 'projectId', 'manager', 'object_id', 'mimeType'
            	]
        	}),
        	remoteSort: true,
			listeners: {
				'load': function() {
					if (this.getTotalCount() <= og.pageSize) {
						this.remoteSort = false;
					}
				}
			}
    	});
    	this.store.setDefaultSort('name', 'asc');

		function renderIcon(value, p, r) {
			var classes = "db-ico unknown " + r.data.type;
			if (r.data.mimeType) {
				var path = r.data.mimeType.replace(/\//ig, "-").split("-");
				var acc = "";
				for (var i=0; i < path.length; i++) {
					acc += path[i];
					classes += " " + acc;
					acc += "-";
				}
			}
			return String.format('<div class="{0}" />', classes);
		}
        
		function renderDate(value, p, r) {
			var now = new Date();
			if (now.dateFormat('Y-m-d') > value.dateFormat('Y-m-d')) {
				return value.dateFormat('M j');
			} else {
				return value.dateFormat('h:i a');
			}
		}

		var sm = new Ext.grid.RowSelectionModel();
		var cm = new Ext.grid.ColumnModel([{
	        	id: 'icon',
	        	header: '&nbsp;',
	        	dataIndex: 'icon',
	        	width: 28,
	        	renderer: renderIcon,
	        	sortable: false,
	        	fixed:true,
	        	resizable: false,
	        	hideable:false,
	        	menuDisabled: true
	        },{
				id: 'name',
				header: lang("name"),
				dataIndex: 'name'
				//,width: 120
	        },{
				id: 'type',
				header: lang('type'),
				dataIndex: 'type',
				width: 60,
				hidden: true,
				sortable: false
			},{
				id: 'project',
				header: lang("project"),
				dataIndex: 'project',
				width: 60,
				sortable: false,
				hidden: true
	        },{
				id: 'tags',
				header: lang("tags"),
				dataIndex: 'tags',
				width: 60,
				sortable: false,
				hidden: true
	        },{
				id: 'last',
				header: lang("last update"),
				dataIndex: 'dateUpdated',
				width: 60,
				renderer: renderDate
	        },{
	        	id: 'user',
	        	header: lang('user'),
	        	dataIndex: 'updatedBy',
	        	width: 60,
	        	sortable: false,
				hidden: true
	        },{
				id: 'created',
				header: lang("created on"),
				dataIndex: 'dateCreated',
				width: 60,
				renderer: renderDate,
				hidden: true
			},{
				id: 'author',
				header: lang("author"),
				dataIndex: 'createdBy',
				width: 60,
				hidden: true
			}]);
	    cm.defaultSortable = true;
    
		Grid.superclass.constructor.call(this, Ext.apply(config, {
	        store: this.store,
			layout: 'fit',
	        cm: cm,
	        stripeRows: true,
	        loadMask: true,
	        bbar: new Ext.PagingToolbar({
	            pageSize: 10,
	            store: this.store,
	            displayInfo: true,
	            displayMsg: lang('displaying objects of'),
	            emptyMsg: lang("no objects to display")
	        }),
			viewConfig: {
	            forceFit:true
	        },
			sm: sm
	    }));
	}
	Ext.extend(Grid, Ext.grid.GridPanel, {
		getSelected: function() {
			return this.getSelectionModel().getSelections();
		},
		
		filterSelect: function(filter) {
			if (filter.filter == 'type') {
				this.type = filter.name;
			} else if (filter.filter == 'tag') {
				this.tag = filter.name;
			} else if (filter.filter == 'ws') {
				this.ws = filter.id;
			}
			this.load();
		},
		
		load: function() {
			var params = {
				start: 0,
				limit: og.pageSize
			};
			if (this.type) {
				params.type = this.type;
			}
			if (this.tag) {
				params.tag = this.tag;
			}
			if (this.ws) {
				params.active_project = this.ws;
			}
			this.store.load({
				params: params
			});
		}
	});
	
	var Filter = function(type, config) {
		Filter.superclass.constructor.call(this, Ext.apply(config, {
			rootVisible: false,
			lines: false,
			root: new Ext.tree.TreeNode(lang('filter')),
			collapseFirst: false
		}));
	
		this.filters = this.root.appendChild(
			new Ext.tree.TreeNode({
				text: lang('all ' + type),
				expanded: true
			})
		);
		this.filters.filter = {filter: type, id: 0, name: ''};		
		this.getSelectionModel().on({
			'selectionchange' : function(sm, node) {
				if (node) {
					this.fireEvent("filterselect", node.filter);
				}
			},
			scope:this
		});
		this.addEvents({filterselect: true});
		
		this.loadFilters();
	};
	Ext.extend(Filter, Ext.tree.TreePanel, {
		addFilter: function(filter, config) {
			if (!config) config = {};
			var exists = this.getNodeById(filter.filter + (filter.id?filter.id:filter.name));
			if (exists) {
				return;
			}
			var config = Ext.apply(config, {
				iconCls: config.iconCls || 'ico-' + filter.filter,
				leaf: true,
				cls: 'item-' + filter.type,
				text: filter.name,
				id: filter.type + (filter.id?filter.id:filter.name)
			});
			var node = new Ext.tree.TreeNode(config);
			node.filter = filter;
			this.filters.appendChild(node);
			return node;
		},
		
		loadFilters: function() {
		},
		
		removeAll: function() {
			var node = this.filters.firstChild;
			while (node) {
				var aux = node;
				node = node.nextSibling;
				aux.remove();
			}
		}
	});
	
	var TagFilter = function(config) {
		TagFilter.superclass.constructor.call(this, "tag", config);
	}
	Ext.extend(TagFilter, Filter, {
		loadFilters: function() {
			this.removeAll();
			// load tags
			Ext.Ajax.request({
				url: og.getUrl('tag', 'list_tags'),
				callback: function(options, success, response) {
					if (success) {
						var tags = Ext.util.JSON.decode(response.responseText);
						for (var i=0; i < tags.length; i++) {
							tags[i].filter = 'tag';
							this.addFilter(tags[i]);
						}
					} else {
						og.msg(lang("error"), lang("server could not be reached"));
					}
				},
				scope: this
			});
			
			this.filters.expand();
		}
	});
	
	var WSFilter = function(config) {
		WSFilter.superclass.constructor.call(this, "ws", config);
	}
	Ext.extend(WSFilter, Filter, {
		loadFilters: function() {
			this.removeAll();
			// load workspaces
			Ext.Ajax.request({
				url: og.getUrl('project', 'list_projects'),
				callback: function(options, success, response) {
					if (success) {
						var wss = Ext.util.JSON.decode(response.responseText);
						for (var i=0; i < wss.length; i++) {
							wss[i].filter = 'ws';
							this.addFilter(wss[i]);
						}
					} else {
						og.msg(lang("error"), lang("server could not be reached"));
					}
				},
				scope: this
			});
			
			this.filters.expand();
		}
	});
	
	var TypeFilter = function(config) {
		TypeFilter.superclass.constructor.call(this, "type", config);
	}
	Ext.extend(TypeFilter, Filter, {
		loadFilters: function() {
			this.removeAll();
			// load types
			this.addFilter({
				id: 'messages',
				name: lang('messages'),
				filter: 'type'
			}, {iconCls: 'ico-messages'});
			this.addFilter({
				id: 'calendar',
				name: lang('calendar'),
				filter: 'type'
			}, {iconCls: 'ico-calendar'});
			this.addFilter({
				id: 'contacts',
				name: lang('contacts'),
				filter: 'type'
			}, {iconCls: 'ico-contacts'});
			this.addFilter({
				id: 'documents',
				name: lang('documents'),
				filter: 'type'
			}, {iconCls: 'ico-documents'});
			this.addFilter({
				id: 'tasks',
				name: lang('tasks'),
				filter: 'type'
			}, {iconCls: 'ico-tasks'});
			this.addFilter({
				id: 'webpages',
				name: lang('web pages'),
				filter: 'type'
			}, {iconCls: 'ico-webpages'});
			
			this.filters.expand();
		}
	});
	
	og.ObjectPicker.superclass.constructor.call(this, Ext.apply(config, {
		y: 100,
		width: 640,
		height: 480,
		layout: 'border',
		closeAction: 'hide',
		iconCls: 'op-ico',
		title: lang('select an object'),
		buttons: [{
			text: lang('ok'),
			handler: this.accept,
			scope: this
		},{
			text: lang('cancel'),
			handler: this.cancel,
			scope: this
		}],
		items: [
			new Ext.Panel({
				region: 'center',
				layout: 'fit',
				tbar: [
					new Ext.Action({
						text: lang('view'),
			            tooltip: lang('view desc'),
			            iconCls: 'op-ico-view',
						menu: {items: [
							{text: lang('details'), iconCls: 'op-ico-details', handler: function() {
								alert('details');
							}},
							{text: lang('icons'), iconCls: 'op-ico-icons', handler: function() {
								alert('icons');
							}}
						]}
					}),
					new Ext.Action({
						text: lang('refresh'),
			            tooltip: lang('refresh desc'),
			            iconCls: 'op-ico-refresh',
						handler: function() {
							this.grid.store.reload();
							this.tagFilter.loadFilters();
							this.typeFilter.loadFilters();
							this.wsFilter.loadFilters();
						},
						scope: this
					})
				],
				items: [
					this.grid = new Grid()
				]
			}),
			//new Grid({region:'center'}),
			new Ext.Panel({
				layout: 'border',
				split: true,
				width: 200,
				region: 'west',
				items: [
					this.wsFilter = new WSFilter({
						region: 'north',
						autoScroll: true,
						split: true,
						title: lang('filter'),
						height: 120,
						listeners: {
							filterselect: {
								fn: this.grid.filterSelect,
								scope: this.grid
							}
						}
					}),
					this.typeFilter = new TypeFilter({
						region: 'center',
						autoScroll: true,
						listeners: {
							filterselect: {
								fn: this.grid.filterSelect,
								scope: this.grid
							}
						}
					}),
					this.tagFilter = new TagFilter({
						region: 'south',
						autoScroll: true,
						split: true,
						height: 120,
						listeners: {
							filterselect: {
								fn: this.grid.filterSelect,
								scope: this.grid
							}
						}
					})
				]
			})
		]
	}));
	this.grid.on('rowdblclick', this.accept, this);
	this.grid.load();
	this.addEvents({'objectselected': true});
}

Ext.extend(og.ObjectPicker, Ext.Window, {
	accept: function() {
		this.fireEvent('objectselected', this.grid.getSelected());
		this.hide();
	},
	
	cancel: function() {
		this.hide();
	}
});

og.ObjectPicker.show = function(callback, scope) {
	if (!this.dialog) {
		this.dialog = new og.ObjectPicker();
	}
	this.dialog.purgeListeners();
	this.dialog.on('objectselected', callback, scope, {single:true});
	this.dialog.show();
}