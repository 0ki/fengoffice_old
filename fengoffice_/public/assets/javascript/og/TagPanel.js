og.TagPanel = function(config) {
	if (!config) config = {};
	this.tree = new og.TagTree(config.tagtree);
	
	Ext.applyIf(config, {
		split: true,
		height: 200,
		iconCls: 'ico-tags',
		title: lang('tags'),
		region: 'south',
		collapsible: true,
		layout: 'fit',
		items: [this.tree],
		tbar: [{
			iconCls: 'ico-workspace-refresh',
			tooltip: lang('refresh desc'),
			handler: this.tree.loadTags,
			scope: this.tree
		}]
	});
	og.TagPanel.superclass.constructor.call(this, config);
};

Ext.extend(og.TagPanel, Ext.Panel, {});

og.TagTree = function(config) {
	if (!config) config = {};
	var tags = config.tags;
	delete config.tags;

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
			return n == tree.tags || re.test(n.text.toLowerCase());
		});
	}

	Ext.applyIf(config, {
		id: 'tag-panel',
		autoScroll: true,
		rootVisible: false,
		lines: false,
		root: new Ext.tree.TreeNode(lang('tags')),
		collapseFirst: false,
		tbar: [new Ext.form.TextField({
			width: 200,
			emptyText:lang('filter tags'),
			listeners:{
				render: function(f){
					f.el.on('keyup', filterTree, f, {buffer: 350});
				}
			}
		})]
	});
	og.TagTree.superclass.constructor.call(this, config);

	this.tags = this.root.appendChild(
		new Ext.tree.TreeNode({
			text: lang('all'),
			expanded: true
		})
	);
	this.tags.tag = {name: ""};
	
	if (tags) {
		this.addTags(tags);
	}

	this.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			if (node && !this.pauseEvents) {
				this.fireEvent('tagselect', node.tag);
			}
		},
		scope:this
	});

	this.addEvents({tagselect: true});
	
	og.eventManager.addListener('tag added', this.addTag, this);
	og.eventManager.addListener('tag deleted', this.removeTag, this);
	
	this.loadTags();
};

Ext.extend(og.TagTree, Ext.tree.TreePanel, {

	removeTag: function(tag) {
		var node = this.getNodeById(tag.name);
		if (node) {
			node.unselect();
			Ext.fly(node.ui.elNode).ghost('l', {
				callback: node.remove, scope: node, duration: .4
			});
		}
	},

	addTag : function(tag){
		var exists = this.getNodeById(tag.name);
		if (exists) {
			return;
		}
		var config =  {
			iconCls: 'ico-tag',
			leaf: true,
			cls: 'tag-item',
			text: tag.name,
			id: tag.name
		};
		var node = new Ext.tree.TreeNode(config);
		node.tag = tag;
		this.tags.appendChild(node);
		/*Ext.fly(node.ui.elNode).slideIn('l', {
			callback: Ext.emptyFn, scope: this, duration: .4
		});*/
		return node;
	},
	
	addTags: function(tags) {
		for (var i=0; i < tags.length; i++) {
			this.addTag(tags[i]);
		}
	},
	
	getSelectedTag: function() {
		var s = this.getSelectionModel().getSelectedNode();
		if (s) {
			return this.getSelectionModel().getSelectedNode().tag;
		} else {
			return {name: ''};
		}
	},
	
	select: function(id) {
		if (!id) {
			this.tags.select();
		} else {
			var node = this.getNodeById(id);
			if (node) {
				node.select();
			}
		}
	},
	
	loadTags: function() {
		og.openLink(og.getUrl('tag', 'list_tags'), {
			callback: function(success, data) {
				this.addTags(data.tags);
				
				this.pauseEvents = true;
				this.tags.select();
				this.pauseEvents = false;
			},
			scope: this
		});
	}
});

Ext.reg('tagpanel', og.TagPanel);
Ext.reg('tagtree', og.TagTree);
