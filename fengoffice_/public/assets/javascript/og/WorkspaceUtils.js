

//----------------------------------------
// Workspace PATH
//----------------------------------------

og.showWsPaths = function(containerItemName){
	var container = containerItemName != '' ? document.getElementById(containerItemName): null;
	if (container == null)		//Container name null or container not found
		container = document;
	
	list = container.getElementsByTagName('span');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'project-replace'){
			list[i].className = '';
			list[i].innerHTML = og.renderWsPath(list[i].innerHTML);
		}
};

og.renderWsPath = function(id){
	var tree = Ext.getCmp('workspaces-tree');
	var node = tree.tree.getNodeById('ws' + id);
	var html = '';
	
	if (node != null && node.ws.id != 0){
		var activews = tree.tree.getActiveWorkspace();
		if (node.ws.id != activews.id){
			var originalNode = node;
			node = node.parentNode;
			while (node != null && node.ws.id != 0 && node.ws.id != activews.id){
				html = '<a class="og-wsname-color-' + originalNode.ws.color + '" href="#"  onclick="Ext.getCmp(\'workspace-panel\').select(' + node.ws.id + ')" name="' + node.ws.name + '">' + og.trimMax(node.ws.name, 4) + "</a>/" + html;
				node = node.parentNode;
			}
			
			html = '<span class="og-wscont og-wsname"><span class="og-wsname-color-' + originalNode.ws.color + '" onmouseover="og.wsPathMouseBehavior(this,true)">'+ html + '<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select(' + originalNode.ws.id + ')" name="' + originalNode.ws.name + '" class="og-wsname-color-' + originalNode.ws.color + '">' + og.trimMax(originalNode.ws.name, 12) + "</a></span></span>";
		}
	}
	return html;
};

og.swapNames = function(object){
	var s = object.innerHTML;
	object.innerHTML = object.name;
	object.name = s;
};

og.wsPathMouseBehavior = function(object, isMouseOver){
	object.style.fontSize = isMouseOver? "120%" : "100%";
	object.style.padding = isMouseOver? "4px" : "0px";
	object.style.paddingLeft = '1px';
	object.style.paddingRight = '1px';
	
	var cn = object.childNodes;
	for (var i = 0; i < cn.length; i++)
		if (cn[i].name != null && cn[i].name != ''){
				cn[i].innerHTML = cn[i].name;
				cn[i].name = '';
			}
};

og.trimMax = function(str, size, append){
	if (append == null)
		append = '&hellip;';
	var result = str.replace(/^\s*/, "").replace(/\s*$/, ""); //Trims the input string
	if (result.length > size + 1){
		result = result.substring(0,size).replace(/^\s*/, "").replace(/\s*$/, "") + append;
	}
	return result;
};




//----------------------------------------
// Workspace CRUMBS
//----------------------------------------
		
		

og.expandSubWsCrumbs = function(wsid){
	var tree = Ext.getCmp('workspaces-tree');
	var node = tree.tree.getNode(wsid);
	
	if (node && node.childNodes.length > 0){
		og.showSubWsMenu(node);
	}
};

og.showSubWsMenu = function(node){
	var html = "";
	for (var i = 0; i < node.childNodes.length; i++){
		var cn = node.childNodes[i];
		html += "<div class=\"subwscrumbs\"><a class=\"ico-color" + cn.ws.color + "\" style=\"padding-bottom:2px;padding-top:1px;padding-left:18px;background-repeat:no-repeat!important\" href=\"#\" onclick=\"Ext.getCmp('workspace-panel').select(" + cn.ws.id + ");og.clearSubWsCrumbs()\">" + cn.ws.name + "</a></div>";
	}
		
	var expander = document.getElementById('subWsExpander');
	expander.innerHTML = html;
	var wsCrumbs = document.getElementById('wsCrumbsDiv');
	expander.style.left = (wsCrumbs.offsetWidth + 70) + "px";
	expander.style.display = 'block';
	
	clearTimeout(og.eventTimeouts['swst']);
	expander = Ext.get('subWsExpander');
	expander.slideIn("l", {duration: 0.5, useDisplay: true});
	og.eventTimeouts['swst'] = setTimeout("og.HideSubWsTooltip()", 3000);
};

og.setSubWsTooltipTimeout = function(value){
	og.eventTimeouts['swst'] = setTimeout("og.HideSubWsTooltip()", value);
};

og.HideSubWsTooltip = function(){
	var expander = Ext.get('subWsExpander');
	expander.slideOut("l", {duration: 0.5, useDisplay: true});
};

og.clearSubWsCrumbs = function(){
	var expander = document.getElementById('subWsExpander');
   	expander.innerHTML = '';
   	expander.style.display = 'none';
	clearTimeout(og.eventTimeouts['swst']);
};

og.updateWsCrumbs = function(newWs) {
	var html = '';
	var first = true;
	var tree = Ext.getCmp('workspaces-tree');
	while (newWs.id != 0){
		var actNode = tree.tree.getNodeById('ws' + newWs.id);
		if (first){
			first = false;
			html = '<div id="curWsDiv" style="font-size:150%;display:inline;"><a href="#" style="display:inline;line-height:28px" onmouseover="og.expandSubWsCrumbs(' + actNode.ws.id + ')">' + actNode.text + '</a></div>' + html;
		} else
			html = '<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select(' + actNode.ws.id + ')">' + actNode.text + '</a>' + html;
		
		html = ' / ' + html;
		var node = tree.tree.getNode(newWs.parent)
		if (node)
			newWs = node.ws;
		else
			break;
	}
	
	if (first){
		html = '<div id="curWsDiv" style="font-size:150%;display:inline;"><a href="#" style="display:inline;line-height:28px" onmouseover="og.expandSubWsCrumbs(' + newWs.id + ')">' + newWs.name + '</a></div>' + html;
	} else html = '<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select(0)">' + lang('all') + '</a>' + html;
	var crumbsdiv = Ext.get('wsCrumbsDiv');
	crumbsdiv.dom.innerHTML = html;
};

og.updateWsCrumbsTag = function(newTag) {
	var html = '';
	if (newTag.name != "") {
		//html = '<div class="wsTagCrumbsElement" onmouseover="document.getElementById(\'wsTagCloseDiv\').style.display=\'block\'" onmouseout="document.getElementById(\'wsTagCloseDiv\').style.display=\'none\'"><table><tr><td>' + newTag.name + '</td><td style="padding-left:3px"><a href="#" onclick="return false" title="' + lang('close this tag') + '"><div id="wsTagCloseDiv" class="wsTagCloseDiv" onclick="Ext.getCmp(\'tag-panel\').select(0)"></div></a></td></tr></table></div>';
		html = '<div class="wsTagCrumbsElement" onmouseover="document.getElementById(\'wsTagCloseDiv\').style.display=\'block\'" onmouseout="document.getElementById(\'wsTagCloseDiv\').style.display=\'none\'">' + newTag.name + '<div id="wsTagCloseDiv" class="wsTagCloseDiv" title="' + lang('close this tag') + '" onclick="Ext.getCmp(\'tag-panel\').select(0)"></div></div>';
	}
	
	var crumbsdiv = Ext.get('wsTagCrumbs');
	crumbsdiv.dom.innerHTML = html;
};