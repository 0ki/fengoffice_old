og.EventPopUp = function(data,config) {
	if (!config) config = {};
        
    og.EventPopUp.superclass.constructor.call(this, Ext.apply(config, {
		y: 50,
		width: 350,
		height: 170,
		id: 'add-event',
		layout: 'border',
		modal: true,
		resizable: false,
		closeAction: 'hide',
		iconCls: 'op-ico',
		title: data.title,
		border: false,
		buttons: [{
			text: lang('add event'),
			handler: this.accept,
			scope: this
		},{
			text: lang('cancel'),
			handler: this.cancel,
			scope: this
		}],
		items: [
			{
				region: 'center',
				layout: 'fit',				
				items: [
					this.form = new Ext.FormPanel({
								        labelWidth: 75, // label settings here cascade unless overridden
								        frame:false,
								        height: 80,
								        url: og.getUrl('event', 'add', {popup:'true'}),
								        bodyStyle:'padding:20px 20px 0',
								        defaultType: 'textfield',
										border:false,
										bodyBorder: false,									
								        items: [
								        	{
								                fieldLabel: lang('subject'),
								                name: 'event[subject]',
								                id: 'subject',
								                allowBlank:false
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[start_day]',
								                id: 'day',
								                value: data.day
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[start_month]',
								                id: 'month',
								                value: data.month
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[start_year]',
								                id: 'year',
								                value: data.year
								            }
								        ]
								    })
				]
			},{
				region: 'south',
				height: 20,
		        html:"<div style='width:100%; text-align:right; padding-right:8px'><a href='#' onclick=\"og.EventPopUp.goToEdit()\">Edit event details</a></div>"
			}
		]
	}));
    
	this.addEvents({'eventadded': true});
}


Ext.extend(og.EventPopUp, Ext.Window, {
	accept: function() {
		var data=this.the_data;
		this.form.getForm().submit();
		//this.fireEvent('eventadded', Ext.getCmp('day').getValue());
		this.hide();
	},
	
	cancel: function() {
		this.hide();
	}
});

og.EventPopUp.show = function(callback, data, scope) {
	if (!this.dialog) {
		this.dialog = new og.EventPopUp(data);
	}
	this.the_data= data;
	this.dialog.setTitle(data.title);
	Ext.getCmp('year').setValue(data.year);	
	Ext.getCmp('month').setValue(data.month);	
	Ext.getCmp('day').setValue(data.day);	
	
	
	this.dialog.purgeListeners();
	this.dialog.on('eventadded', callback, scope, {single:true});
	this.dialog.show();
	var pos = this.dialog.getPosition();
	if (pos[0] < 0) pos[0] = 0;
	if (pos[1] < 0) pos[1] = 0;
	this.dialog.setPosition(pos[0], pos[1]);
}


og.EventPopUp.goToEdit = function (){
	var sub = Ext.getCmp('subject').getValue();	
	var data=this.the_data;
	og.openLink(og.getUrl('event', 'add', {subject: sub,day:data.day , month: data.month, year: data.year}), null);
	this.dialog.hide();	
}
