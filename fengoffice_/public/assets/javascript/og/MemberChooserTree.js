og.MemberChooserTree = function(config) {
	
	if (!config.allowedMemberTypes) 
		config.allowedMemberTypes = '';
	
	Ext.applyIf(config, {
		
		isMultiple: false,
		
		collapsible: true,
		
		collapsed: !config.required,
		
		titleCollapse: true,  
		
		allowedMemberTypes: '', //Array of dimension member types to be rendered as checkbox
		
		reloadDimensions: [],
		
		loader: new og.MemberChooserTreeLoader({
			dataUrl: 'index.php?c=dimension&a=initial_list_dimension_members_tree&ajax=true&'+
				'dimension_id='+config.dimensionId+
				'&object_type_id='+config.objectTypeId+
				'&checkboxes=true'+
				(config.all_members ? '&all_members=true' : '')+
				'&allowedMemberTypes='+Ext.encode(config.allowedMemberTypes)+
				'&avoid_session=1',
			ownerTree: this 
		}),

		checkBoxes: true,
		
		autoScroll: true,
		
		animCollapse: false,
		
		animExpand: false,
		
		animate: false,
		
		rootVisible: true,
		
		lines: false,
		
		root: {
        	text: lang('All'),
        	expanded: false
    	},
    	
		collapseFirst: false,
		
		cls: 'member-chooser'
		
		
	});
	
	
	
	og.MemberChooserTree.superclass.constructor.call(this, config);

	if ( Ext.isIE7 ) {
		
		this.width= 230;
		
		this.height= 280 ;
			
	}
		
	this.filterOnChange = true ;
	
	this.totalFilterTrees = 0 ;
	
	this.filteredTrees = 0 ;
	
	var self = this ; // To change scope inside callbacks	

	
	// ********** TREE EVENTS *********** //
	
	this.on ({
		'checkchange' : function (node, checked) {
			// Avoid multiple check
			if (!this.isMultiple) {
				if (checked) {
					var oldChecked = this.getChecked() ;
					for (var i = 0 ; i < oldChecked.length ; i++) {
						if ( oldChecked[i] && oldChecked[i].id != node.id ) {
							this.suspendEvents();
							oldChecked[i].checked = false ; 
							oldChecked[i].getUI().toggleCheck(false) ;						
							this.resumeEvents();
						}
					}
				}
			}
			
			// Filter other trees 
			if ( this.filterOnChange ) {
				var trees = this.ownerCt.items;
				if (trees){
					this.suspendEvents();
					this.totalFilterTrees = 0 ;
					this.filteredTrees = 0 ;
					trees.each(function (item, index, length){

						if ( self.id != item.id && self.reloadDimensions.indexOf(item.dimensionId) != -1  ) {
							self.totalFilterTrees++;
							
							var nid = (checked) ? node.id : 0 ;
							if (checked) {
								var nid = node.id ; 
							}else{
								if (!this.isMultiple){
									var nid = 0 ;
								}else {
									var nid = self.getLastChecked() ;
								}
							}
							
							item.filterByMember(nid ,function(){
								self.filteredTrees ++ ;
								if (self.filteredTrees == self.totalFilterTrees) {
									self.resumeEvents() ;
									self.fireEvent('all trees updated');
								}
							}) ;
							
						}
					});
					if (this.totalFilterTrees == 0 ) {
						this.resumeEvents();
						self.fireEvent('all trees updated');
					}
				}
			}
			
			
		},
		'scope':this
	});
};


Ext.extend(og.MemberChooserTree, Ext.tree.TreePanel, {
	
	suspendEvents: function() {
		og.MemberChooserTree.superclass.suspendEvents.call(this);
		var htmlInputs = Ext.query("#"+this.getId() + " input" ) ;
		for (var i in htmlInputs ) {
			if ( i != "remove" ) {
				htmlInputs[i].disabled = "disabled";	
			}
		}
	},

	resumeEvents: function() {
		og.MemberChooserTree.superclass.resumeEvents.call(this);
		var htmlInputs = Ext.query("#"+this.getId() + " input" ) ;
		for (var i = 0 ; i <htmlInputs.length; i++ ) {
			if ( htmlInputs[i] ) {
				htmlInputs[i].disabled = "";

			}
		}
		
	},

	
	filterByMember: function(memberId,callback) {
		var checked = this.getChecked("id");
		//this.collapseAll() ;
		this.loader =  new og.MemberChooserTreeLoader({	
			dataUrl:	
				'index.php?c=dimension&a=list_dimension_members_tree&ajax=true&checkboxes=true'
				+'&dimension_id='+this.dimensionId
				+'&member_id='+memberId
				+'&object_type_id='+this.objectTypeId 
				+'&avoid_session=1',
			ownerTree: this 			 
		}) ;
		var self = this;// Scope for callback
		this.loader.load(this.getRootNode(), function() {
			self.expandAll(function(){
				self.checkNodes(checked);
		        if( typeof callback == "function"){
		        	callback();
		        }
			});			
		});
	},
	
	checkNodes: function (nids) {
		if (!nids) return ;
		for (var i = 0 ; i < nids.length ; i++ ) {
			if ( nids[i] != "undefined" ) {
				if ( nids[i] != 0 ) {
					var node = this.getNodeById(nids[i]) ;
				}else{
					var node = this.getRootNode();
				}
				if (node) {
					this.suspendEvents();
					node.checked= true;
					node.getUI().toggleCheck(true);
					this.resumeEvents();
				}
			} 
		}
	},
	
	/**
	 * Select nodes given as array of int
	 */
	selectNodes: function (nids) {
		if (nids.length){
			for (var i = 0 ; i < nids.length ; i++ ){
				this.getSelectionModel().select(this.getNodeById(nids[i]));
				if (!this.multipleSelect) {
					return true;
				}
			}
		}
		return true;
	},
	
    afterRender : function(){
		var tree = this ;
    	var collapsed = this.collapsed ;
    	this.collapsed = false ;
        og.MemberChooserTree.superclass.afterRender.call(this);
        if(collapsed){
        	if(this.checkBoxes){
        		tree.expandAll(function(){tree.collapse(false);tree.checkNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
        	}else{
        		tree.expandAll(function(){tree.collapse(false);tree.selectNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
        	}
    	}else{
    		if (this.checkBoxes){
    			tree.expandAll(function(){tree.checkNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
    		}else{
    			tree.expandAll(function(){tree.selectNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
    		}
    	}   
        
        
    },	 
	
	getLastChecked : function() {
		var checkedNodes = this.getChecked("id");
		if (checkedNodes.length  && checkedNodes[0] ) {
			return checkedNodes[0];
		}else{
			return 0 ; // Return 'All' (root node)
		}
		
	}
    
});

Ext.reg('member-chooser-tree', og.MemberChooserTree);