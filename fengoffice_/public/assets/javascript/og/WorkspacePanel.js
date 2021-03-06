og.WorkspacePanel = function(workspaces) {
	og.WorkspacePanel.superclass.constructor.call(this, {
		id: 'workspace-panel',
		rootVisible: false,
		lines: false,
		autoScroll: true,
		iconCls: 'ico-workspaces',
		region: 'center',
		minSize: 200,
		root: new Ext.tree.TreeNode(lang('workspaces')),
		collapseFirst: false,

		tbar: [{
			iconCls: 'ico-workspace-add',
			//text: lang('new'),
			tooltip: lang('create a workspace'),
			handler: this.newWS,
			scope: this
		},{
			id: 'delete',
			iconCls: 'ico-workspace-del',
			//text: lang('delete'),
			tooltip: lang('delete selected workspace'),
			disabled: true,
			handler: function(){
				var s = this.getSelectionModel().getSelectedNode();
				if(s) {
					this.delWS(s.attributes);
				}
			},
			scope: this
		},{
			id: 'edit',
			iconCls: 'ico-workspace-edit',
			//text: lang('new'),
			tooltip: lang('edit workspace'),
			disabled: true,
			handler: this.editWS,
			scope: this
		},{
			iconCls: 'ico-workspace-refresh',
			//text: lang('new'),
			tooltip: lang('refresh desc'),
			handler: this.loadWorkspaces,
			scope: this
		}]
	});

	this.workspaces = this.root.appendChild(
		new Ext.tree.TreeNode({
			text: lang('all'),
			cls: 'workspace-all',
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
			if (node) {
				og.eventManager.fireEvent('workspace changed', node.ws);
			}
			this.getTopToolbar().items.get('delete').setDisabled(!node || node == this.workspaces);
			this.getTopToolbar().items.get('edit').setDisabled(!node || node == this.workspaces);
		},
		scope:this
	});
	
	og.eventManager.addListener('workspace added', this.addWS, this);
	og.eventManager.addListener('workspace deleted', this.removeWS, this);
	
	this.loadWorkspaces();
};

Ext.extend(og.WorkspacePanel, Ext.tree.TreePanel, {

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
			return;
		}
		var config = {
			iconCls: 'ico-workspace',
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
		this.workspaces.appendChild(node);
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
					} catch (e) {
						alert(e);
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