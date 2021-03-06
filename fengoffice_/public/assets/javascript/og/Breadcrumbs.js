og.Breadcrumbs = {
	
	cmp: null,
		
	status: 0 ,	
	
	items: 0, 
	
	mainDimension: null ,	
	
	collapse: function () {
		this.cmp.collapse(false);
	},
	
	expand: function () {
		this.cmp.expand(false);
	},
	
	resize: function() {
		var cmp = Ext.getCmp("breadcrumbs-panel") ;
		if (this.items == 0) {
			cmp.setHeight(0);
		
		}else if(this.items == 0) {
			cmp.setHeight(30);
		}else{
			cmp.setHeight(45);
		}
		cmp.doLayout();
		
	},
	

	refresh: function (node) {
		// Clean Previews state
		$("#breadcrumbs ul").html("");
		this.items = 0 ;
		
		// Update
		for (i in og.contextManager.dimensionMembers) {
			var member = og.contextManager.dimensionMembers[i];
			var dimId = i ;
			if (member.length ) {
				member = member[0];
				if ( dimId == this.mainDimension ) {
					var mainTitle = lang("All") ;
					var mainPath = "" ;
					if (member > 0) {
						this.items ++ ;
						mainTitle = og.contextManager.getMemberName(dimId, member);
						mainPath = og.contextManager.getMemberPath(dimId, member);
						this.expand();
					}
					if(mainTitle) {
						$("#breadcrumbs h1").html("<em>"+mainTitle+"</em>"+mainPath);
					}
				}else{
					if (member > 0 ) {
						//alert(member);
						memberTitle = og.contextManager.getMemberName(dimId, member);
						dimensionTitle = og.contextManager.getDimensionName(dimId);
						
						if (memberTitle) {
							this.items++;
							var itemClass = "" ;
							if ($('#breadcrumbs ul').children().size() == 0 ){
								itemClass = "first";
							}
							$("#breadcrumbs ul").append("<li class='"+itemClass+"'><strong>"+dimensionTitle+"</strong>: "+memberTitle+"</li>");
							this.expand();
						}
					}
				}
			}
		}
		if (this.items == 0) {
			this.collapse();
		}
		
		// Show div if was hidden 
		/*
		if ($("#breadcrumbs").is(":hidden")) $("#breadcrumbs").slideDown('slow', function(){
			
			// Resize Ext Components - Ext do no fire automatically this ! ! 
			//var bcHeight =$("#breadcrumbs").height() + 53   ; // 10 px padding ?
			var bcHeight = 100 ;
			var tp = Ext.getCmp("tabs-panel") ;
			var tpSize = tp.getSize();
			tpSize.height = tpSize.height - bcHeight ;
			tp.setSize(tpSize);
		});
		*/
		
		
		//
	}

}