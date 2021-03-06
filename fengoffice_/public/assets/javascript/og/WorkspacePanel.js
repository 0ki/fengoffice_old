og.WorkspacePanel = function(workspaces) {
	this.tree = new og.WorkspaceTree(workspaces);
	
	this.tree.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			this.getTopToolbar().items.get('delete').setDisabled(!node || node == this.tree.workspaces);
			this.getTopToolbar().items.get('edit').setDisabled(!node || node == this.tree.workspaces);
		},
		scope:this
	});
	
	og.WorkspacePanel.superclass.constructor.call(this, {
		autoScroll: true,
		iconCls: 'ico-workspaces',
		region: 'center',
		minSize: 200,
		layout: 'fit',
		items: [this.tree],
		tbar: [{
			iconCls: 'ico-workspace-add',
			tooltip: lang('create a workspace'),
			handler: this.tree.newWS,
			scope: this.tree
		},{
			id: 'delete',
			iconCls: 'ico-workspace-del',
			tooltip: lang('delete selected workspace'),
			disabled: true,
			handler: function(){
				var s = this.getSelectionModel().getSelectedNode();
				if(s) {
					this.delWS(s.attributes);
				}
			},
			scope: this.tree
		},{
			id: 'edit',
			iconCls: 'ico-workspace-edit',
			tooltip: lang('edit workspace'),
			disabled: true,
			handler: this.tree.editWS,
			scope: this.tree
		},{
			iconCls: 'ico-workspace-refresh',
			tooltip: lang('refresh desc'),
			handler: this.tree.loadWorkspaces,
			scope: this.tree
		}/*,'-',{
			iconCls: 'ico-workspace-sort',
			tooltip: lang('sort desc'),
			menu: [{
				iconCls: 'ico-workspace-alphabetical',
				text: lang('alphabetical'),
				tooltip: lang('alphabetical desc'),
				handler: function() {alert('alphabetical');}
			},{
				iconCls: 'ico-workspace-active',
				text: lang('most active'),
				tooltip: lang('most active desc'),
				handler: function() {alert('most active');}
			}]
		}*/]
	});
};

Ext.extend(og.WorkspacePanel, Ext.Panel,{});

og.WorkspaceTree = function(workspaces) {
	// tree filter
	var tree = this;
	var filter = new Ext.tree.TreeFilter(this, {
		clearBlank: true,
		autoClear: true
	});
	function filterTree(e) {
		var text = e.target.value;
		if(!text){
			filter.clear();
			return;
		}
		tree.expandAll();
		
		var re = new RegExp('^' + Ext.escapeRe(text.toLowerCase()), 'i');
		filter.filterBy(function(n){
			return n == tree.workspaces || re.test(n.text.toLowerCase());
		});
	}

	og.WorkspaceTree.superclass.constructor.call(this, {
		ddGroup: 'WorkspaceDD',
		enableDrop: true,
		id: 'workspace-panel',
		autoScroll: true,
		rootVisible: false,
		lines: false,
		root: new Ext.tree.TreeNode(lang('workspaces')),
		collapseFirst: false,
		tbar: [new Ext.form.TextField({
			width: 200,
			emptyText:lang('filter workspaces'),
			listeners:{
				render: function(f){
					f.el.on('keyup', filterTree, f, {buffer: 350});
				}
			}
		})],
		listeners: {
            beforenodedrop: function(e) {
            	var ws = e.target.ws.id;
            	if (ws == 0) {
            		return;
            	}
            	var s = e.data.selections, r = [];
            	if (s.length == 0) {
            		return;
            	}
            	var ids = "";
				for(var i = 0, len = s.length; i < len; i++){
					if (ids != "") {
						ids += ";";
					}
					ids += s[i].data.manager + ":" + s[i].data.object_id;
				}
				var url = og.getUrl('object', 'move', {ids: ids, workspace: ws});
				og.openLink(url, {callback: function() { e.data.reload(); }});
            }
        }
	});

	this.workspaces = this.root.appendChild(
		new Ext.tree.TreeNode({
			text: lang('all'),
			expanded: true,
			name: lang('all'),
			listeners: {
				click: function() {
					this.unselect();
					this.select();
				}
			}
		})
	);
	this.workspaces.ws = {id: 0, name: lang('all')};
	
	if (workspaces) {
		this.addWorkspaces(workspaces);
	}

	this.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			if (node && !this.pauseEvents) {
				og.eventManager.fireEvent('workspace changed', node.ws);
			}
		},
		scope:this
	});
	
	og.eventManager.addListener('workspace added', this.addWS, this);
	og.eventManager.addListener('workspace edited', this.addWS, this);
	og.eventManager.addListener('workspace deleted', this.removeWS, this);
		
	this.loadWorkspaces();
};

Ext.extend(og.WorkspaceTree, Ext.tree.TreePanel, {

	newWS: function() {
		og.openLink(og.getUrl('project', 'add'), {caller:'project'});
	},
	
	delWS: function() {
		og.openLink(og.getUrl('project', 'delete', {id: this.getActiveWorkspace().id}), {caller:'project'});
	},
	
	editWS: function() {
		og.openLink(og.getUrl('project', 'edit', {id: this.getActiveWorkspace().id}), {caller:'project'});
	}, 

	removeWS: function(ws) {
		var node = this.getNodeById('ws' + ws.id);
		if (node) {
			node.unselect();
			Ext.fly(node.ui.elNode).ghost('l', {
				callback: node.remove, scope: node, duration: .4
			});
		}
	},

	addWS : function(ws){
		var exists = this.getNodeById('ws' + ws.id);
		if (exists) {
			exists.setText(ws.name);
			var ico = exists.getUI().getIconEl();
			ico.className = ico.className.replace(/ico-color([0-9]*)/ig, 'ico-color' + (ws.color || 0));
			return;
		}
		var config = {
			iconCls: 'ico-color' + (ws.color || 0),
			leaf: true,
			cls: 'workspace-item',
			text: ws.name,
			id: 'ws' + ws.id,
			listeners: {
				click: function() {
					this.unselect();
					this.select();
				}
			}
		};
		var node = new Ext.tree.TreeNode(config);
		node.ws = ws;
		var iter = this.workspaces.firstChild;
		while (iter && node.text.toLowerCase() > iter.text.toLowerCase()) {
			iter = iter.nextSibling;
		}
		this.workspaces.insertBefore(node, iter);

		/*Ext.fly(node.ui.elNode).slideIn('l', {
			callback: Ext.emptyFn, scope: this, duration: .4
		});*/
		return node;
	},
	
	getActiveWorkspace: function() {
		var s = this.getSelectionModel().getSelectedNode();
		if (s) {
			return this.getSelectionModel().getSelectedNode().ws;
		} else {
			return {id: 0, name: 'all'};
		}
	},
	
	loadWorkspaces: function() {
		og.loading();
		Ext.Ajax.request({
			url: og.getUrl('project', 'list_projects'),
			callback: function(options, success, response) {
				if (success) {
					try {
						var workspaces = Ext.util.JSON.decode(response.responseText);
						this.removeAll();
						this.addWorkspaces(workspaces);
						this.workspaces.expand();
						
						this.pauseEvents = true;
						this.workspaces.select();
						this.pauseEvents = false;
					} catch (e) {
						og.msg(lang("error"), e.message);
					}
				} else {
					og.msg(lang("error"), lang("server could not be reached"));
				}
				og.hideLoading();
			},
			scope: this,
			caller: Ext.getCmp('tabs-panel').getActiveTab()
		});
	},
	
	addWorkspaces: function(workspaces) {
		for (var i=0; i < workspaces.length; i++) {
			this.addWS(workspaces[i]);
		}
	},
	
	select: function(id) {
		if (!id) {
			this.workspaces.select();
		} else {
			var node = this.getNodeById('ws' + id);
			if (node) {
				node.select();
			}
		}
	},
	
	removeAll: function() {
		var node = this.workspaces.firstChild;
		while (node) {
			var aux = node;
			node = node.nextSibling;
			aux.remove();
		}
	}
});