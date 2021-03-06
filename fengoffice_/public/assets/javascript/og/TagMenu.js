

og.TagMenu = function(config, tags) {
	if (!config) config = {};
	
	og.TagMenu.superclass.constructor.call(this, Ext.apply(config, {
		cls: 'scrollable-menu',
		items: [ 
			'-', {
			text: lang('add tag'),
			iconCls: 'ico-addtag',
			handler: function() {
				Ext.Msg.prompt(lang('add tag'),
					lang('enter the desired tag'),
					function (btn, text) {
						if (btn == 'ok' && text) {
							this.fireEvent('tagselect', text);
						}
					},
					this	
				);
			},
			scope: this,
			id: lang('add tag')
		}]
	}));
	
	this.addEvents({tagselect: true});
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
			text: tag.name,
			handler: function() {
				this.fireEvent('tagselect', tag.name);
			},
			scope: this
		});
		this.insert(0, item);
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

	loadTags: function() {
		og.openLink(og.getUrl('tag', 'list_tags'),{
			callback: function(success, data) {
				if (success) {
					try {
						var tags = data.tags;
						this.addTags(tags);
					} catch (e) {
						throw e;
					}
				}
			},
			scope: this
		});
	}
});