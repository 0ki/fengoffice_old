og.ConfirmDialog = function(data,config) {
	if (!config) config = {};
    
    og.ConfirmDialog.superclass.constructor.call(this, Ext.apply(config, {
		y: 50,
		width: 350,
		height: 140,
		id: 'confirm-dialog',
		layout: 'border',
		modal: true,
		resizable: false,
		closeAction: 'hide',
		iconCls: 'op-ico',
		title: data.title,
		border: false,
		focus : function() {
                    if (data.check_title) Ext.get('confirm_check').focus();
                    else if (data.text_title) Ext.get('text_box').focus();
                },
		buttons: [{
			text: lang('yes'),
			handler: this.accept,
			id: 'ok_button',
			scope: this
		},{
			text: lang('no'),
			handler: this.cancel,
			scope: this
		}],
		items: [
			{
				region: 'center',
				layout: 'fit',				
				items: [
					this.form = new Ext.FormPanel({
				        labelWidth: (data.check_title ? 270 : 70),
				        frame:false,
				        height: 100,
				        url: '',
				        bodyStyle:'padding:20px 20px 0',
				        defaultType: 'textfield',
						border:false,
						bodyBorder: false,									
				        items: [
				        	{
				            	xtype: 'checkbox',
				                name: 'confirm_check',
				                id: 'confirm_check',
				                hideLabel: ! data.check_title,
				                fieldLabel: data.check_title,
				                value: false
				            },
				            {
				            	xtype: 'textfield',
				            	name: 'text_box',
				                id: 'text_box',
				                hideLabel: ! data.text_title,
				                fieldLabel: data.text_title,
				                allowBlank:false
				            }
				        ]
				    })
				]
			}
		]
	}));
    
}


Ext.extend(og.ConfirmDialog, Ext.Window, {
	accept: function() {
		this.dialog.hide();
	},
	
	cancel: function() {
		this.hide();
	}
});

og.ConfirmDialog.show = function(callback, data, scope) {
	this.dialog = new og.ConfirmDialog(data);
	this.the_data = data;
	
	if (data.ok_fn) Ext.getCmp('ok_button').setHandler(data.ok_fn);
	
	if (!data.check_title) Ext.getCmp('confirm_check').setVisible(false);
	if (!data.text_title) Ext.getCmp('text_box').setVisible(false);
	
	this.dialog.purgeListeners();
	this.dialog.show();
	var pos = this.dialog.getPosition();
	if (pos[0] < 0) pos[0] = 0;
	if (pos[1] < 0) pos[1] = 0;
	this.dialog.setPosition(pos[0], pos[1]);
}

og.ConfirmDialog.hide = function() {
	if (this.dialog) this.dialog.hide();
}

og.ConfirmDialog.getConfirmCheckValue = function() {
	return Ext.getCmp('confirm_check').getValue();
}

og.ConfirmDialog.getTextBoxValue = function() {
	return Ext.getCmp('text_box').getValue();
}



og.ExtendedDialog = function(config) {
	og.ExtendedDialog.superclass.constructor.call(this, Ext.applyIf(config, {
		y: 50,
		id: config.genid + 'dialog',
		layout: 'border',
		modal: true,
		height:300,
		width:450,
		resizable: false,
		closeAction: 'hide',
		iconCls: 'op-ico',
		border: false,
		buttons: [{
			text: (config.YESNO ? lang('yes') : lang('ok')),
			handler: this.accept,
			id: config.genid + 'ok_button',
			scope: this
		},{
			text: (config.YESNO ? lang('no') : lang('cancel')),
			handler: this.cancel,
			scope: this
		}],
		items: [
			{
				region: 'center',
				layout: 'fit',				
				items: [
					this.form = new Ext.FormPanel({
				        frame:false,
				        url: '',
				        bodyStyle:'padding:20px 20px 0',
				        defaultType: 'textfield',
						border:false,
						bodyBorder: false,									
				        items: config.dialogItems
				    })
				]
			}
		]
	}));
}

Ext.extend(og.ExtendedDialog, Ext.Window, {
	accept: function() { this.dialog.hide(); },
	cancel: function() { this.hide(); }
});

og.ExtendedDialog.show = function(config) {
	if (!config)
		config = {};
	if (!config.genid)
		config.genid = 'Extended';
	if (this.dialog)
		this.dialog.destroy();
	this.dialog = new og.ExtendedDialog(config);
	
	if (config.ok_fn)
		Ext.getCmp(config.genid + 'ok_button').setHandler(config.ok_fn);
	
	this.dialog.purgeListeners();
	this.dialog.show();
	var pos = this.dialog.getPosition();
	if (pos[0] < 0) pos[0] = 0;
	if (pos[1] < 0) pos[1] = 0;
	this.dialog.setPosition(pos[0], pos[1]);
}

og.ExtendedDialog.hide = function() {
	if (this.dialog) this.dialog.hide();
}