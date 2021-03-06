og.WorkspacePanel = function(config) {
	if (!config) config = {};
	if (!config.wstree)  config.wstree = {};
	
	config.wstree.xtype = 'wstree';
	//this.tree = new og.WorkspaceTree(config.wstree);
	
	Ext.applyIf(config, {
		iconCls: 'ico-workspaces',
		region: 'center',
		minSize: 200,
		layout: 'fit',
		items: [config.wstree],
		tbar: [{
			iconCls: 'ico-workspace-add',
			tooltip: lang('create a workspace'),
			handler: function() {
				this.tree.newWS();
			},
			scope: this
		},/*{
			id: 'delete',
			iconCls: 'ico-workspace-del',
			tooltip: lang('delete selected workspace'),
			disabled: true,
			handler: function(){
				var s = this.tree.getSelectionModel().getSelectedNode();
				if(s && confirm(lang('confirm delete workspace', this.tree.getActiveWorkspace().name))) {
					this.tree.delWS(s.attributes);
				}
			},
			scope: this
		},*/{
			id: 'edit',
			iconCls: 'ico-workspace-edit',
			tooltip: lang('edit workspace'),
			disabled: true,
			handler: function() {
				this.tree.editWS();
			},
			scope: this
		},{
			iconCls: 'ico-workspace-refresh',
			tooltip: lang('refresh desc'),
			handler: function() {
				this.tree.loadWorkspaces(null,null,true);
			},
			scope: this
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
	
	og.WorkspacePanel.superclass.constructor.call(this, config);
	
	this.tree = this.findById('workspace-panel');
	
	this.tree.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			//this.getTopToolbar().items.get('delete').setDisabled(!node || node == this.tree.workspaces);
			this.getTopToolbar().items.get('edit').setDisabled(!node || node == this.tree.workspaces);
		},
		scope:this
	});
};

Ext.extend(og.WorkspacePanel, Ext.Panel,{});

og.WorkspaceTree = function(config) {
	if (!config) config = {};
	var workspaces = config.workspaces;
	delete config.workspaces;
	// tree filter
	var tree = this;
	function filterNode(n, re) {
		var f = false;
		var c = n.firstChild;
		while (c) {
			f = filterNode(c, re) || f;
			c = c.nextSibling;
		}
		f = re.test(n.text.toLowerCase()) || f;
		if (f) {
			n.getUI().show();
		} else {
			n.getUI().hide();
		}
		return f;
	}
	function filterTree(e) {
		var text = e.target.value;
		tree.expandAll();
		var re = new RegExp(Ext.escapeRe(text.toLowerCase()), 'i');
		filterNode(tree.workspaces, re);
		tree.workspaces.getUI().show();
	}

	Ext.applyIf(config, {
		ddGroup: 'WorkspaceDD',
		enableDD: false,
		autoScroll: true,
		id: 'workspace-panel',
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
		})]
	});
	if (!config.listeners) config.listeners = {};
	Ext.apply(config.listeners, {
		beforenodedrop: function(e) {
			var dest = e.target.ws.id;
			var orig = e.data.node.ws.id;
			var url = og.getUrl('project', 'move', {id: orig, to: dest});
			og.openLink(url);
		}
    });
	og.WorkspaceTree.superclass.constructor.call(this, config);

	this.workspaces = this.root.appendChild(
		new Ext.tree.TreeNode({
			text: lang('all'),
			expanded: true,
			name: lang('all'),
			listeners: {
				click: function() {
					this.unselect();
					this.select();
				}/*,
				expand: {
					fn: function(node) {
						this.loadWorkspaces(node);
					},
					scope: this
				}*/
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
				this.fireEvent("workspaceselect", node.ws);
				node.expand();
			}
		},
		scope:this
	});
	this.addEvents({workspaceselect: true});
	
	og.eventManager.addListener('workspace added', this.addWS, this);
	og.eventManager.addListener('workspace edited', this.addWS, this);
	og.eventManager.addListener('workspace deleted', this.removeWS, this);
		
	this.loadWorkspaces(null,null,true);
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

	addWS : function(ws) {
		var exists = this.getNodeById('ws' + ws.id);
		if (exists) {
			exists.setText(ws.name);
			var ico = exists.getUI().getIconEl();
			ico.className = ico.className.replace(/ico-color([0-9]*)/ig, 'ico-color' + (ws.color || 0));
			if (ws.parent != exists.ws.parent) {
				exists.remove();
				var parent = this.getNodeById('ws' + ws.parent);
				if (parent) {
					parent.appendChild(exists);
					exists.ws.parent = parent.ws.id;
				}
			}
			return;
		}
		var config = {
			iconCls: 'ico-color' + (ws.color || 0),
			/*leaf: false,*/
			//cls: 'workspace-item',
			text: ws.name,
			/*expandable: true,*/
			id: 'ws' + ws.id,
			listeners: {
				click: function() {
					this.unselect();
					this.select();
				}/*,
				expand: {
					fn: function(node) {
						this.loadWorkspaces(node);
					},
					scope: this
				}*/
			}
		};
		var node = new Ext.tree.TreeNode(config);
		node.ws = ws;
		var parent = this.getNodeById('ws' + ws.parent);
		if (!parent) parent = this.workspaces;
		var iter = parent.firstChild;
		while (iter && node.text.toLowerCase() > iter.text.toLowerCase()) {
			iter = iter.nextSibling;
		}
		parent.insertBefore(node, iter);

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
	
	loadWorkspaces: function(node, showWsDiv, isInitial) {
		if (!node) node = this.workspaces;
		if (isInitial){
			for (var i = 0; i < node.childNodes.length; i++){
				node.childNodes[i].remove();
				i--;
			}
		}
		var action = 'list_projects';
		if (isInitial)
			action = 'initial_list_projects';
		og.openLink(og.getUrl('project', action, {parent: node.ws.id}), {
			callback: function(success, data, showWsDiv) {
				if (success) {
					// remove deleted nodes
					var ch = node.firstChild;
					while (ch) {
						var exists = false;
						for (var i=0; i < data.workspaces.length; i++) {
							if (ch.ws.id == data.workspaces[i].id) {
								exists = true;
							}
						}
						if (!exists) {
							ch.remove();
						}
						ch = ch.nextSibling;
					}
					
					var workspacesToAdd = new Array();
					if (isInitial)
					{
						//Set order of elements to add to the workspace list. Parents should be added first

						var continueOrdering = true;
						while(continueOrdering)
						{
							continueOrdering = false;
							for (var i = 0; i < data.workspaces.length; i++){
								var add = false;
								var ws = data.workspaces[i];
								if (ws.parent == 0)
									add = true;
								else for (var j = 0; j < workspacesToAdd.length; j++)
									if (workspacesToAdd[j].id == ws.parent){
										add = true;
										break;
									}
								if (add){
									continueOrdering = true;
									workspacesToAdd[workspacesToAdd.length] = data.workspaces.splice(i,1)[0];
									i--;
								}
							}
						}
					} else 
						workspacesToAdd = data.workspaces;

					this.addWorkspaces(workspacesToAdd);
					if (isInitial)
						this.workspaces.expand();
										
					if (!this.getSelectionModel().getSelectedNode()) {
						this.pauseEvents = true;
						this.workspaces.select();
						this.pauseEvents = false;
					}
					
					/*if (showWsDiv)
						og.showSubWsTooltip(node);*/
				}
			},
			scope: this
		});
	},
	
	addWorkspaces: function(workspaces) {
		for (var i=0; i < workspaces.length; i++) {
			this.addWS(workspaces[i]);
		}
	},
	
	select: function(id) {
		if (!id) {
			this.workspaces.ensureVisible();
			this.workspaces.select();
		} else {
			var node = this.getNodeById('ws' + id);
			if (node) {
				node.ensureVisible();
				node.select();
			}
		}
	},
	
	getNode: function(id) {
		if (!id) {
			return this.workspaces;
		} else {
			var node = this.getNodeById('ws' + id);
			if (node) {
				return node;
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

Ext.reg('wspanel', og.WorkspacePanel);
Ext.reg('wstree', og.WorkspaceTree);
