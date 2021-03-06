Ext.override(Ext.tree.TreeNode,{
	   /**
     * Expand this node.
     * @param {Boolean} deep (optional) True to expand all children as well
     * @param {Boolean} anim (optional) false to cancel the default animation
     * @param {Function} callback (optional) A callback to be called when
     * expanding this node completes (does not wait for deep expand to complete).
     * Called with 1 parameter, this node.
     */
    expand : function(deep, anim, callback){
    	
        if(!this.expanded){
            if(this.fireEvent("beforeexpand", this, deep, anim) === false){
                return;
            }
            if(!this.childrenRendered){
                this.renderChildren();
            }
            this.expanded = true;
            if(!this.isHiddenRoot() && (this.getOwnerTree().animate && anim !== false) || anim){
                this.ui.animExpand(function(){
                    this.fireEvent("expand", this);
                    if(typeof callback == "function"){
                        callback(this);
                    }
                    if(deep === true){
                        this.expandChildNodes(true, callback);
                    }
                }.createDelegate(this));
                return;
            }else{
                this.ui.expand();
                this.fireEvent("expand", this);
                if(typeof callback == "function"){
                    callback(this);
                }
            }
        }else{
           if(typeof callback == "function"){
               callback(this);
           }
        }
        if(deep === true){
            this.expandChildNodes(true, callback);
        }
    },

    expandedNodes : function () {
    	var expanded = [] ;
    	if (this.isExpanded()) {
    		if (this.getDepth()){
    			expanded.push(this.id) ;
    		}else{
    			// Root node
    			expanded.push(0) ;
    		}
    	}
    	if ( !this.leaf ) { 
	    	this.eachChild(function(n){
	    		expanded = expanded.concat(n.expandedNodes());
	    	});
    	}
    	return expanded ;
    	
    },

    /**
     * Expand all child nodes
     * @param {Boolean} deep (optional) true if the child nodes should also expand their child nodes
     */
    expandChildNodes : function(deep, callback){
        var cs = this.childNodes;
        for(var i = 0, len = cs.length; i < len; i++) {
        	//alert(cs[i].text) ;
        	cs[i].expand(deep, false, callback);
        }
    }
    

});
