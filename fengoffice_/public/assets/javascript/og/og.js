var og = {};
var vtindex = 0;
var vtlist = new Array();

og.globalVars = new Array();

// default config (to be overridden by server)
og.pageSize = 10;
og.hostname = '';
og.maxFileSize = 1024 * 1024;

// functions
og.msg =  function(title, format) {
	var box = ['<div class="msg">',
			'<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
			'<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><h3>{0}</h3>{1}</div></div></div>',
			'<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
			'</div>'].join('');
	if( !this.msgCt){
	    this.msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
	}
	this.msgCt.alignTo(document, 't-t');
	var s = String.format.apply(String, Array.prototype.slice.call(arguments, 1));
	var m = Ext.DomHelper.append(this.msgCt, {html:String.format(box, title, s)}, true);
	Ext.get(m).on('click', function() {
		Ext.getDom(this).style.display = 'none';
	}, m);
	m.slideIn('t').pause(4).ghost("t", {remove:true});
}

og.hideAndShow = function(itemToHide, itemToDisplay){
	Ext.get(itemToHide).setDisplayed('none');
	Ext.get(itemToDisplay).setDisplayed('block');
}

og.hideAndShowByClass = function(itemToHide, classToDisplay, containerItemName){
	Ext.get(itemToHide).setDisplayed('none');
	
	var list;
	var container;
	if (containerItemName != ''){
		container = document.getElementById(containerItemName);
	} else container = document;
	
	list = container.getElementsByTagName('tr');
	
	for(var i = 0; i < list.length; i++){
		var obj = list[i];
		if (obj.className != '' && obj.className.indexOf(classToDisplay) >= 0)
			obj.style.display = '';
	}
}

og.switchToOverview = function(){
	var opanel = Ext.getCmp('overview-panel');
	opanel.defaultContent = {type: 'overview'};
	opanel.load(opanel.defaultContent);
}

og.switchToDashboard = function(){
	var opanel = Ext.getCmp('overview-panel');
	opanel.defaultContent = {type: "url", data: og.getUrl('dashboard','index')};
	opanel.load(opanel.defaultContent);
}

og.loading = function() {
	if (!this.loadingCt) {
		this.loadingCt = document.createElement('div');
		this.loadingCt.innerHTML = lang('loading');
		this.loadingCt.className = 'loading-indicator';
		this.loadingCt.style.position = 'absolute';
		this.loadingCt.style.left = '45%';
		this.loadingCt.style.cursor = 'pointer';
		this.loadingCt.onclick = function() {
			this.style.visibility = 'hidden';
			this.instances = 0;
		};
		this.loadingCt.instances = 0;
		document.body.appendChild(this.loadingCt);
	}
	this.loadingCt.instances++;
	this.loadingCt.style.visibility = 'visible';
}

og.hideLoading = function() {
	this.loadingCt.instances--;
	if (this.loadingCt.instances <= 0) {
		this.loadingCt.style.visibility = 'hidden';
	}
}

og.toggle = function(id, btn) {
	var obj = Ext.get(id);
	if (obj.isDisplayed()) {
		obj.slideOut("t", {duration: 0.5, useDisplay: true});
		if (btn) Ext.fly(btn).replaceClass('toggle_expanded', 'toggle_collapsed');
	} else {
		obj.slideIn("t", {duration: 0.5, useDisplay: true});
		if (btn) Ext.fly(btn).replaceClass('toggle_collapsed', 'toggle_expanded');
	}
}

og.toggleAndBolden = function(id, btn) {
	var obj = Ext.get(id);
	if (obj.isDisplayed()) {
		obj.slideOut("t", {duration: 0.5, useDisplay: true});
		if (btn) 
			btn.style.fontWeight = 'normal';
	} else {
		obj.slideIn("t", {duration: 0.5, useDisplay: true});
		if (btn) 
			btn.style.fontWeight = 'bold';
	}
}

og.toggleAndHide = function(id, btn) {
	var obj = Ext.getDom(id);
	if (obj.style.display == 'block') {
		obj.style.display = 'none';
		if (btn) 
			btn.style.display = 'none';
	} else {
		obj.style.display = 'block';
		if (btn) 
			btn.style.display = 'none';
	}
}


og.getUrl = function(controller, action, args) {
	var url = og.hostname;
	url += "?c=" + controller;
	url += "&a=" + action;
	for (var key in args) {
		url += "&" + key + "=" + args[key];
	}
	return url;
}

og.filesizeFormat = function(fs) {
	if (fs > 1024 * 1024) {
		var total = Math.round(fs / 1024 / 1024 * 10);
		return total / 10 + "." + total % 10 + " MB";
	} else {
		var total = Math.round(fs / 1024 * 10);
		return total / 10 + "." + total % 10 + " KB";
	}
}

og.autoComplete = {
	keypress: function(e) {
		if (e.keyCode == 13) {
			if (this.autoCompleter) {
				var val = this.value;
				var l = val.lastIndexOf(",");
				if (l > 0) {
					val = val.substring(0, l + 1) + " ";
				} else {
					val = "";
				}
				this.value = val + this.autoCompleter.matches[this.autoCompleter.selected].text;
				this.parentNode.removeChild(this.autoCompleter.element);
				this.autoCompleter = null;
			}
			return false;
		}
		return true;
	},
	keyup: function(e, data) {
		var ret = false;
		var borr = false;
		if (e.keyCode == 27) {
			borr = true;
			ret = true;
		} else if (e.keyCode == 38 || e.keyCode == 40) {
			if (this.autoCompleter) {
				this.autoCompleter.matches[this.autoCompleter.selected].element.className = '';
				this.autoCompleter.selected = (this.autoCompleter.selected + e.keyCode - 39 + this.autoCompleter.matches.length) % this.autoCompleter.matches.length;
				this.autoCompleter.matches[this.autoCompleter.selected].element.className = 'selected';
			}
			ret = true;
		}
		if (this.previousValue == this.value) {
			ret = true;
		} else {
			borr = true;
		}
		if (borr && this.autoCompleter) {
			this.parentNode.removeChild(this.autoCompleter.element);
			this.autoCompleter = null;
		}
		if (ret) {
			return;
		}
		this.previousValue = this.value;
		var val = this.value;
		var l = val.lastIndexOf(",");
		if (l > 0) {
			val = val.substring(l + 1);
		}
		val = val.replace(/^\s+/, "");
		var matches = new Array();
		//if (val) { // this check determines whether a letter has to be typed to show the autoCompleter
			var regexp = eval("/^" + val + ".*/i");
			for (var i=0; i < data.length; i++) {
				if (regexp.test(data[i])) {
					matches[matches.length] = {
						text: data[i]
					};
				}
			}
			if (matches.length <= 0) {
				return;
			}
	
			var div = document.createElement('div');
			for (var i=0; i < matches.length; i++) {
				var elem = document.createElement('div');
				elem.innerHTML = matches[i].text;
				matches[i].element = elem;
				div.appendChild(elem);
			}
			div.className = 'autoCompleter';
			//div.style.position = 'absolute';
			div.style.left = this.offsetLeft + 'px';
			div.style.top = this.offsetTop + this.offsetHeight + 'px';
			this.parentNode.appendChild(div);
			this.autoCompleter = {
				element: div,
				selected: 0,
				matches: matches
			};
			matches[0].element.className = 'selected';
		//}
	},
	blur: function() {
		if (this.autoCompleter) {
			this.parentNode.removeChild(this.autoCompleter.element);
			this.autoCompleter = null;
		}
	}
}

og.makeAjaxUrl = function(url, params) {
	var q = url.indexOf('?');
	var n = url.indexOf('#');
	if (Ext.getCmp('workspace-panel')) {
		var ap = "active_project=" + Ext.getCmp('workspace-panel').getActiveWorkspace().id;
	} else {
		var ap = "active_project=0";
	}	
	if (Ext.getCmp('tag-panel')) {
		var at = "active_tag=" + Ext.getCmp('tag-panel').getSelectedTag().name;
	} else {
		var at = "";
	}
	var p = "";
	if (params) {
		if (typeof params == 'string') {
			p = "&" + params;
		} else {
			for (var k in params) {
				p += "&" + k + "=" + params[k];
			}
		}
	}
	if (q < 0) {
		if (n < 0) {
			return url + "?ajax=true&" + ap + "&" + at + p;
		} else {
			return url.substring(0, n) + "?ajax=true&" + ap + "&" + at + "&" + url.substring(n) + p;
		}
	} else {
		return url.substring(0, q + 1) + "ajax=true&" + ap + "&" + at + "&" + url.substring(q + 1) + p;
	}
}

og.createHTMLElement = function(config) {
	var tag = config.tag || 'p';
	var attrs = config.attrs || {};
	var content = config.content || {};
	var elem = document.createElement(tag);
	for (var k in attrs) {
		elem[k] = attrs[k];
	}
	if (typeof content == 'string') {
		elem.innerHTML = content;
	} else {
		for (var i=0; i < content.length; i++) {
			elem.appendChild(og.createHTMLElement(content[i]));
		}
	}
	return elem;
}

og.debug = function(obj, level) {
	if (!level) level = 0;
	if (level > 5) return "";
	var pad = "";
	var str = "";
	for (var i=0; i < level; i++) {
		pad += "  ";
	}
	if (!obj) {
		str = "NULL";
	} else if (typeof obj == 'object') {
		str = "";
		for (var k in obj) {
			str += ",\n" + pad + "  ";
			str += k + ": ";
			str += og.debug(obj[k], level + 1);
		}
		str = "{" + str.substring(1) + "\n" + pad + "}";
	} else if (typeof obj == 'string') {
		str = '"' + obj + '"';
	} else {
		str = obj;
	}
	return str;
}

og.captureLinks = function(id, caller) {
	var links = Ext.select((id?"#" + id + " ":"") + "a.internalLink");
	links.each(function() {
		if (this.dom.href.indexOf('javascript:') == 0) {
			return;
		}
		if (this.dom.target) {
			this.dom.href = "javascript:og.openLink('" + this.dom.href + "', {caller:'" + this.dom.target + "'})";
			this.dom.target = "";
		} else if (caller) {
			this.dom.href = "javascript:og.openLink('" + this.dom.href + "', {caller:'" + caller.id + "'})";
		} else {
			this.dom.href = "javascript:og.openLink('" + this.dom.href + "')";
		}
	});
	links = Ext.select((id?"#" + id + " ":"") + "form.internalForm");
	links.each(function() {
		var onsubmit = this.dom.onsubmit;
		this.dom.onsubmit = function() {
			if (onsubmit && !onsubmit()) {
				return false;
			} else {
				var params = Ext.Ajax.serializeForm(this);
				var options = {};
				options[this.method.toLowerCase()] = params;
				og.openLink(this.getAttribute('action'), options);
			}
			return false;
		}
	});
}

og.getViewTab = function(){
	vtindex++;
	if (vtlist.length >= 3){
		var toRemove = vtlist.shift();
		Ext.getCmp('tabs-panel').remove(toRemove);
	}
	vtlist.push('vtab' + vtindex);
		
	return 'vtab' + vtindex;
}

og.openLink = function(url, options) {
	if (!options) options = {};
	if (typeof options.caller == "object") {
		options.caller = options.caller.id;
	}
	if (options.caller == 'viewTab'){
		options.caller = og.getViewTab();
	}
	if (!options.caller) {
		var tabs = Ext.getCmp('tabs-panel');
		if (tabs) {
			var active = tabs.getActiveTab();
			if (active) options.caller = active.id;
		}
	}
	og.loading();
	var params = options.get || {};
	if (typeof params == 'string') {
		params += "&current=" + options.caller;
	} else {
		params.current = options.caller;
	}
	url = og.makeAjaxUrl(url, params);
	Ext.Ajax.request({
		url: url,
		method: 'POST',
		params: options.post,
		callback: function(options, success, response) {
			og.hideLoading();
			if (success) {
				try {
					var data = Ext.util.JSON.decode(response.responseText);
					og.processResponse(data, options);
				} catch (e) {
					// response isn't valid JSON, display it on the caller panel or new tab
					var p = Ext.getCmp(options.caller);
					if (p) {
						p.load(response.responseText);
					} else {
						og.newTab(response.responseText);
					}
				}
				if (options.postProcess) options.postProcess.call(this, true, data || response.responseText);
			} else {
				og.msg(lang("error"), lang("server could not be reached"));
				if (options.postProcess) options.postProcess.call(this, false);
			}
		},
		caller: options.caller,
		postProcess: options.callback || options.postProcess,
		scope: options.scope,
		preventPanelLoad: options.preventPanelLoad
	});
}

/**
 *  This function allows to submit a form containing a file upload without
 *  refreshing the whole page by using an iframe. It expects a JSON response
 *  but with mime type 'text/html' so that IE can render it on the iframe.
 *  Also, it may not contain html as IE will render it and thus break the JSON.
 *  The response should return only error messages, events or possibly a forward URL.
 *  A typical response could be like this (without the line breaks):
 *  	{
 *  		"errorCode": 0,
 *  		"errorMessage": "Evrything OK",
 *  		"current": {
 *  			"type": "url",
 *  			"data": "http://some.url.to/forward/to
 *  		}
 *  	}
 *  Unlike the function og.openLink, this function doesn't send a ajax=true
 *  parameter.
 */
og.submit = function(form, callback) {
	og.loading();
	// create an iframe
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
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	function endSubmit() {
		og.hideLoading();
		
		if (typeof callback == 'function') {
			callback(currentPanel);
		} else if (typeof callback == 'string') {
			og.openLink(callback);
		}
		setTimeout(function(){Ext.removeNode(frame);}, 100);
	}
	Ext.EventManager.on(frame, 'load', endSubmit, frame);;
	
	form.target = frame.name;
	var url = og.makeAjaxUrl(form.getAttribute('action')).replace(/ajax\=true/g, "upload=true");
	form.setAttribute('action', url);
	form.submit();
	return false;
}

og.processResponse = function(data, options) {
	if (options)
		var caller = options.caller;
	if (!data) return;
	if (data.events) {
		for (var i=0; i < data.events.length; i++) {
			og.eventManager.fireEvent(data.events[i].name, data.events[i].data);
		}
	}
	/*for (var k in data.libs) {
		og.loadScript("");
	}*/
	if (data.contents) {
		for (var i=0; i < data.contents.length; i++) {
			var p = Ext.getCmp(data.contents[i].panel);
			if (p) {
				p.load(data.contents[i]);
			}
		}
	}
	if (data.current && !options.preventPanelLoad) {
		if (data.current.panel) {
			var p = Ext.getCmp(data.current.panel);
			if (p) {
				var tp = p.ownerCt;
				if (tp.setActiveTab) {
					tp.setActiveTab(p);
				}
				p.load(data.current);
			} else {
				og.newTab(data.current, data.current.panel);
			}
		} else if (caller) {
			var p = Ext.getCmp(caller);
			if (p) {
				var tp = p.ownerCt;
				if (tp.setActiveTab) {
					tp.setActiveTab(p);
				}
				p.load(data.current);
				p = Ext.getCmp('tabs-panel');
			} else {
				og.newTab(data.current, caller, data);
			}
		} else {
			og.newTab(data.current);
		}
	}
	if (data.errorCode != 0) {
		og.msg(lang("error"), data.errorMessage);
	} else if (data.errorMessage) {
		og.msg(lang("success"), data.errorMessage);
	}
}

og.newTab = function(content, id, data) {
	var title = id?lang(id):lang('new tab');
	if (data && data.title)
		title = data.title;
	var tp = Ext.getCmp('tabs-panel');
	var t = new og.ContentPanel({
		closable: true,
		title: title.length < 15?title:title.substring(0,12) + '...',
		tabTip: title,
		id: id || Ext.id(),
		iconCls: ((data && data.icon)?data.icon:(id?'ico-' + id:'ico-tab')),
		defaultContent: content
	});
	tp.add(t);
	tp.setActiveTab(t);
}

og.eventManager = {
	events: new Array(),
	addListener: function(event, callback, scope, options) {
		if (!this.events[event]) {
			this.events[event] = new Array();
		}
		this.events[event].push({
			callback: callback,
			scope: scope,
			options: options || {}
		});
	},
	removeListener: function(event, callback, scope) {
		var list = this.events[event];
		if (!list) {
			return;
		}
		for (var i=0; i < list.length; i++) {
			if (list[i].callback == callback && list[i].scope == scope) {
				list.remove(list[i]);
				return;
			}
		}
	},
	fireEvent: function(event, arguments) {
		var list = this.events[event];
		if (!list) {
			return;
		}
		for (var i=0; i < list.length; i++) {
			try {
				list[i].callback.call(list[i].scope, arguments);
			} catch (e) {
				og.msg(lang("error"), e.message);
			}
			if (list[i].options.single) {
				list.remove(list[i]);
			}
		}
	}
}

og.showHelp = function() {
	Ext.getCmp('help-panel').toggleCollapse();
}

og.extractScripts = function(html) {
	var id = Ext.id();
	html += '<span id="' + id + '"></span>';
	Ext.lib.Event.onAvailable(id, function() {
		try {
		var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
		var match;
		while (match = re.exec(html)) {
			if (match[2] && match[2].length > 0) {
				try {
					if (window.execScript) {
						window.execScript(match[2]);
					} else {
						window.eval(match[2]);
					}
				} catch (e) {
					og.msg(lang("error"), e.message);
				}
			}
		}
		var el = document.getElementById(id);
		if (el) { Ext.removeNode(el); }
		} catch (e) { alert(e);}
	});
	
	return html.replace(/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/ig, "");
}

og.clone = function(o) {
	if('object' !== typeof o) {
		return o;
	}
	var c = 'function' === typeof o.pop ? [] : {};
	var p, v;
	for(p in o) {
		v = o[p];
		if('object' === typeof v) {
			c[p] = og.clone(v);
		}
		else {
			c[p] = v;
		}
	}
	return c;
}

og.closeView = function(obj){
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	currentPanel.back();
}

og.slideshow = function(id) {
	var url = og.getUrl('files', 'slideshow', {fileId: id});
	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;
	window.open(url, 'slideshow', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')
}

og.expandSubWsCrumbs = function(wsid){
	var tree = Ext.getCmp('workspaces-tree');
	var node = tree.tree.getNode(wsid);
	
	if (!node || node.childNodes.length == 0){
		tree.tree.loadWorkspaces(node, true);
	} else {
		og.showSubWsTooltip(node);
	}
}

og.showSubWsTooltip = function(node){
	var html = "";
	for (var i = 0; i < node.childNodes.length; i++){
		var cn = node.childNodes[i];
		html += "<div class=\"subwscrumbs\"><a href=\"#\" onclick=\"Ext.getCmp('workspace-panel').select(" + cn.ws.id + ");og.clearSubWsCrumbs()\">" + cn.ws.name + "</a></div>";
	}
		
	var expander = document.getElementById('subWsExpander');
	expander.innerHTML = html;
	var wsCrumbs = document.getElementById('wsCrumbsDiv');
	expander.style.left = (wsCrumbs.offsetWidth + 70) + "px";
	expander.style.display = 'block';
	
	clearTimeout(og.globalVars['swst']);
	var obj = Ext.get('subWsExpander');
	obj.slideIn("l", {duration: 0.5, useDisplay: true});
	og.setSubWsTooltipTimeout(3000);
}

og.setSubWsTooltipTimeout = function(value){
	og.globalVars['swst'] = setTimeout("og.HideSubWsTooltip()", value);
}

og.HideSubWsTooltip = function(){
	var obj = Ext.get('subWsExpander');
	obj.slideOut("l", {duration: 0.5, useDisplay: true});
}

og.clearSubWsCrumbs = function(){
	var expander = document.getElementById('subWsExpander');
   	expander.innerHTML = '';
   	expander.style.display = 'none';
	clearTimeout(og.globalVars['swst']);
}

og.updateWsCrumbs = function(newWs) {
	var html = '';
	var first = true;
	var tree = Ext.getCmp('workspaces-tree');
	while (newWs.id != 0){
		if (first){
			first = false;
			html = '<div id="curWsDiv" style="font-size:150%;display:inline;"><a href="#" style="display:inline;line-height:28px" onmouseover="og.expandSubWsCrumbs(' + newWs.id + ')">' + newWs.name + '</a></div>' + html;
		} else
			html = '<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select(' + newWs.id + ')">' + newWs.name + '</a>' + html;
		
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
}














og.removeLinkedObjectRow = function (r, tblId, confirm_msg){
	if (confirm(confirm_msg)){
		var i=r.parentNode.parentNode.rowIndex;		
		var tbl = document.getElementById(tblId);
		tbl.deleteRow(i);
		tbl.deleteRow(i-1);
	}
}

og.addLinkedObjectRow = function (tblId,obj_type,obj_id,obj_name, obj_manager, confirm_msg, unlink_msg){
	var tbl = document.getElementById(tblId);
	var cantRows = tbl.rows.length / 2;
	var row1=tbl.insertRow(tbl.rows.length);
	row1.className = 'linkedObject';
	row1.className += (cantRows% 2 == 0) ? 'even' : 'odd';
	
	var td1 = row1.insertCell(0);
	td1.rowSpan = 2;
	td1.style.paddingLeft = 1;
	td1.style.verticalAlign = 'middle';
	td1.style.width = '25px'
	td1.innerHTML = "<input type='hidden' value='"+obj_id+"' name='rel_objects[id_"+ cantRows +"]' />";
	td1.innerHTML += "<input type='hidden' value='"+obj_manager+"' name='rel_objects[type_"+ cantRows +"]' />";
	td1.innerHTML += "<div class='db-ico unknown ico-"+obj_type+ "' title='"+obj_type+"'></div>";
	
	var td2 = row1.insertCell(1);
	
	td2.innerHTML = "<b><span>"+obj_name+"</span></b>";
	
	var row2=tbl.insertRow(tbl.rows.length);
	row2.className = row1.className;
	var td2 = row2.insertCell(0);
	td2.innerHTML = '<a class="internalLink" href="#" onclick="og.removeLinkedObjectRow(this,\''+tblId+'\',\''+confirm_msg+'\')" title="' +unlink_msg+ ' object">' +unlink_msg+ '</a>';
}
