

og.TagMenu = function(config, tags) {
	if (!config) config = {};
	
	og.TagMenu.superclass.constructor.call(this, Ext.apply(config, {
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
		og.loading();
		Ext.Ajax.request({
			url: og.getUrl('tag', 'list_tags', {ajax: true}),
			callback: function(options, success, response) {
				if (success) {
					try {
						var tags = Ext.util.JSON.decode(response.responseText);
						this.addTags(tags.tags);
					} catch (e) {
						//og.msg(lang("error"), e.message);
						throw e;
					}
				} else {
					og.msg(lang("error"), lang("server could not be reached"));
				}
				og.hideLoading();
			},
			scope: this
		});
	}
});