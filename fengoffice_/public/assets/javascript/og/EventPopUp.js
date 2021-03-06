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
		focus : function() {
                    Ext.get('subject').focus();
                },
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
								        url: '',//og.getUrl('event', 'add', {popup:'true', ajax:'true'),
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
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[hour]',
								                id: 'hour',
								                value: data.hour
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[minute]',
								                id: 'min',
								                value: data.minute
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[type_id]',
								                id: 'type_id',
								                value: data.type_id
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[durationhour]',
								                id: 'durationhour',
								                value: data.durationhour
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[durationmin]',
								                id: 'durationmin',
								                value: data.durationmin
								            },
								            {
								            	xtype: 'hidden',
								                name: 'event[start_value]',
								                id: 'start_value',
								                value: data.start_value
								            },
								            {
								            	xtype: 'hidden',
								                name: 'view',
								                id: 'view',
								                value: data.view
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
    
}


Ext.extend(og.EventPopUp, Ext.Window, {
	accept: function() {		
		this.hide();
		//var start_value = Ext.getCmp('month').getValue() + '/' + Ext.getCmp('day').getValue() + '/' + Ext.getCmp('year').getValue();
		og.openLink(og.getUrl('event', 'add'),{post:'popup=true&event[start_day]='+Ext.getCmp('day').getValue()+'&event[start_month]='+Ext.getCmp('month').getValue()+'&event[start_year]='+Ext.getCmp('year').getValue()+'&event[hour]='+Ext.getCmp('hour').getValue()+'&event[minute]='+Ext.getCmp('min').getValue()+'&event[type_id]='+Ext.getCmp('type_id').getValue()+'&event[durationhour]='+Ext.getCmp('durationhour').getValue()+'&event[durationmin]='+Ext.getCmp('durationmin').getValue()+'&view='+Ext.getCmp('view').getValue()+'&event[start_value]='+Ext.getCmp('start_value').getValue()+'&event[subject]='+Ext.getCmp('subject').getValue()});	
	},
	
	cancel: function() {
		this.hide();
	}
});

og.EventPopUp.show = function(callback, data, scope) {
	if (!this.dialog) {
		this.dialog = new og.EventPopUp(data);
	}
	this.the_data = data;
	this.dialog.setTitle(data.title);
	Ext.getCmp('year').setValue(data.year);	
	Ext.getCmp('month').setValue(data.month);	
	Ext.getCmp('day').setValue(data.day);
	Ext.getCmp('hour').setValue(data.hour);	
	Ext.getCmp('min').setValue(data.minute);	
	Ext.getCmp('type_id').setValue(data.type_id);	
	Ext.getCmp('subject').setValue('');
	Ext.getCmp('durationhour').setValue(data.durationhour);
	Ext.getCmp('durationmin').setValue(data.durationmin);
	Ext.getCmp('start_value').setValue(data.start_value);	
	Ext.getCmp('view').setValue(data.view);	
	this.dialog.purgeListeners();
	this.dialog.show();
	var pos = this.dialog.getPosition();
	if (pos[0] < 0) pos[0] = 0;
	if (pos[1] < 0) pos[1] = 0;
	this.dialog.setPosition(pos[0], pos[1]);
	Ext.getCmp('subject').focus();
}


og.EventPopUp.goToEdit = function (){
	var sub = Ext.getCmp('subject').getValue();	
	var data = this.the_data;
	og.openLink(og.getUrl('event', 'add', {subject: sub, day:data.day , month: data.month, year: data.year, hour: data.hour, minute: data.minute, durationhour:data.durationhour, durationmin:data.durationmin, start_value:data.start_value, type_id:data.type_id, view:data.view}), null);
	this.dialog.hide();	
}
