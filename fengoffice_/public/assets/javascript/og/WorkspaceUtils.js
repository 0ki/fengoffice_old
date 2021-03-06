

//----------------------------------------
// Workspace PATH
//----------------------------------------

og.getWorkspaceColor = function(id){
	var tree = Ext.getCmp('workspaces-tree');
	var node = tree.tree.getNodeById('ws' + id);
	if (node)
		return node.ws.color;
}

og.getFullWorkspacePath = function(id, includeCurrent){
	var tree = Ext.getCmp('workspaces-tree');
	var node = tree.tree.getNodeById('ws' + id);
	var result = '';
	
	if (node != null && node.ws.id != 0){
		var activews = tree.tree.getActiveWorkspace();
		if (node.ws.id != activews.id){
			var originalNode = node;
			node = node.parentNode;
			while (node != null && node.ws.id != 0 && node.ws.id != activews.id){
				result = node.ws.name + "/" + result;
				node = node.parentNode;
			}
			result += originalNode.ws.name;
		}
		if (includeCurrent){
			if (node != null && node.ws.id != 0)
				if (result == '')
					result = node.ws.name;
				else
					result = node.ws.name + "/" + result;
		}
	}
	return result;
}

og.showWsPaths = function(containerItemName, showPath, showCurrent){
	var container = containerItemName != '' ? document.getElementById(containerItemName): null;
	if (container == null)		//Container name null or container not found
		container = document;
	
	var list = container.getElementsByTagName('span');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'project-replace'){
			list[i].className = '';
			var id = list[i].innerHTML.replace(/^\s*([\S\s]*?)\s*$/, '$1');
			list[i].innerHTML = og.renderWsPath(id,showPath, showCurrent);
		}
};

og.renderWsPath = function(id,showPath, showCurrent){
	var tree = Ext.getCmp('workspaces-tree');
	var node = tree.tree.getNodeById('ws' + id);
	var html = '';
	
	if (node != null && node.ws.id != 0){
		var activews = tree.tree.getActiveWorkspace();
		if (node.ws.id != activews.id || showPath || showCurrent){
			var originalNode = node;
			node = node.parentNode;
			while (node != null && node.ws.id != 0 && (node.ws.id != activews.id || showPath || showCurrent)){
				html = '<a class="og-wsname-color-' + originalNode.ws.color + '" href="#"  onclick="Ext.getCmp(\'workspace-panel\').select(' + node.ws.id + ')" name="' + og.clean(og.clean(node.ws.name)).replace('"', '\\"') + '">' + og.trimMax(node.ws.name, 4) + "</a>/" + html;
				if (node.ws.id == activews.id && !showPath)
					break;
				node = node.parentNode;
			}
			html = '<span class="og-wscont og-wsname"><span style="padding-left:1px;padding-right:1px" class="og-wsname-color-' + originalNode.ws.color + '" onmouseover="og.wsPathMouseBehavior(this,true)" onmouseout="og.wsPathMouseBehavior(this,false)">'+ html + '<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select(' + originalNode.ws.id + ')" name="' + og.clean(og.clean(originalNode.ws.name)).replace('"', '\\"') + '" class="og-wsname-color-' + originalNode.ws.color + '">' + og.trimMax(originalNode.ws.name, 12) + "</a></span></span>";
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
	if (isMouseOver) {
		object.style.fontSize = "120%";
		object.style.padding = "4px";
		var cn = object.childNodes;
		for (var i = 0; i < cn.length; i++) {
			if (cn[i].name != null && cn[i].name != ''){
				var aux = cn[i].innerHTML;
				cn[i].innerHTML = cn[i].name;
				cn[i].name = aux;
			}
		}
	} else {
		object.style.fontSize = "100%";
		object.style.padding = "0px";
		object.style.paddingLeft = '1px';
		object.style.paddingRight = '1px';
		
		var cn = object.childNodes;
		for (var i = 0; i < cn.length; i++) {
			if (cn[i].name != null && cn[i].name != ''){
				var aux = cn[i].innerHTML;
				cn[i].innerHTML = cn[i].name;
				cn[i].name = aux;
			}
		}
	}
};

og.trimMax = function(str, size, append){
	if (append == null)
		append = '&hellip;';
	var result = str.replace(/^\s*/, "").replace(/\s*$/, ""); //Trims the input string
	if (result.length > size + 1){
		result = og.clean(result.substring(0,size).replace(/^\s*/, "").replace(/\s*$/, "")) + append;
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
		if (cn.id != 'trash')
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
		if (!actNode)
			break;
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
		html = '<div class="wsTagCrumbsElement" onmouseover="document.getElementById(\'wsTagCloseDiv\').style.display=\'block\'" onmouseout="document.getElementById(\'wsTagCloseDiv\').style.display=\'none\'">' + newTag.name + '<div id="wsTagCloseDiv" class="wsTagCloseDiv" title="' + lang('close this tag') + '" onclick="Ext.getCmp(\'tag-panel\').select(0)"></div></div>';
	}
	
	var crumbsdiv = Ext.get('wsTagCrumbs');
	crumbsdiv.dom.innerHTML = html;
};





//----------------------------------------
// Workspace SELECTOR
//----------------------------------------


og.drawWorkspaceSelector = function(renderTo, workspaceId, name, allowNone){
	var container = document.getElementById(renderTo);
	if (container){
		var tree = Ext.getCmp('workspaces-tree');
		var ws;
		if (workspaceId || workspaceId == 0)
			ws = tree.tree.getNodeById('ws' + workspaceId).ws;
		else
			ws = tree.tree.getActiveOrPersonalWorkspace();
	
		var html = "<input type='hidden' id='" + renderTo + "Value' name='" + name + "' value='" + ws.id + "'/>";
		html +="<div class='x-form-field-wrap'><table><tr><td><div id='" + renderTo + "Header' class='og-ws-selector-header'>";
		var path = og.getFullWorkspacePath(ws.id,true);
		if (path == '')
			path = lang('none');
		html += "<div class='coViewAction ico-color" + ws.color + " og-ws-selector-input' onclick='og.ShowWorkspaceSelector(\"" + renderTo + "\"," + ws.id + ", " + (allowNone? 'true':'false') + ")' title='" + path + "'>" + path + "</div>";
		html +="</div></td><td><img class='x-form-trigger x-form-arrow-trigger og-ws-selector-arrow' onclick='og.ShowWorkspaceSelector(\"" + renderTo + "\"," + ws.id + ", " + (allowNone? 'true':'false') + ")' src='s.gif'/></td></tr></table><div id='" + renderTo + "Panel'></div></div>";
		
		container.innerHTML = html;
	}
}

og.ShowWorkspaceSelector = function(controlName, workspaceId, allowNone){
	if (document.getElementById(controlName + 'Panel').style.display == 'block')
		document.getElementById(controlName + 'Panel').style.display = 'none';
	else {
		if (document.getElementById(controlName + 'Panel').innerHTML == ''){
			var tree = Ext.getCmp('workspace-panel');
			var wsList = tree.getWsList();
			var newTree = new og.WorkspaceTree({
				id: controlName + 'Tree',
				renderTo: controlName + 'Panel',
				root:[],
				workspaces: wsList,
				isInternalSelector: true,
				width:200,
				height:250,
				selectedWorkspaceId: workspaceId,
				controlName: controlName,
				allowNone: allowNone,
				style: 'border:1px solid #99BBE8'
			});
		}
		document.getElementById(controlName + 'Panel').style.display = 'block';
	}
	//document.getElementById(controlName + 'Header').style.display = 'none';
}

og.WorkspaceSelected = function(controlName, workspace){
	var path =og.getFullWorkspacePath(workspace.id,true);
	if (path == '')
		path = lang('none');
	document.getElementById(controlName + 'Header').innerHTML = "<div class='coViewAction ico-color" + workspace.color + " og-ws-selector-input' onclick='og.ShowWorkspaceSelector(\"" + controlName + "\"," + workspace.id + ")'>" + og.clean(path) + "</div>";
	document.getElementById(controlName + 'Panel').style.display = 'none';
	document.getElementById(controlName + 'Header').style.display = 'block';
	document.getElementById(controlName + 'Value').value = workspace.id;	
}

