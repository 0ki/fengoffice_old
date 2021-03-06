

og.EmailAccountMenu = function(config, accounts, type) {
	if (!config) config = {};
	og.EmailAccountMenu.superclass.constructor.call(this, Ext.apply(config, {}));
	
	this.addEvents({accountselect: true});
	this.accountnames = {};
	if (accounts) {
		this.addAccounts(accounts);
	}
	
	this.loadAccounts(type);
	og.eventManager.addListener('mail account added', this.addAccount, this);
};

Ext.extend(og.EmailAccountMenu, Ext.menu.Menu, {

	removeAccount: function(account) {
		var item = this.accountnames[account.name];
		if (item) {
			this.remove(item);
		}
	},

	addAccount : function(account) {
		var exists = this.accountnames[account.id];
		if (exists) {
			return;
		};
		var item = new Ext.menu.Item({
			text: account.name,
            tooltip: account.email,
			handler: function() {
				this.fireEvent('accountselect', account.id);
			},
			scope: this
		});
		this.insert(0, item);
		this.accountnames[account.id] = item;
		return item;
	},
	
	exists: function(accountname) {
		return this.accountnames[accountname];
	},
	
	addAccounts: function(accounts) {
		for (var i=0; i < accounts.length; i++) {
			this.addAccount(accounts[i]);
		}
	},

	loadAccounts: function(type) {
		og.loading();
		Ext.Ajax.request({
			url: og.getUrl('mail', 'list_accounts', {type: type}),
			callback: function(options, success, response) {
				if (success) {
					try {
						var accounts = Ext.util.JSON.decode(response.responseText);
						this.addAccounts(accounts);
					} catch (e) {
						og.msg(lang("error"), e.message);
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