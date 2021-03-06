/**
 *  QuickAdd
 *
 */
og.QuickAdd = function(config) {
	og.QuickAdd.superclass.constructor.call(this, Ext.applyIf(config || {}, {
		text: lang('new'),
        tooltip: lang('create an object'),
        iconCls: 'ico-quick-add',
		menu: {items: [
			{id: 'contact', text: lang('contact'), iconCls: 'ico-contact', handler: function() {
				var url = og.getUrl('contact', 'add');
				og.openLink(url/*, {caller: 'contacts-panel'}*/);
			}},
			{id: 'company', text: lang('company'), iconCls: 'ico-company', handler: function() {
				var url = og.getUrl('company', 'add_client');
				og.openLink(url/*, {caller: 'contacts-panel'}*/);
			}},
			{id: 'event', text: lang('event'), iconCls: 'ico-event', handler: function() {
				var url = og.getUrl('event', 'add');
				og.openLink(url/*, {caller: 'calendar-panel'}*/);
			}},
			{id: 'task', text: lang('task'), iconCls: 'ico-task', handler: function() {
				var url = og.getUrl('task', 'add_task');
				og.openLink(url/*, {caller: 'tasks-panel'}*/);
			}},
			{id: 'milestone', text: lang('milestone'), iconCls: 'ico-milestone', handler: function() {
				var url = og.getUrl('milestone', 'add');
				og.openLink(url/*, {caller: 'tasks-panel'}*/);
			}},
			{id: 'weblink', text: lang('webpage'), iconCls: 'ico-webpages', handler: function() {
				var url = og.getUrl('webpage', 'add');
				og.openLink(url/*, {caller: 'webpages-panel'}*/);
			}},
			{id: 'note', text: lang('message'), iconCls: 'ico-message', handler: function() {
				var url = og.getUrl('message', 'add');
				og.openLink(url/*, {caller: 'messages-panel'}*/);
			}},
			{id: 'document', text: lang('document'), iconCls: 'ico-doc', handler: function() {
				var url = og.getUrl('files', 'add_document');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			{id: 'spreadsheet', text: lang('spreadsheet'), iconCls: 'ico-sprd', handler: function() {
				var url = og.getUrl('files', 'add_spreadsheet');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			{id: 'presentation', text: lang('presentation'), iconCls: 'ico-prsn', handler: function() {
				var url = og.getUrl('files', 'add_presentation');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			{id: 'file', text: lang('upload file'), iconCls: 'ico-upload', handler: function() {
				var url = og.getUrl('files', 'add_file');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			{id: 'email', text: lang('email'), iconCls: 'ico-email', handler: function() {
				var url = og.getUrl('mail', 'add_mail');
				og.openLink(url/*, {caller: 'mails-panel'}*/);
			}}
		]}
	}));
	
	// ENABLE / DISABLE MODULES	
	og.eventManager.addListener('config enable_notes_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('note').show();
		} else {
			this.menu.items.get('note').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_email_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('email').show();
		} else {
			this.menu.items.get('email').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_contacts_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('contact').show();
			this.menu.items.get('company').show();
		} else {
			this.menu.items.get('contact').hide();
			this.menu.items.get('company').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_calendar_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('event').show();
		} else {
			this.menu.items.get('event').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_documents_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('document').show();
			this.menu.items.get('presentation').show();
			this.menu.items.get('spreadsheet').show();
			this.menu.items.get('file').show();
		} else {
			this.menu.items.get('document').hide();
			this.menu.items.get('presentation').hide();
			this.menu.items.get('spreadsheet').hide();
			this.menu.items.get('file').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_tasks_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('task').show();
			this.menu.items.get('milestone').show();
		} else {
			this.menu.items.get('task').hide();
			this.menu.items.get('milestone').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_weblinks_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('weblink').show();
		} else {
			this.menu.items.get('weblink').hide();
		}
	}, this);
	/*og.eventManager.addListener('config enable_time_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('timeslot').show();
		} else {
			this.menu.items.get('timeslot').hide();
		}
	}, this);
	og.eventManager.addListener('config enable_reporting_module changed', function(val) {
		if (val == 1) {
			this.menu.items.get('report').show();
		} else {
			this.menu.items.get('report').hide();
		}
	}, this);*/
};

Ext.extend(og.QuickAdd, Ext.Button, {});