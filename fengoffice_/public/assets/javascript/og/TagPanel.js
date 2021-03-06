og.TagPanel = function(config) {
	if (!config) config = {};
	this.tree = new og.TagTree(config.tagtree);
	
	Ext.applyIf(config, {
		split: true,
		height: 200,
		iconCls: 'ico-tags',
		title: lang('tags'),
		region: 'south',
		border: false,
		style: 'border-top-width: 1px',
		bodyBorder: false,
		collapsible: true,
		layout: 'fit',
		items: [this.tree],
		tbar: [{
			iconCls: 'ico-workspace-refresh',
			tooltip: lang('refresh desc'),
			handler: function() {
				this.loadTags();
			},
			scope: this.tree
		},{
			iconCls: 'ico-rename',
			tooltip: lang('rename tag'),
			id: 'rename',
			handler: function() {
				Ext.Msg.prompt(lang('rename tag'), lang('enter a new name for the tag') + ':',
					function(btn, text) {
						if (btn == 'ok') {
							this.renameTag(this.getSelectedTag().name, text);
						}
					},
					this);
			},
			scope: this.tree
		}]
	});
	og.TagPanel.superclass.constructor.call(this, config);
	
	this.tree = this.findById('tag-panel');
	
	this.tree.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			// TODO: disable/enable tb butt
			this.getTopToolbar().items.get('rename').setDisabled(!node || node == this.tree.tags);
		},
		scope:this
	});
};

Ext.extend(og.TagPanel, Ext.Panel, {});

og.TagTree = function(config) {
	if (!config) config = {};

	Ext.applyIf(config, {
		id: 'tag-panel',
		autoScroll: true,
		rootVisible: false,
		lines: false,
		border: false,
		bodyBorder: false,
		root: new Ext.tree.TreeNode(lang('tags')),
		collapseFirst: false,
		tbar: [{
			xtype: 'textfield',
			id: 'tag-filter',
			width: 200,
			emptyText:lang('filter tags'),
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
	og.TagTree.superclass.constructor.call(this, config);

	this.tags = this.root.appendChild(
		new Ext.tree.TreeNode({
			text: lang('all'),
			expanded: true
		})
	);
	this.tags.tag = {name: ""};

	this.getSelectionModel().on({
		'selectionchange' : function(sm, node) {
			if (node && !this.pauseEvents) {
				this.fireEvent('tagselect', node.tag);
			}
			var tf = this.getTopToolbar().items.get('tag-filter');
			tf.setValue("");
			this.filterTree("");
			if (node) {
				node.expand();
				node.ensureVisible();
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
	
	hasTag: function(tagname) {
		return this.getNodeById(tagname);
	},
	
	loadTags: function(url) {
		if (!url) {
			url = og.getUrl('tag', 'list_tags');
		}
		og.openLink(url, {
			callback: function(success, data) {
				if (success && data.tags) {
					var selected = this.getSelectedTag();
					this.removeAll();
					this.addTags(data.tags);
					
					this.tags.expand();
					
					if (this.hasTag(selected.name)) {
						this.pauseEvents = true;
						this.select(selected.name);
						this.pauseEvents = false;
					} else {
						this.pauseEvents = true;
						this.tags.select();
						this.pauseEvents = false;
					}
				}
			},
			scope: this
		});
	},
	
	removeAll: function() {
		var node = this.tags.firstChild;
		while (node) {
			var aux = node;
			node = node.nextSibling;
			aux.remove();
		}
	},
	
	filterNode: function(n, re) {
		var f = false;
		var c = n.firstChild;
		while (c) {
			f = this.filterNode(c, re) || f;
			c = c.nextSibling;
		}
		f = re.test(n.text.toLowerCase()) || f;
		if (f) {
			n.getUI().show();
		} else {
			n.getUI().hide();
		}
		return f;
	},
	
	filterTree: function(text) {
		this.expandAll();
		var re = new RegExp(Ext.escapeRe(text.toLowerCase()), 'i');
		this.filterNode(this.tags, re);
		this.tags.getUI().show();
	},
	
	renameTag: function(tagname, newTagname) {
		if (!this.hasTag(newTagname) || confirm(lang('confirm merge tags', tagname, newTagname))) {
			this.loadTags(og.getUrl('tag', 'rename_tag', {tag: tagname, new_tag: newTagname}));
		}
	}
});

Ext.reg('tagpanel', og.TagPanel);
Ext.reg('tagtree', og.TagTree);
