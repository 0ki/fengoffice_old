
og.core_dimensions = {
	init: function() {
		for (x in og.dimension_object_types) {
			if (og.dimension_object_types[x] == 'contact') {
				if (!og.before_object_view) og.before_object_view = [];
				og.before_object_view[x] = 'og.core_dimensions.onContactClick(<parameters>);';
			}
		}
	},
	
	onContactClick: function(member_id) {
		var dimensions_panel = Ext.getCmp('menu-panel');
		dimensions_panel.items.each(function(item, index, length) {
			if (item.dimensionCode == 'feng_persons') {
				og.expandCollapseDimensionTree(item);
				
				var n = item.getNodeById(member_id);
				
				if (n) {
					if (n.parentNode) item.expandPath(n.parentNode.getPath(), false);
					n.select();
				}
				
				setTimeout(function() {og.Breadcrumbs.refresh(n)},200) ;
			}
		});
	},
	
	buildBeforeObjectViewAction: function(obj_id) {
		var dimensions_panel = Ext.getCmp('menu-panel');
		dimensions_panel.items.each(function(item, index, length) {
			if (item.dimensionCode == 'feng_persons') {
				og.expandCollapseDimensionTree(item);
				
				var member_id = -1;
				item.root.cascade(function(){
					if (this.object_id == obj_id) member_id = this.id;
	 			});
				if (member_id > 0) {
					og.core_dimensions.onContactClick(member_id);
				}
			}
		});
		return "";
	}
};