/**
 *  QuickAdd
 *
 */
og.QuickAdd = function() {
	og.QuickAdd.superclass.constructor.call(this, {
		text: lang('new'),
		renderTo: 'quickAdd',
        tooltip: lang('create an object'),
        cls: 'quickAddButton',
        height:18,
        style:'padding-left:18px',
        overCls:'quickAddButtonHover',
		menu: {items: [
			{text: lang('contact'), iconCls: 'ico-contact', handler: function() {
				var url = og.getUrl('contact', 'add');
				og.openLink(url/*, {caller: 'contacts-panel'}*/);
			}},
			{text: lang('event'), iconCls: 'ico-event', handler: function() {
				var url = og.getUrl('event', 'add');
				og.openLink(url/*, {caller: 'calendar-panel'}*/);
			}},
			{text: lang('task'), iconCls: 'ico-task', handler: function() {
				var url = og.getUrl('task', 'add_task');
				og.openLink(url/*, {caller: 'tasks-panel'}*/);
			}},
			{text: lang('milestone'), iconCls: 'ico-milestone', handler: function() {
				var url = og.getUrl('milestone', 'add');
				og.openLink(url/*, {caller: 'tasks-panel'}*/);
			}},
			{text: lang('webpage'), iconCls: 'ico-webpages', handler: function() {
				var url = og.getUrl('webpage', 'add');
				og.openLink(url/*, {caller: 'webpages-panel'}*/);
			}},
			{text: lang('message'), iconCls: 'ico-message', handler: function() {
				var url = og.getUrl('message', 'add');
				og.openLink(url/*, {caller: 'messages-panel'}*/);
			}},
			{text: lang('document'), iconCls: 'ico-doc', handler: function() {
				var url = og.getUrl('files', 'add_document');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			/*{text: lang('spreadsheet'), iconCls: 'ico-sprd', handler: function() {
				var url = og.getUrl('files', 'add_spreadsheet');
				og.openLink(url, {caller: 'documents-panel'});
			}},*/
			{text: lang('presentation'), iconCls: 'ico-prsn', handler: function() {
				var url = og.getUrl('files', 'add_presentation');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			{text: lang('upload file'), iconCls: 'ico-upload', handler: function() {
				var url = og.getUrl('files', 'add_file');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}},
			{text: lang('email'), iconCls: 'ico-email', handler: function() {
				var url = og.getUrl('mail', 'add_mail');
				og.openLink(url/*, {caller: 'documents-panel'}*/);
			}}
		]}
	});
};

Ext.extend(og.QuickAdd, Ext.Button, {});