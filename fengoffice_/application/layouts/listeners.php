<script>

og.eventManager.addListener('reload member restrictions', 
 	function (genid){ 
		App.modules.addMemberForm.drawDimensionRestrictions(genid, document.getElementById(genid + 'dimension_id').value);
 	}
);

og.eventManager.addListener('reload member properties', 
 	function (genid){
 		App.modules.addMemberForm.drawDimensionProperties(genid, document.getElementById(genid + 'dimension_id').value);
 	}
);

og.eventManager.addListener('reload dimension tree', 
 	function (dim_id){
 		if (!og.reloadingDimensions){ 
 			og.reloadingDimensions = {} ;
 		}
 		if (!og.reloadingDimensions[dim_id]){
	 		og.reloadingDimensions[dim_id] = true ;
	 		
	 		var tree = Ext.getCmp("dimension-panel-" + dim_id);
	 		if (tree) {
	 			var selection = tree.getSelectionModel().getSelectedNode();
	 			
		 		tree.suspendEvents();
		 		var expanded = [];
		 		tree.root.cascade(function(){
	 				if (this.isExpanded()) expanded.push(this.id);
	 			});
		 		tree.loader.load(tree.getRootNode(), function() {
			 		tree.expanded_once = false;
		 			og.expandCollapseDimensionTree(tree, expanded, selection ? selection.id : null);
			 		og.reloadingDimensions[dim_id] = false ;
			 	});
		 		tree.resumeEvents();
	 		}
 		}
 		
 	}
);

og.eventManager.addListener('reset dimension tree', 
 	function (dim_id){
 		if (!og.reloadingDimensions){ 
 			og.reloadingDimensions = {} ;
 		}
 		if (!og.reloadingDimensions[dim_id]){
	 		og.reloadingDimensions[dim_id] = true ;
	 		var tree = Ext.getCmp("dimension-panel-" + dim_id);
	 		if (tree) {
		 		tree.suspendEvents();
 				tree.loader = tree.initialLoader;
		 		tree.loader.load(tree.getRootNode(),function(){
			 		tree.resumeEvents(); 
			 		og.Breadcrumbs.refresh(tree.getRootNode());
			 	});
		 		tree.expandAll();
	 		}
 		}
 	}
);

og.eventManager.addListener('select dimension member', 
	function (data){
		og.selectDimensionTreeMember(data);
	}
);

og.eventManager.addListener('company added', 
 	function (company) {
 		var elems = document.getElementsByName("contact[company_id]");
 		for (var i=0; i < elems.length; i++) {
 			if (elems[i].tagName == 'SELECT') {
	 			var opt = document.createElement('option');
	        	opt.value = company.id;
		        opt.innerHTML = company.name;
	 			elems[i].appendChild(opt);
 			}
 		}
 	}
);

og.eventManager.addListener('contact added from mail', 
	function (obj) {
		var hf_contacts = document.getElementById(obj.hf_contacts);
		if (hf_contacts) hf_contacts.value += (hf_contacts != '' ? "," : "") + obj.combo_val;
		var div = Ext.get(obj.div_id);
 		if (div) div.remove();
 	}
);

og.eventManager.addListener('draft mail autosaved', 
	function (obj) {
		var hf_id = document.getElementById(obj.hf_id);
		if (hf_id) hf_id.value = obj.id;
 	}
);

og.eventManager.addListener('popup',
	function (args) {
		og.msg(args.title, args.message, 0, args.type, args.sound);
	}
);

og.eventManager.addListener('user preference changed',
	function(option) {
		// experimental (not developed): dynamically change localization
		if (option.name == 'localization') {
			og.loadScripts([og.getUrl('access', 'get_javascript_translation')], {
				callback: function() {
					var spans = document.getElementsByName('og-lang');
					for (var i=0; i < spans.length; i++) {
						var key = spans[i].id.substring(8);
						spans[i].innerHTML = lang(key);
					}
				}
			});
		}
	}
);

og.eventManager.addListener('download document',
	function(args) {
		if(args.reloadDocs){
			//og.openLink(og.getUrl('files', 'list_files'));
			og.panels.documents.reload();
		}	
		location.href = og.getUrl('files', 'download_file', {id: args.id, validate:0});
	}
);

og.eventManager.addListener('config option changed',
	function(option) {
		og.config[option.name] = option.value;
	}
);

og.eventManager.addListener('user preference changed',
	function(option) {
		og.preferences[option.name] = option.value;
	}
);

og.eventManager.addListener('tabs changed',
	function(option) {
		window.location.href = '<?php echo ROOT_URL?>' ;
	}
);
og.eventManager.addListener('logo changed',
	function(option) {
		window.location.href = '<?php echo ROOT_URL?>' ;
	}
);
</script>