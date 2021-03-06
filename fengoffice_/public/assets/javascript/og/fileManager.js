/**
 *  FileManager
 *  	filter:
 *  		project: Project id to filter
 *  		user: User id to filter
 *  		type: type to filter
 *  		tag: tag to filter
 *
 *
 */
og.FileManager = function(filter) {
	var actions, moreActions, tagMenu;
	
	function createTagMenu() {
		return new Ext.menu.Menu({
			items: [ 
				'-',
				{text: lang('add tag'), iconCls: 'fm-ico-addtag', handler: function() {
					Ext.Msg.prompt(lang('add tag'), lang('enter the desired tag'),
						function(btn, text) {
							if (btn == 'ok') {
								tagMenu = createTagMenu();
								store.load({
								params: {
									action: 'tag',
									files: getSelectedFiles(),
									tagTag: text,
									start: 0,
									limit: og.pageSize
								},
								callback: function() {
									var d = store.reader.jsonData;
									if (d.errorMessage) {
										if (d.errorCode < 0) {
											var title = "Error";
										} else {
											var title = "Success";
										}
										og.msg(title, d.errorMessage);
									}
								}
							});
							}
						}
					);
				}}
		]});
	}
	
	if (!filter) filter = {};
	if (filter[0] == '&') {
		filter = filter.substring(1);
	}
	if (typeof filter == 'string') {
		var aux = filter.split("&");
		filter = {};
		for (var i=0; i < aux.length; i++) {
			var aux2 = aux[i].split("=");
			if (aux2[0] != 'c' && aux2[0] != 'a') {
				filter[aux2[0]] = aux2[1];
			}
		}
	}
	var store = new Ext.data.Store({
        proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
			method: 'GET',
            url: og.getUrl('files', 'list_files', filter)
        })),
        reader: new Ext.data.JsonReader({
            root: 'files',
            totalProperty: 'totalCount',
            id: 'id',
            fields: [
                'name', 'type', 'tags', 'createdBy', 'createdById',
                {name: 'dateCreated', type: 'date', dateFormat: 'timestamp'},
				'updatedBy', 'updatedById',
				{name: 'dateUpdated', type: 'date', dateFormat: 'timestamp'},
				'icon', 'size', 'project', 'projectId'
            ]
        }),
        remoteSort: true,
        autoLoad: true,
		listeners: {
			'load': function() {
				if (store.getTotalCount() <= og.pageSize) {
					store.remoteSort = false;
				}
				var title = lang('documents') + ":&nbsp;&nbsp;&nbsp;";
				var d = store.reader.jsonData;
				if (d.project) {
					title += " " + lang("project") + " = " + d.project;
				}
				if (d.user) {
					title += " " + lang("user") + " = " + d.user;
				}
				if (d.type) {
					title += " " + lang("type") + " = " + d.type;
				}
				if (d.tag) {
					title += " " + lang("tag") + " = " + d.tag;
				}
				this.fileManager.setTitle(title);
				for (var i=0; i < d.tags.length; i++) {
					tagMenu.insert(i, new Ext.menu.Item({
						text: d.tags[i].name,
						handler: function() {
							tagMenu = createTagMenu();
							store.load({
								params: {
									action: 'tag',
									files: getSelectedFiles(),
									tagTag: this.text,
									start: 0,
									limit: og.pageSize
								},
								callback: function() {
									var d = store.reader.jsonData;
									if (d.errorMessage) {
										if (d.errorCode < 0) {
											var title = lang("error");
										} else {
											var title = lang("success");
										}
										og.msg(title, d.errorMessage);
									}
								}
							});
						}
					}));
				}
			}
		}
    });
    store.setDefaultSort('dateUpdated', 'desc');
    store.fileManager = this;

    function renderFilename(value, p, r) {
        return String.format(
                '<img src="{3}" class="fm-ico"><b><a href="#" onclick="og.openLink(\'{2}\', null, true)">{0}</a></b><br/><span class="fsize">{4} kb</span>',
                value, r.data.name, og.getUrl('files', 'open_file', {id: r.id}), r.data.icon, Math.ceil(r.data.size / 1024));
    }
    function renderLastUpdate(value, p, r) {
        return String.format('{0}<br/>&nbsp;&nbsp;&nbsp;<i>' + lang('by') + ' <a href="#" onclick="og.openLink(\'{2}\', null, true)">{1}</a></i>', value.dateFormat('M j, Y, g:i a'), r.data.updatedBy,
				og.getUrl('user', 'card', {id: r.data.updatedById}));
    }
	function renderCreated(value, p, r) {
        return String.format('{0}<br/>&nbsp;&nbsp;&nbsp;<i>' + lang('by') + ' <a href="#" onclick="og.openLink(\'{2}\', null, true)">{1}</a></i>', value.dateFormat('M j, Y, g:i a'), r.data.createdBy,
				og.getUrl('user', 'card', {id: r.data.createdById}));
    }
	function renderProject(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\', null, true)">{0}</a>', value, og.getUrl('project', 'index', {active_project: r.data.projectId}));
	}
	function getSelectedFiles() {
		var selections = sm.getSelections();
		if (selections.length <= 0) {
			return '';
		} else {
			var ret = '';
			for (var i=0; i < selections.length; i++) {
				ret += "," + selections[i].id;
			}	
			return ret.substring(1);
		}
	}
	
	function getFirstSelectedFile() {
		if (sm.hasSelection()) {
			return sm.getSelected().id;
		}
		return '';
	}

	var sm = new Ext.grid.CheckboxSelectionModel();
	sm.on('selectionchange',
		function() {
			if (sm.getCount() <= 0) {
				actions.tag.setDisabled(true);
				actions.delFile.setDisabled(true);
				actions.more.setDisabled(true);
			} else {
				actions.tag.setDisabled(false);
				actions.delFile.setDisabled(false);
				actions.more.setDisabled(false);
				if (sm.getSelected().data.type == 'prsn') {
					moreActions.slideshow.setDisabled(false);
				} else {
					moreActions.slideshow.setDisabled(true);
				}
			}
		});
    var cm = new Ext.grid.ColumnModel([
		sm,
		{
			id: 'filename',
			header: lang("name"),
			dataIndex: 'name',
			width: 120,
			renderer: renderFilename
        },
		{
			id: 'type',
			header: lang('type'),
			dataIndex: 'type',
			width: 120,
			hidden: true,
			sortable: false
		},
		{
			id: 'project',
			header: lang("project"),
			dataIndex: 'project',
			width: 120,
			renderer: renderProject,
			sortable: false
        },
		{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			sortable: false
        },
		{
			id: 'last',
			header: lang("last update"),
			dataIndex: 'dateUpdated',
			width: 150,
			renderer: renderLastUpdate
        },
		{
			id: 'created',
			header: lang("created on"),
			dataIndex: 'dateCreated',
			width: 150,
			renderer: renderCreated,
			hidden: true
		}]);
    cm.defaultSortable = true;
	
	moreActions = {
		download: new Ext.Action({
			text: lang('download'),
			iconCls: 'fm-ico-download',
			handler: function(e) {
				var url = og.getUrl('files', 'download_file', {id: getFirstSelectedFile()});
				location.href = url;
			}
		}),
		properties: new Ext.Action({
			text: lang('properties'),
			iconCls: 'fm-ico-properties',
			handler: function(e) {
				var url = og.getUrl('files', 'edit_file', {id: getFirstSelectedFile()});
				og.openLink(url, null, true);
			}
		}),
		revisions: new Ext.Action({
			text: lang('revisions and comments'),
			iconCls: 'fm-ico-revisions',
			handler: function(e) {
				var url = og.getUrl('files', 'file_details', {id: getFirstSelectedFile()});
				og.openLink(url, null, true);
			}
		}),
		slideshow: new Ext.Action({
			text: lang('slideshow'),
			iconCls: 'fm-ico-slideshow',
			handler: function(e) {
				var url = og.getUrl('files', 'slideshow', {fileId: getFirstSelectedFile()});
				var top = screen.height * 0.1;
				var left = screen.width * 0.1;
				var width = screen.width * 0.8;
				var height = screen.height * 0.8;
				window.open(url, 'slideshow', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')
			},
			disabled: true
		})
	}
	
	tagMenu = createTagMenu();
	
	actions = {
		newFile: new Ext.Action({
			text: lang('new'),
            tooltip: lang('create a file'),
            iconCls: 'fm-ico-new',
			menu: {items: [
				{text: lang('document'), iconCls: 'fm-ico-doc', handler: function() {
					var url = og.getUrl('files', 'add_document');
					og.openLink(url, null, true);
				}},
				{text: lang('spreadsheet'), iconCls: 'fm-ico-sprd', handler: function() {
					var url = og.getUrl('files', 'add_spreadsheet', {id: getFirstSelectedFile()});
					og.openLink(url, null, true);
				}},
				{text: lang('presentation'), iconCls: 'fm-ico-prsn', handler: function() {
					var url = og.getUrl('files', 'add_presentation', {id: getFirstSelectedFile()});
					og.openLink(url, null, true);
				}}
			]}
		}),
		upload: new Ext.Action({
			text: lang('upload'),
            tooltip: lang('upload a file'),
            iconCls: 'fm-ico-upload',
			handler: function() {
				var url = og.getUrl('files', 'add_file');
				og.openLink(url, null, true);
			}
		}),
		tag: new Ext.Action({
			text: lang('tag'),
            tooltip: lang('tag selected files'),
            iconCls: 'fm-ico-tag',
			disabled: true,
			menu: tagMenu
		}),
		delFile: new Ext.Action({
			text: lang('delete'),
            tooltip: lang('delete selected files'),
            iconCls: 'fm-ico-delete',
			disabled: true,
			handler: function() {
				if (confirm(lang('confirm delete file'))) {
					store.load({
						params: {
							action: 'delete',
							files: getSelectedFiles(),
							start: 0,
							limit: og.pageSize
						},
						callback: function() {
							var d = store.reader.jsonData;
							if (d.errorMessage) {
								if (d.errorCode < 0) {
									var title = "Error";
								} else {
									var title = "Success";
								}
								og.msg(title, d.errorMessage);
							}
						}
					});
				}
			}
		}),
		more: new Ext.Action({
			text: lang('more'),
            tooltip: lang('more actions on first selected file'),
            iconCls: 'fm-ico-more',
			disabled: true,
			menu: {items: [
				moreActions.download,
				moreActions.properties,
				moreActions.revisions,
				moreActions.slideshow
			]}
		})
    };
    
	og.FileManager.superclass.constructor.call(this, {
        store: store,
		layout: 'fit',
        cm: cm,
        closable: true,
        loadMask: true,
        bbar: new Ext.PagingToolbar({
            pageSize: og.pageSize,
            store: store,
            displayInfo: true,
            displayMsg: lang('displaying files of'),
            emptyMsg: lang("no files to display")
        }),
		viewConfig: {
            forceFit:true
        },
		sm: sm,
		tbar:[
			actions.newFile,
			actions.upload,
			'-',
            actions.tag,
			actions.delFile,
            actions.more
        ]
    });
};

Ext.extend(og.FileManager, Ext.grid.GridPanel, {});
