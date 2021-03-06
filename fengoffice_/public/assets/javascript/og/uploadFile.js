
og.UploadFile = function() {
	var tagFieldSet, userFieldSet, pf;

	var tags = [
		['hola'],
		['chau']
	];

	var users = [
		['1', 'acio']
	];
	
	var projects = [
		['1', 'acio_personal'],
		['2', 'cococo']
	];

	function addTagField(i) {
		var tf = new Ext.form.ComboBox({
			store: new Ext.data.SimpleStore({
				fields: ['tag'],
				data : tags
			}),
			id: 'tag' + i,
			name: 'tag' + i,
			displayField: 'tag',
			emptyValue: '',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			anchor: '100%',
			emptyText: lang('select a tag'),
			selectOnFocus: true,
			fieldLabel: "Tag " + (i + 1),
			listeners: {
				'specialkey': function(ff, e) {
					if (e.getKey() == e.ENTER && this.isValid()) {
						var i = parseInt(this.id.substring(3)) + 1;
						var next = tagFieldSet.findById('tag' + i);
						if (next) {
							next.focus();
						} else {
							addTagField(i);
						}
					}
				}
			}
		});
		tagFieldSet.add(tf);
		tagFieldSet.doLayout();
		tf.focus();
	}
	
	function addUserField(i) {
		var tf = new Ext.form.ComboBox({
			store: new Ext.data.SimpleStore({
				fields: ['id', 'name'],
				data : users
			}),
			id: 'user' + i,
			name: 'user' + i,
			displayField: 'name',
			valueField: 'id',
			emptyValue: '',
			forceSelection: true,
			typeAhead: true,
			mode: 'local',
			anchor: '100%',
			triggerAction: 'all',
			emptyText: lang('select a user'),
			selectOnFocus: true,
			fieldLabel: "User " + (i + 1),
			listeners: {
				'specialkey': function(ff, e) {
					if (e.getKey() == e.ENTER && this.isValid()) {
						var i = parseInt(this.id.substring(4)) + 1;
						var next = userFieldSet.findById('user' + i);
						if (next) {
							next.focus();
						} else {
							addUserField(i);
						}
					}
				}
			}
		});
		userFieldSet.add(tf);
		userFieldSet.doLayout();
		tf.focus();
	}

    og.UploadFile.superclass.constructor.call(this, {
        labelWidth: 50,
        url: og.getUrl('files', 'add_file', {ajax: true}),
        frame:true,
        //title: lang('upload a file'),
        bodyStyle:'padding:5px 5px 0',
        width: 550,
		fileUpload: true,
		autoScroll: true,
		waitMsgTarget: true,
        items: [{
			xtype:'fieldset',
			width: 550,
            title: lang('file'),
            autoHeight:true,
            defaultType: 'textfield',
			layout: 'column',
			items: [{
				id: 'file_file',
				name: 'file_file',
				inputType:'file'
			},{
				xtype: 'panel',
				html: '<p>' + lang('upload file desc', og.filesizeFormat(og.maxUploadSize)) + '</p>',
				columnWidth: .5
			}]
		},{
            xtype:'fieldset',
            width: 550,
            collapsible:true,
            title: lang('project'),
            autoHeight:true,
            defaultType: 'panel',
            collapsed: false,
			layout: 'column',
			defaults: {width: 100},
            items :[
            	pf = new Ext.form.ComboBox({
					id: 'project',
					name: 'file[project_id]',
					store: new Ext.data.SimpleStore({
				        fields: ['id', 'name'],
				        data : projects
				    }),
					displayField: 'name',
					valueField: 'id',
					forceSelection: true,
					typeAhead: true,
					mode: 'local',
					triggerAction: 'all',
					emptyText: lang('select a project'),
					emptyValue: '',
					selectOnFocus: true,
					hideLabel: true,
					fieldLabel: lang('project'),
					columnWidth: .45
				}),{
					columnWidth: .05,
					html: "&nbsp;"
				},{
					html: '<p>' + lang('upload project desc') + '</p>',
					columnWidth: .5
				}]
        }, tagFieldSet = new Ext.form.FieldSet({
        	width: 550,
            collapsible:true,
            collapsed: true,
            title: lang('tags'),
            autoHeight:true,
            defaultType: 'textfield',
            collapsed: false,
			items: [{
				xtype: 'panel',
				html: '<p>' + lang('upload tag desc') + '</p>', //Here you can select an existing tag or a new tag for the file. After selecting the tag press Enter to add another tag.
				hideLabel: true
			}]
        }),
			userFieldSet = new Ext.form.FieldSet({
			width: 550,
            collapsible:true,
            collapsed: true,
            title: lang('permissions'),
            autoHeight:true,
            defaultType: 'textfield',
            collapsed: false,
			items: [{
				xtype: 'panel',
				html: '<p>' + lang('upload permissions desc') + '</p>', //Choose the users that will have permission to access the file. Analog to the tags, type or choose a username and then press enter to keep adding other users.
				hideLabel: true
			}]
		}),{
            xtype:'fieldset',
            width: 550,
            collapsible:true,
            collapsed: true,
            title: lang('description'),
            autoHeight:true,
            defaultType: 'textarea',
            collapsed: false,
            items :[{
				xtype: 'panel',
				html: '<p>' + lang('upload description desc') + '</p>' //Type a description for the file.
			},{
				hideLabel: true,
				fieldLabel: lang('description'),
				id: 'description',
				name: 'file[description]',
				value: 'blah blah',
				anchor: '100%'
            }]
        },{
            xtype:'fieldset',
            width: 550,
            collapsible:true,
            collapsed: true,
            title: lang('options'),
            autoHeight:true,
            defaultType: 'panel',
            collapsed: false,
            items :[{
				layout: 'column',
				items: [{
					xtype: 'checkbox',
					cls: 'checkbox',
					hideLabel: true,
					boxLabel: lang('private file'),
					value: 'on',
					id: 'private',
					name: 'file[is_private]',
					columnWidth: .35
				},{
					columnWidth: .65,
					html: '<p>' + lang('private file desc') + '</p>'
				}]
            },{
				layout: 'column',
				items: [{
					xtype: 'checkbox',
					cls: 'checkbox',
					hideLabel: true,
					boxLabel: lang('important file'),
					value: 'on',
					id: 'important',
					name: 'file[is_important]',
					columnWidth: .35
				},{
					columnWidth: .65,
					html: '<p>' + lang('important file desc') + '</p>'
				}]
            },{
				layout: 'column',
				items: [{
					xtype: 'checkbox',
					cls: 'checkbox',
					hideLabel: true,
					boxLabel: lang('enable comments'),
					value: 'on',
					id: 'comments',
					name: 'file[comments_enabled]',
					columnWidth: .35
				},{
					columnWidth: .65,
					html: '<p>' + lang('enable comments desc') + '</p>'
				}]
            },{
				layout: 'column',
				items: [{
					xtype: 'checkbox',
					cls: 'checkbox',
					hideLabel: true,
					boxLabel: lang('enable anonymous comments'),
					value: 'on',
					id: 'anonymous',
					name: 'file[anonymous_comments_enabled]',
					columnWidth: .35
				},{
					columnWidth: .65,
					html: '<p>' + lang('enable anonymous comments desc') + '</p>'
				}]
            }]
        }],

        buttons: [{
            text: lang('upload'),
			handler: function() {
				this.doUpload({
					success: function(x) {
						og.msg('Sucess', 'File uploaded successfully!');
						alert(x._text);
					},
					failure: function() {
						og.msg('Failure', 'Error uploading file. Check the highlighted fields for details.');
					},
					scope: this
				});
			},
			scope: this
        }]
    });
    
    this.doLayout();
    this.getForm().load();
	
	addTagField(0);
	addUserField(0);

	pf.setValue(1);
}

Ext.extend(og.UploadFile, Ext.form.FormPanel, {
	doUpload: function(o){
		if (!o) o = {};
		var id = Ext.id();
		var frame = document.createElement('iframe');
		frame.id = id;
		frame.name = id;
		frame.className = 'x-hidden';
		if(Ext.isIE){
		    frame.src = Ext.SSL_SECURE_URL;
		}
		document.body.appendChild(frame);
		
		if(Ext.isIE){
		   document.frames[id].name = id;
		}
		
		var form = this.getForm();
		form.target = id;
		form.method = 'POST';
		form.enctype = form.encoding = 'multipart/form-data';
		
		function cb() {
			var x;
		    try { //
		        var doc;
		        if(Ext.isIE){
		            doc = frame.contentWindow.document;
		        }else {
		            doc = (frame.contentDocument || window.frames[id].document);
		        }
		        if(doc && doc.body){
		        	try {
		        		x = eval(doc.body.innerHTML);
		        		x._text = doc.body.innerHTML;
		        	} catch (e) {
		        	}
		        }
		    }
		    catch(e) {
		    }
		    
		    if (x && o.success) {
		    	o.scope = (o.scope)?o.scope:this;
		    	o.success.call(o.scope, x);
		    } else if (o.failure) {
		    	o.scope = (o.scope)?o.scope:this;
		    	o.failure.call(o.scope);
		    }
		
		    Ext.EventManager.removeListener(frame, 'load', cb, this);
		    setTimeout(function(){Ext.removeNode(frame);}, 100);
		}
		
		Ext.EventManager.on(frame, 'load', cb, this);
		form.submit();
	}
});