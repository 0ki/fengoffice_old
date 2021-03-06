og.WorkspaceChooserTree = function(config) {
	if (!config) config = {};
	var workspaces = config.workspaces;
	this.genid = config.genid;
	genid = this.genid;
	delete config.workspaces;

	Ext.applyIf(config, {
		style: "height:320px;width:210px;",
		el: genid + "-wsTree",
		ddGroup: 'WorkspaceDD',
		enableDD: false,
		autoScroll: true,
		id: 'workspace-chooser' + genid,
		rootVisible: false,
		lines: false,
		root: new Ext.tree.TreeNode(lang('workspaces')),	
		collapseFirst: false,
		tbar: [{
			xtype: 'textfield',
			id: 'workspace-chooser-filter' + genid,
			width: 200,
			emptyText:lang('filter workspaces'),
			listeners:{
				render: {
					fn: function(f){
						f.el.on('keyup', function(e) {
							this.filterTree(e.target.value);
						},
						this, {buffer: 350});
					},
					scope: this
				}
			}
		}]
	});
	if (!config.listeners) 
		config.listeners = {};
	
	og.WorkspaceChooserTree.superclass.constructor.call(this, config);

	this.workspaces = this.root.appendChild(
		new Ext.tree.TreeNode({
			id: "ws0",
			text: lang('all'),
			expanded: true,
			name: lang('all'),
			cls:'x-tree-noicon',
			listeners: {
				click: function() {
					this.unselect();
					this.select();
				}
			}
		})
	);
	this.workspaces.ws = {id: 0, n: lang('all')};
	
	if (workspaces) {
		var decoded = Ext.util.JSON.decode(workspaces);
		this.addWorkspaces(decoded);
	}

	this.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			if (node && !this.pauseEvents) {
				og.eventManager.fireEvent("workspacechooserselect" + this.genid, node.ws);
				//var tf = this.getTopToolbar().items.get('workspace-filter' + genid);
				//tf.setValue("");
				this.clearFilter();
				node.expand();
				node.ensureVisible();
			}
		},
		scope:this
	});
	
	this.addEvents({workspaceselect: true});
};

Ext.extend(og.WorkspaceChooserTree, Ext.tree.TreePanel, {
	removeWS: function(ws) {
		var node = this.getNodeById('ws' + ws.id);
		if (node) {
			if (node.isSelected()) {
				this.workspaces.select();
			}
			Ext.fly(node.ui.elNode).ghost('l', {
				callback: node.remove, scope: node, duration: .4
			});
		}
	},
	
	updateWS : function(ws) {
		this.addWS(ws);
		og.updateWsCrumbs(ws);
	},

	addWS : function(ws) {
		var exists = this.getNodeById('ws' + ws.id);
		if (exists) {
			exists.setText(ws.n);
			if (ws.p != exists.ws.p) {
				var selected = exists.isSelected();
				var parent = this.getNode(ws.p);
				if (parent) {
					parent.appendChild(exists);
					exists.ws.parent = parent.ws.id;
					if (selected) exists.select();
				}
			}
			return;
		}
		var config = {
			cls: 'x-tree-noicon',
			text: ws.n,
			id: 'ws' + ws.id,
			checked: false,
			listeners: {
				click: function() {
					this.unselect();
					this.select();
				},
				checkchange: function(node, checkedValue) {
					og.eventManager.fireEvent("workspacechoosercc" + node.genid, {'wsid':node.ws.id, 'checked':checkedValue});
				}
			}
		};
		var node = new Ext.tree.TreeNode(config);
		node.ws = ws;
		node.genid = this.genid;
		var parent = this.getNodeById('ws' + ws.p);
		if (!parent) parent = this.workspaces;
		var iter = parent.firstChild;
		while (iter && node.text.toLowerCase() > iter.text.toLowerCase()) {
			iter = iter.nextSibling;
		}
		parent.insertBefore(node, iter);
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
	
	addWorkspaces: function(workspaces) {
		//Orders the workspaces so as to add them in hierarchy
		
		var workspacesToAdd = new Array();
		var continueOrdering = true;
		while(continueOrdering)
		{
			continueOrdering = false;
			for (var i = 0; i < workspaces.length; i++){
				var add = false;
				var ws = workspaces[i];
				if (ws.p == 0)
					add = true;
				else for (var j = 0; j < workspacesToAdd.length; j++)
					if (workspacesToAdd[j].id == ws.p){
						add = true;
						break;
					}
				if (add){
					continueOrdering = true;
					workspacesToAdd[workspacesToAdd.length] = workspaces.splice(i,1)[0];
					i--;
				}
			}
		}
		
		for (var i=0; i < workspacesToAdd.length; i++) {
			this.addWS(workspacesToAdd[i]);
		}
		this.workspaces.expand();
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
		return null;
	},
	
	filterNode: function(n, re) {
		var f = false;
		var c = n.firstChild;
		while (c) {
			f = this.filterNode(c, re) || f;
			c = c.nextSibling;
		}
		f = re.test(n.text.toLowerCase()) || f;
		if (!n.previousState) {
			// save the state before filtering
			n.previousState = n.expanded?"expanded":"collapsed";
		}
		if (f) {
			n.getUI().show();
		} else {
			n.getUI().hide();
		}
		return f;
	},
	
	filterTree: function(text) {
		var re = new RegExp(Ext.escapeRe(text.toLowerCase()), 'i');
		this.filterNode(this.workspaces, re);
		this.workspaces.getUI().show();
		this.expandAll();
	},
	
	clearFilter: function(n) {
		if (!n) n = this.workspaces;
		if (!n.previousState) return;
		var c = n.firstChild;
		while (c) {
			this.clearFilter(c);
			c = c.nextSibling;
		}
		n.getUI().show();
		if (this.getSelectionModel().getSelectedNode().isAncestor(n)) {
			n.previousState = "expanded";
		}
		if (n.previousState == "expanded") {
			n.expand();
		} else if (n.previousState == "collapsed") {
			n.collapse();
		}
		n.previousState = null;
	}
});

Ext.reg('wsctree', og.WorkspaceChooserTree);




