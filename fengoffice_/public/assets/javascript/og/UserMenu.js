og.UserMenu = function(config, users) {
	if (!config) config = {};
	
	og.UserMenu.superclass.constructor.call(this, Ext.apply(config, {
		cls: 'scrollable-menu',
		items: [ 
			'-', {
			text: lang('view all'),
			handler: function() {
				this.fireEvent('userselect', -1);
			},
			scope: this,
			id: lang('view all')
		}]
	}));
	
	this.addEvents({userselect: true});
	this.userids = {};
	if (users) {
		this.addUsers(users);
	}

	og.eventManager.addListener('tag added', this.addUser, this);
	
	this.loadUsers();
};

Ext.extend(og.UserMenu, Ext.menu.Menu, {

	addUser : function(user){
		var exists = this.userids[user.id];
		if (exists) {
			return;
		}
		var item = new Ext.menu.Item({
			text: user.name,
			handler: function() {
				this.fireEvent('userselect', user.id);
			},
			scope: this
		});
		this.insert(0, item);
		this.userids[user.id] = item;
		return item;
	},
	
	exists: function(userid) {
		return this.userids[userid];
	},
	
	addUsers: function(users) {
		for (var i=0; i < users.length; i++) {
			this.addUser(users[i]);
		}
	},

	loadUsers: function() {
		og.openLink(og.getUrl('user', 'list_users'),{
			callback: function(success, data) {
				if (success) {
					try {
						var users = data.users;
						this.addUsers(users);
					} catch (e) {
						throw e;
					}
				}
			},
			scope: this
		});
	}
});
