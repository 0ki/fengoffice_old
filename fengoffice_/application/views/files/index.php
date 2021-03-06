<?php
	set_page_title(lang('documents'));
	//project_tabbed_navigation(PROJECT_TAB_FILES);
	$files_crumbs = array(
		0 => array(lang('files'), get_url('files'))
	); // array
	if($current_folder instanceof ProjectFolder) {
		$files_crumbs[] = array($current_folder->getName(), $current_folder->getBrowseUrl($order));
	} // if
	$files_crumbs[] = array(lang('index'));
	
	project_crumbs($files_crumbs);
	
	add_stylesheet_to_page('file/files.css');
	add_javascript_to_page('file/slideshow.js');

?>

<div id="file-manager"></div>

<script type="text/javascript">
function initFileManager() {
	var lang = new Array();
	lang["project"] = "<?php echo lang("project") ?>";
	lang["tag"] = "<?php echo lang("tag") ?>";
	lang["type"] = "<?php echo lang("type") ?>";
	lang["all"] = "<?php echo lang("all") ?>";
	lang["user"] = "<?php echo lang("user") ?>";

	var pageSize = <?php echo config_option('files_per_page') ?>;
	var fileFilter = "<?php echo ($allParam?"&all=true":"") . ($projectParam?"&project=" . $projectParam:"") .
				($tagParam?"&tag=" . $tagParam:"") .
				($userParam?"&user=" . $userParam:"") .
				($typeParam?"&type=" . $typeParam:"");
	?>";
	if (fileFilter) {
		Cookies.set('fileFilter', fileFilter);
	} else {
		fileFilter = Cookies.get('fileFilter');
	}
	
	var store = new Ext.data.Store({
        proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
			method: 'GET',
            url: '<?php echo str_replace("&amp;", "&", get_url('files', 'list_files')) ?>' + fileFilter
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
		listeners: {
			'load': function() {
				if (store.getTotalCount() <= pageSize) {
					store.remoteSort = false;
				}
				var title = "<?php echo lang('documents') ?>:&nbsp;&nbsp;&nbsp;";
				if (store.reader.jsonData.project) {
					title += " " + lang["project"] + " = " + store.reader.jsonData.project;
				}
				if (store.reader.jsonData.user) {
					title += " " + lang["user"] + " = " + store.reader.jsonData.user;
				}
				if (store.reader.jsonData.type) {
					title += " " + lang["type"] + " = " + store.reader.jsonData.type;
				}
				if (store.reader.jsonData.tag) {
					title += " " + lang["tag"] + " = " + store.reader.jsonData.tag;
				}
				contentPanel.setTitle(title);
			}
		}
    });
    store.setDefaultSort('dateUpdated', 'desc');

    function renderFilename(value, p, r) {
        return String.format(
                '<img src="{3}" class="fm-ico"><b><a href="{2}">{0}</a></b><br/><span class="fsize">{4} kb</span>',
                value, r.data.name, "<?php echo get_url('files', 'open_file') ?>&id=" + r.id, r.data.icon, Math.ceil(r.data.size / 1024));
    }
    function renderLastUpdate(value, p, r) {
        return String.format('{0}<br/>&nbsp;&nbsp;&nbsp;<i>by <a href="{2}">{1}</a></i>', value.dateFormat('M j, Y, g:i a'), r.data.updatedBy,
				"<?php echo get_url('user', 'card') ?>&id=" + r.data.updatedById);
    }
	function renderCreated(value, p, r) {
        return String.format('{0}<br/>&nbsp;&nbsp;&nbsp;<i>by <a href="{2}">{1}</a></i>', value.dateFormat('M j, Y, g:i a'), r.data.createdBy,
				"<?php echo get_url('user', 'card') ?>&id=" + r.data.createdById);
    }
	function renderProject(value, p, r) {
		return String.format('<a href="{1}">{0}</a>', value, "<?php echo get_url('project', 'index') ?>&active_project=" + r.data.projectId);
	}

	sm = new Ext.grid.CheckboxSelectionModel();
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
			header: "Name",
			dataIndex: 'name',
			width: 120,
			renderer: renderFilename
        },
		{
			id: 'type',
			header: 'Type',
			dataIndex: 'type',
			width: 120,
			hidden: true,
			sortable: false
		},
		{
			id: 'project',
			header: "Project",
			dataIndex: 'project',
			width: 120,
			renderer: renderProject,
			sortable: false
        },
		{
			id: 'tags',
			header: "Tags",
			dataIndex: 'tags',
			width: 120,
			sortable: false
        },
		{
			id: 'last',
			header: "Last Update",
			dataIndex: 'dateUpdated',
			width: 150,
			renderer: renderLastUpdate
        },
		{
			id: 'created',
			header: "Created on",
			dataIndex: 'dateCreated',
			width: 150,
			renderer: renderCreated,
			hidden: true
		}]);
    cm.defaultSortable = true;
	
	moreActions = {
		download: new Ext.Action({
			text: 'Download',
			iconCls: 'fm-ico-download',
			handler: function() { download('<?php echo str_replace("&amp;", "&", get_url('files', 'download_file')) ?>'); }
		}),
		properties: new Ext.Action({
			text: 'Properties',
			iconCls: 'fm-ico-properties',
			handler: function() { properties('<?php echo str_replace("&amp;", "&", get_url('files', 'edit_file')) ?>'); }
		}),
		revisions: new Ext.Action({
			text: 'Revisions & Comments',
			iconCls: 'fm-ico-revisions',
			handler: function() { revisions('<?php echo str_replace("&amp;", "&", get_url('files', 'file_details')) ?>'); }
		}),
		slideshow: new Ext.Action({
			text: 'Slideshow',
			iconCls: 'fm-ico-slideshow',
			handler: function() { runSlideshow('<?php echo str_replace("&amp;", "&", get_url('files', 'slideshow')) ?>'); },
			disabled: true
		})
	}
	
	actions = {
		newFile: new Ext.Action({
			text: 'New',
            tooltip: 'Create a file',
            iconCls: 'fm-ico-new',
			menu: {items: [
				{text: 'Document', iconCls: 'fm-ico-doc', handler: function() { gotoUrl('<?php echo str_replace("&amp;", "&", get_url('files', 'add_document')) ?>'); }},
				{text: 'Spreadsheet', iconCls: 'fm-ico-sprd', handler: function() { gotoUrl('<?php echo str_replace("&amp;", "&", get_url('files', 'add_spreadsheet')) ?>'); }},
				{text: 'Presentation', iconCls: 'fm-ico-prsn', handler: function() { gotoUrl('<?php echo str_replace("&amp;", "&", get_url('files', 'add_presentation')) ?>'); }}
			]}
		}),
		upload: new Ext.Action({
			text: 'Upload',
            tooltip: 'Upload a file',
            iconCls: 'fm-ico-upload',
			handler: function() { gotoUrl('<?php echo str_replace("&amp;", "&", get_url('files', 'add_file')) ?>'); }
		}),
		tag: new Ext.Action({
			text: 'Tag',
            tooltip: 'Tag selected files',
            iconCls: 'fm-ico-tag',
			disabled: true,
			menu: {items: [
				<?php foreach($tags as $tag ) { ?>
					{text: '<?php echo $tag ?>', handler: function() { tagFiles('<?php  echo  $tag; ?>', '<?php echo str_replace("&amp;", "&", get_url('files', 'tag_file')) ?>'); }},
				<?php } ?> 
				'-',
				{text: 'Add Tag', iconCls: 'fm-ico-addtag', handler: function() { addTag('<?php echo str_replace("&amp;", "&", get_url('files', 'tag_file')) ?>') }}
			]}
		}),
		delFile: new Ext.Action({
			text: 'Delete',
            tooltip: 'Delete selected files',
            iconCls: 'fm-ico-delete',
			disabled: true,
			handler: function() { deleteFiles('<?php echo str_replace("&amp;", "&", get_url('files', 'delete_files')) ?>') }
		}),
		more: new Ext.Action({
			text: 'More',
            tooltip: 'More actions on first selected file',
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

    var grid = new Ext.grid.GridPanel({
        el: 'file-manager',
        height: 430,
        store: store,
		layout: 'fit',
        cm: cm,
        sm: new Ext.grid.RowSelectionModel({selectRow:Ext.emptyFn}),
        loadMask: true,
        bbar: new Ext.PagingToolbar({
            pageSize: pageSize,
            store: store,
            displayInfo: true,
            displayMsg: 'Displaying files {0} - {1} of {2}',
            emptyMsg: "No files to display"
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

	grid.render();

    store.load({params:{start:0, limit: pageSize}});

};

Ext.onReady(initFileManager);

function gotoUrl(url) {
	location.href = url;
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

function deleteFiles(baseurl) {
	if (confirm('<?php echo lang('confirm delete file')?>')) {
		url = baseurl + "&files=" + getSelectedFiles() ;
		gotoUrl(url);
	}
}

function tagFiles(tag, baseurl) {	
	url = baseurl + "&tag=" + tag + "&files=" + getSelectedFiles() ;
	gotoUrl(url);
}

function properties(baseurl) {
	url = baseurl + "&id=" + getFirstSelectedFile();
	gotoUrl(url);
}

function runSlideshow (baseurl) {
	url = baseurl + "&fileId=" + getFirstSelectedFile();
	slideshow(url);
}

function revisions(baseurl) {
	url = baseurl + "&id=" + getFirstSelectedFile();
	gotoUrl(url);
}

function download(baseurl) {
	url = baseurl + "&id=" + getFirstSelectedFile();
	gotoUrl(url);
}

function addTag(baseurl) {
	Ext.Msg.prompt('Add Tag', 'Enter the desired tag for the file:',
		function(btn, text) {
			if (btn == 'ok') {
				tagFiles(text, baseurl);
			}
		}
	);
}
</script>
