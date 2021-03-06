og.ObjectList = function(config, ignore_context) {
	if (!config) config = {};
	
	var url_params = {
		ajax: true,
		count_results : 0		
	};


	
	var list_url = og.getUrl('object', 'list_objects');
	if (config.url) {
		list_url = config.url;
	}

	if (config.store_params) {
		url_params = config.store_params;
	}

	if (ignore_context) {
		url_params['ignore_context'] = ignore_context ? '1' : '0';
	}

	var Grid = function(config) {
		if (!config) config = {};
		this.store = new Ext.data.Store({
        	proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
				method: 'GET',
            	url: list_url
        	})),
        	reader: new Ext.data.JsonReader({
            	root: 'objects',
            	totalProperty: 'totalCount',
            	id: 'id',
            	fields: [
	                'name', 'object_id', 'type', 'ot_id', 'icon', 'object_id', 'mimeType',
	                'createdBy', 'createdById', 'dateCreated',
					'updatedBy', 'updatedById', 'dateUpdated'
            	]
        	}),
        	remoteSort: true,
        	listeners: {
        		'load': function(store, result) {
        			// fix count query to be quick and then don't hide texts and reloadGridPagingToolbar
        			var grid = Ext.getCmp('obj_list_grid');
					if (grid) {
						this.lastOptions.params = this.baseParams;
						this.lastOptions.params.count_results = 1;
						console.log(this);

						Ext.getCmp('obj_list_grid').reloadGridPagingToolbar(this.baseParams.url_controller,this.baseParams.url_action,'obj_list_grid');
					}
        		}
        	}
    	});
		this.store.baseParams = jQuery.extend({}, url_params);;
	   	this.store.setDefaultSort('dateUpdated', 'desc');

		function renderIcon(value, p, r) {
			var classes = "db-ico ico-unknown ico-" + r.data.type;
			if (r.data.mimeType) {
				var path = r.data.mimeType.replace(/\./ig, "_").replace(/\//ig, "-").split("-");
				var acc = "";
				for (var i=0; i < path.length; i++) {
					acc += path[i];
					classes += " ico-" + acc;
					acc += "-";
				}
			}
			return String.format('<div class="{0}" />', classes);
		}
        
		function renderDate(value, p, r) {
			if (!value) {
				return "";
			}
			return value;
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
				dataIndex: 'name',
				renderer: og.clean
				//,width: 120
	        }]);

	    cm.defaultSortable = true;
    
		Grid.superclass.constructor.call(this, Ext.apply(config, {
	        store: this.store,
			layout: 'fit',
			id: 'obj_list_grid',
	        cm: cm,
	        stripeRows: true,
	        loadMask: true,
	        bbar: new og.CurrentPagingToolbar({
	            pageSize: og.config['files_per_page'],
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
		load: function(params) {
			Ext.apply(params, {
				start: 0,
				limit: og.config['files_per_page']
			});
			this.store.removeAll();
			this.store.load({
				params: params
			});
		}
	});
	
	var title = config.title ? config.title : lang('select an object');
	
	og.ObjectList.superclass.constructor.call(this, Ext.apply(config, {
		y: 50,
		width: 640,
		height: 480,
		id: 'object-list',
		cls: 'ext-modal-object-list',
		layout: 'border',
		modal: true,
		closeAction: 'close',
		//iconCls: 'op-ico',
		title: title,
		buttons: [{
			text: lang('ok'),
			cls:"submit-btn-blue",
			handler: this.accept,
			scope: this
		},{
			text: lang('cancel'),
			cls:"cancel-btn-g",
			handler: this.cancel,
			scope: this
		}],
		items: [
			{
				region: 'center',
				layout: 'fit',
				items: [
					this.grid = new Grid()
				]
			}
		]
	}));	
}

Ext.extend(og.ObjectList, Ext.Window, {
	cancel: function() {
		this.close();
	},	
	load: function() {
		this.grid.load();
	}
});

og.ObjectList.show = function(callback, scope, config) {
	if (!config) config = {};
	if (!config.ignore_context) config.ignore_context = 0;
    
	this.dialog = new og.ObjectList(config, config.ignore_context);
	
	if (config.context) {
		this.dialog.grid.store.baseParams.context = config.context;
	}
	
	this.dialog.load();
	this.dialog.purgeListeners();
	
	this.dialog.on('hide', og.restoreFlashObjects);
	this.dialog.on('close', og.restoreFlashObjects);
	og.hideFlashObjects();
	this.dialog.show();
	var pos = this.dialog.getPosition();
	if (pos[0] < 0) pos[0] = 0;
	if (pos[1] < 0) pos[1] = 0;
	this.dialog.setPosition(pos[0], pos[1]);
}