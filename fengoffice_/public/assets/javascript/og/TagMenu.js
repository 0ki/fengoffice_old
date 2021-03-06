

og.TagMenu = function(config, tags) {
	if (!config) config = {};
	
	var tagsItems = this.listTagsItems(tags);
	
	og.TagMenu.superclass.constructor.call(this, Ext.apply(config, {
		cls: 'scrollable-menu',
		items: [
		    {
			text: lang('add tag'),
			iconCls: 'ico-addtag',
			handler: function() {
				Ext.Msg.prompt(lang('add tag'),
					lang('enter the desired tag'),
					function (btn, text) {
						if (btn == 'ok' && text) {
							this.fireEvent('tagselect', text.replace(/^\s*|\s*$/g, ''));
						}
					},
					this	
				);
			},
			scope: this,
			id: lang('add tag')
		},
		'-',
	    {
	    	text: lang('delete tag'),
	    	menu: {
				items:  tagsItems
			},
			iconCls: 'ico-delete',
			scope: this,
			id: lang('delete tag')
		 }
		]
	}));
	
	if (Ext.isIE) { // Add scrollbar in IE
		this.getEl().child('ul.x-menu-list').addClass('iemenulist');
		this.getEl().child('ul.x-menu-list').setWidth(this.getEl().child('ul.x-menu-list').getWidth()+20);
	}
	
	this.addEvents({tagselect: true,tagdelete :true});
	this.tagnames = {};
	if (tags) {
		this.addTags(tags);
	}

	og.eventManager.addListener('tag added', this.addTag, this);
	og.eventManager.addListener('tag deleted', this.removeTag, this);
	
	this.loadTags();
};


Ext.extend(og.TagMenu, Ext.menu.Menu, {

	removeTag: function(tag) {
		var item = this.tagnames[tag.name];
		if (item) {
			this.remove(item);
		}
	},

	addTag : function(tag){
		var exists = this.tagnames[tag.name];
		if (exists) {
			return;
		}
		var item = new Ext.menu.Item({
			text: og.clean(tag.name),
			handler: function() {
				this.fireEvent('tagselect', tag.name);
			},
			scope: this
		});
		var c = this.items.getCount();
		this.insert(c-3, item);
		this.tagnames[tag.name] = item;
		
		return item;
	},
	
	exists: function(tagname) {
		return this.tagnames[tagname];
	},
	
	addTags: function(tags) {
		for (var i=0; i < tags.length; i++) {
			this.addTag(tags[i]);
		}
	},
	listTagsItems : function() {
		var items = new Array();
		items[0] = {
				text: lang('delete all tag'),
				handler: function() {
					this.fireEvent('tagdelete', '');							
				},
				scope: this,
				id: lang('delete all tags')
			};
		items [1] = {
			text: lang('delete tag'),
			handler: function() {
				Ext.Msg.prompt(lang('delete tag'),
					lang('enter the desired tag'),
					function (btn, text) {
						if (btn == 'ok' && text) {
							this.fireEvent('tagdelete', text.replace(/^\s*|\s*$/g, ''));
						}
					},
					this	
				);
			},
			scope: this,
			id: lang('delete tag by name')
		};
		items [2] = '-';
		var tags = Ext.getCmp('tag-panel').getTags();
		for (var i=0; i < tags.length; i++){
			items.push({
				text : tags[i].name,
				handler : function (btn) {
					this.fireEvent('tagdelete', btn.text);
				},
				scope: this
			});
		}
		return items;
	},
	loadTags: function() {
		var tags = Ext.getCmp('tag-panel').getTags();
		this.addTags(tags);
	}
});