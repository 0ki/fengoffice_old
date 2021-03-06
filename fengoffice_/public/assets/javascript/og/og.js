var og = {};
var ogTasks = {};
var ogTaskEvents = {};
ogTasksTask = {};
ogTasksMilestone = {};
ogTasksCompany = {};
ogTasksUser = {};
var vtindex = 0;
var vtlist = [];

var searchingMemberOnTheServer = [];
	
og.eventTimeouts = [];
og.otherData = [];

// default config (to be overridden by server)
og.hostName = '';
og.maxFileSize = 1024 * 1024;

og.showMailsTab = 0;

// functions
og.msg =  function(title, text, timeout, classname, sound) {
	if (typeof timeout == 'undefined') timeout = 4;
	if (!classname) classname = "msg";

	var click_to_remove_msg = ''; // only show this message if message doesn't vanish by itself
	if (timeout == 0)
		click_to_remove_msg = '<div class="x-clear"></div><div class="click-to-remove">'+ lang('close') + ' X</div><div class="x-clear"></div>';
	

	var box = ['<div class="' + classname + '" title="' + lang('click to remove') + '">',
			'<div class="og-box-tl"><div class="og-box-tr"><div class="og-box-tc"></div></div></div>',
			'<div class="og-box-ml"><div class="og-box-mr"><div class="og-box-mc"><h3>{0}:</h3><p>{1}</p>',
			click_to_remove_msg, 
			'</div></div></div>',
			'<input type="hidden" value="' + new Date().getTime() + '" />',
			'<div class="og-box-bl"><div class="og-box-br"><div class="og-box-bc"></div></div></div>',
			'</div>'].join('');
	
	if( !this.msgCt){
	    this.msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
	}
	//	this.msgCt.alignTo(document, 't-t');
	var m = Ext.DomHelper.append(this.msgCt, {html:String.format(box, title, text.replace(/([^>])\n/g, '$1<br/>\n'))}, true);
	Ext.get(m).on('click', function() {
		if (timeout > 0) {
			this.setStyle('display', 'none');
		} else {
			this.remove();
		}
	});
	m.timeout = 'aaaaa';
	if (timeout > 0) {
		m.slideIn('t').pause(timeout).ghost("t", {remove:true});
	} else {
		m.slideIn('t');
	}
	if (sound) {
		og.systemSound.loadSound('public/assets/sounds/' + sound + '.mp3', true);
		og.systemSound.start(0);
	}
};

og.updateClock = function(clockId){
	var clock = og.eventTimeouts[clockId + "clock"];
	if(clock) {
		clearTimeout(clock);
	}

	var startTime = og.otherData[clockId + "starttime"];
	var startSeconds = og.otherData[clockId + "startseconds"];
	
	

	var ts = document.getElementById(clockId + "timespan");
	if (ts){
		ts.innerHTML = og.calculateTimeForClock(startTime,startSeconds);

		og.eventTimeouts[clockId + "clock"] = setTimeout("og.updateClock('" + clockId + "')", 1002);
	} else {
		og.eventTimeouts[clockId + "clock"] = 0;
	}
};

og.calculateTimeForClock = function(startTime, startSeconds){
	var nowTime = new Date();
	var elapsed = ((nowTime.getElapsed(startTime) / 1000) + startSeconds).toFixed(0);
	var seconds = (elapsed % 60) / 1;
	var totalMinutes = (elapsed - seconds) / 60;
	var minutes = totalMinutes % 60;
	var totalHours = (totalMinutes - minutes) / 60;  
	minutes = ( minutes < 10 ? "0" : "" ) + minutes;
  	seconds = ( seconds < 10 ? "0" : "" ) + seconds.toFixed(0);
  	
  	return totalHours + ":" + minutes + ":" + seconds;
}

og.startClock = function(clockId, startSeconds){
	og.otherData[clockId + "starttime"] = new Date();
	og.otherData[clockId + "startseconds"] = startSeconds;
	og.updateClock(clockId);
};

og.err = function(text) {
	var errors = Ext.query("div.err");
	var maxErrors = 2;
	for (var i=0; i < errors.length - maxErrors + 1; i++) {
		Ext.fly(errors[i]).remove();
	}
	og.msg(lang("information"), text, 0, "err");
};

og.clearErrors = function(timeout) {
	var errors = Ext.query("div.err");
	for (var i=0; i < errors.length; i++) {
		if (timeout) {
			var inputs = Ext.fly(errors[i]).query('input');
			var ts = inputs[0].value;
			if (new Date().getTime() - ts > timeout*1000) {
				// clear error only if timeout seconds have ellapsed
				Ext.fly(errors[i]).remove();
			}
		} else {
			Ext.fly(errors[i]).remove();
		}
	}
};

og.hideAndShow = function(itemToHide, itemToDisplay){
	Ext.get(itemToHide).setDisplayed('none');
	Ext.get(itemToDisplay).setDisplayed('block');
};

og.hideAndShowByClass = function(itemToHide, classToDisplay, containerItemName, count){
	Ext.get(itemToHide).setDisplayed('none');
	
	var list;
	var container;
	if (containerItemName != ''){
		container = document.getElementById(containerItemName);
	} else container = document;
	
	list = container.getElementsByTagName("*");
	
	for(var i = 0; i < list.length; i++){
		var obj = list[i];
		if (obj.className != '' && obj.className.indexOf(classToDisplay) >= 0) {
			obj.style.display = '';
			if (count) {
				count--;
				if (count == 0) break;
			}
		}
	}
};


og.selectReportingMenuItem = function(link, divName, tab){
	var table = document.getElementById('reportingMenu');
	
	var list = table.getElementsByTagName('td');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'report_selected_menu')
			list[i].className = 'report_unselected_menu';
		
	link.parentNode.className = 'report_selected_menu';
	link.blur();
	
	list = table.getElementsByTagName('div');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'inner_report_menu_div')
			list[i].style.display = 'none';
			
	document.getElementById(divName).style.display='block';
	
	var url = og.getUrl('account', 'update_user_preference', {name: 'custom_report_tab', value: tab});
	og.openLink(url,{hideLoading:true});
}

og.dateselectchange = function(select, cls_selector) {
	if (!cls_selector) cls_selector = 'dateTr';
	var list = select.offsetParent.offsetParent.getElementsByTagName('tr');
	for(var i = 0; i < list.length; i++) {
		if (list[i].className == cls_selector) {
			list[i].style.display = select.value == '6'? 'table-row':'none';
		}
	}
}

og.timeslotTypeSelectChange = function(select, genid) {
	document.getElementById(genid + 'gbspan').style.display = select.value > 0? 'none':'inline';
	document.getElementById(genid + 'altgbspan').style.display = select.value > 0? 'inline':'none';
	
	document.getElementById(genid + 'task_ts_desc').style.display = select.value == 0 ? '' : 'none';
	document.getElementById(genid + 'general_ts_desc').style.display = select.value == 1 ? '' : 'none';
}

og.switchToOverview = function(){
	og.openLink(og.getUrl('account', 'update_user_preference', {name:'overviewAsList', value:1}), {hideLoading:true});
	var opanel = Ext.getCmp('overview-panel');
	opanel.defaultContent = {type: 'url', data: og.getUrl('dashboard', 'init_overview')};
	opanel.load(opanel.defaultContent);
};

og.switchToDashboard = function(){
	og.openLink(og.getUrl('account', 'update_user_preference', {name:'overviewAsList', value:0}), {hideLoading:true});
	var opanel = Ext.getCmp('overview-panel');
	opanel.defaultContent = {type: "url", data: og.getUrl('dashboard','main_dashboard')};
	opanel.load(opanel.defaultContent);
};

og.customDashboard = function (controller,action,params, reload) {
	if (!params) params = {};
	if (!controller) return false; 
	if (!action) action = 'init'  ;
	var opanel = Ext.getCmp('overview-panel');
	if (opanel){
		var new_data = og.getUrl(controller,action, params) ;
		var content = {type: "url", data: new_data};
		opanel.defaultContent = content ;
		if (reload) {
			opanel.load(content);
		}
	}
}

og.resetDashboard = function () {
	var opanel = Ext.getCmp('overview-panel');
	if (opanel && opanel.defaultContent.data != "overview"){
		opanel.defaultContent = {type: "url", data: og.getUrl('dashboard','init_overview')};
		opanel.load(opanel.defaultContent);
	}
}

og.loading = function() {
	if (!this.loadingCt) {
		this.loadingCt = document.createElement('div');
		this.loadingCt.innerHTML = lang('loading');
		this.loadingCt.className = 'loading-indicator og-loading';
		this.loadingCt.onclick = function() {
			this.style.visibility = 'hidden';
			this.instances = 0;
		};
		this.loadingCt.instances = 0;
		document.body.appendChild(this.loadingCt);
	}
	this.loadingCt.instances++;
	this.loadingCt.style.visibility = 'visible';
};

og.hideLoading = function() {
	this.loadingCt.instances--;
	if (this.loadingCt.instances <= 0) {
		this.loadingCt.style.visibility = 'hidden';
	}
};

//get loading icon to put it wherever you want
og.getIndependentLoading = function() {
	loadingCt = document.createElement('div');
	loadingCt.innerHTML = lang('loading');
	loadingCt.className = 'loading-indicator';
	return loadingCt;
};

og.otherMsgCt = null;
og.showOtherMessage = function(msg, left_percent) {
	if (!og.otherMsgCt) {
		og.otherMsgCt = document.createElement('div');
		og.otherMsgCt.innerHTML = msg;
		og.otherMsgCt.className = 'loading-indicator';
		og.otherMsgCt.style.position = 'absolute';
		og.otherMsgCt.style.left = (left_percent != null ? left_percent : '15%');
		og.otherMsgCt.style.zIndex = 1000000;
		og.otherMsgCt.style.cursor = 'pointer';
		og.otherMsgCt.onclick = function() {
			this.style.visibility = 'hidden';
			this.instances = 0;
		};
		og.otherMsgCt.instances = 0;
		document.body.appendChild(og.otherMsgCt);
	}
	og.otherMsgCt.instances++;
	og.otherMsgCt.style.visibility = 'visible';
};

og.hideOtherMessage = function() {
	og.otherMsgCt.instances--;
	if (og.otherMsgCt.instances <= 0) {
		og.otherMsgCt.style.visibility = 'hidden';
	}
};

og.toggle = function(id, btn) {
	var obj = Ext.fly(id);
	if (obj.isDisplayed()) {
		obj.slideOut("t", {duration: 0.5, useDisplay: true});
		if (btn) Ext.fly(btn).replaceClass('toggle_expanded', 'toggle_collapsed');
	} else {
		obj.slideIn("t", {duration: 0.5, useDisplay: true});
		if (btn) Ext.fly(btn).replaceClass('toggle_collapsed', 'toggle_expanded');
	}
};

og.toggleAndBolden = function(id, btn) {
	var obj = Ext.get(id);
	if (obj.isDisplayed()) {
		obj.dom.style.display = 'none';
		if (btn) {
			btn.style.fontWeight = 'normal';
		}
	} else {
		obj.dom.style.display = 'block';
		$("#"+id).closest('form').parent().animate({
		   scrollTop: $("#"+id).offset().top - 250
		});
		if (btn) { 
			btn.style.fontWeight = 'bold';
		}
	}
};

og.toggleSimpleTab = function(id, contentContainer, tabContainer, tab) {
	var tc = Ext.getDom(tabContainer);
	var child = tc.firstChild;
	while (child) {
		if (child.style) {
			child.style.fontWeight = 'normal';
		}
		child = child.nextSibling;
	}
	if (tab) {
		tab.style.fontWeight = 'bold';
		tab.blur();
	}

	var cc = Ext.getDom(contentContainer);
	var child = cc.firstChild;
	while (child) {
		if (child.style) {
			child.style.display = 'none';
		}
		child = child.nextSibling;
	}
	var obj = Ext.get(id);
	obj.dom.style.display = 'block';
};

og.showAndHide = function(idToShow, idsToHide, displayType){
	if (!displayType)
		displayType = 'block';
	var show = document.getElementById(idToShow);
	if(show){
		show.style.display = displayType;
		for(var i = 0; i < idsToHide.length; i++){
			var hide = document.getElementById(idsToHide[i]);
			if (hide) hide.style.display = 'none';
		}
	}
};

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
};


og.getUrl = function(controller, action, args) {

	var url = og.getHostName() + "/index.php";
	url += "?c=" + controller;
	url += "&a=" + action;
	for (var key in args) {
		url += "&" + encodeURIComponent(key) + "=" + encodeURIComponent(args[key]);
	}
	return url;
};

og.getSandboxUrl = function(controller, action, args) {
	var url = og.getSandboxName() + "/index.php";
	url += "?c=" + controller;
	url += "&a=" + action;
	for (var key in args) {
		url += "&" + encodeURIComponent(key) + "=" + encodeURIComponent(args[key]);
	}
	return url;
};

og.filesizeFormat = function(fs) {
	if (fs > 1024 * 1024) {
		var total = Math.round(fs / 1024 / 1024 * 10);
		return total / 10 + "." + total % 10 + " MB";
	} else {
		var total = Math.round(fs / 1024 * 10);
		return total / 10 + "." + total % 10 + " KB";
	}
};


og.makeAjaxUrl = function(url, params) {
	//og.msg("","Make ajax url"+url , 15);
	//alert(params.toSource()) ;
	var q = url.indexOf('?');
	var n = url.indexOf('#');
	var ap = "";
	if ( url.indexOf("context") < 0 && (params && !params.context) ) {
		var ap = "context=" + og.contextManager.plainContext();
		if ( url.indexOf("currentdimension") < 0 && !params.currentdimension)  {
			ap += "&currentdimension=" + og.contextManager.currentDimension;
		}	
	}
	
	if (url.indexOf("ajax=true") < 0) {
		var aj = "&ajax=true";
	} else {
		var aj = "";
	}
	var p = "";
	if (params) {
		if (typeof params == 'string') {
			if (params != ''){
				p = "&" + params;
			}
		} else {
			for (var k in params) {
				p += "&" + encodeURIComponent(k) + "=" + encodeURIComponent(params[k]);
			}
		}
	}
	
	if (q < 0) {
		if (n < 0) {
			return url + "?" + ap + aj +  p;
		} else {
			return url.substring(0, n) + "?" + ap + aj + (url.substring(n) != ''? "&":"") + url.substring(n) + p;
		}
	} else {
		return url.substring(0, q + 1) + ap + aj + (url.substring(q + 1) != ''? "&":"") + url.substring(q + 1) + p;
	}
};

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
};

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
};

og.captureLinks = function(id, caller) {
	var element = document.getElementById(id);
	if (!element) element = document;
	var links = element.getElementsByTagName("a");
	for (var i=0; i < links.length; i++) {
		var link = links[i];
		if (!link.href || Ext.isGecko && link.href == link.baseURI || link.href.indexOf('mailto:') == 0 || link.href.indexOf('javascript:') == 0 || link.href.indexOf('#') >= 0) continue;
		if (link.target && link.target[0] == '_') continue;
		if (caller && !link.target) {
			link.target = caller.id;
		}
		link.onvalidate = link.onclick;
		link.onclick = function(e) {
			if (typeof this.onvalidate != 'function') {
				var p = true;
			} else {
				var p = this.onvalidate(e);

			}
			if (p || typeof p == 'undefined' ) {
				if (!this.href || this.href.indexOf("c=access&a=index") != -1) {
					return false ;
				} 
				og.openLink(this.href, {caller: this.target}) ;
			}
			return false;
		}
	};
	forms = element.getElementsByTagName("form");
	for (var i=0; i < forms.length; i++) {
		
		var form = forms[i];
		if (form.target && form.target[0] == '_') continue;
		if (caller && !form.target) {
			form.target = caller.id;
		}
		var onsubmit = form.onsubmit;
		form.onsubmit = function() {
			if (onsubmit && !onsubmit()) {
				return false;
			} else {
				og.ajaxSubmit(this, {caller: this.target});
			}
			return false;
		}
	};
};

og.log = function(msg) {
	if (!og._log) og._log = "";
	og._log += msg + "\n";
};

og.openLink = function(url, options) {
	//if (url.indexOf("c=dashborad&a=activity_feed") != -1) return ;
	
	if (!options) options = {};
	if (typeof options.caller == "object") {
		options.caller = options.caller.id;
	}
	if (!options.caller) {
		var tabs = Ext.getCmp('tabs-panel');
		if (tabs) {
			var active = tabs.getActiveTab();
			if (active) options.caller = active.id;
		}
	}
    
	if (!options.hideLoading && !options.silent) {
		og.loading();
	}
	if (!options.hideLoading && !options.hideErrors && !options.silent) {
		og.clearErrors(5);
	}
	var params = options.get || {};
	if (typeof params == 'string' && params.indexOf('current=') < 0) {
		params += "&current=" + options.caller;
	} else {
		if (options.caller && ! params.current)
			params.current = options.caller;
	}
	if (url.substring(url.length - 5) != '.html') {
		// don't add params to HTML pages (this prevents 405 errors from apache 1.3)
		url = og.makeAjaxUrl(url, params);
	}
	if (typeof options.timeout != "undefined") {
		var oldTimeout = Ext.Ajax.timeout;
		Ext.Ajax.timeout = options.timeout;
	}
	var startTime = new Date().getTime();
	Ext.Ajax.request({
		url: url,
		params: options.post,
		callback: function(options, success, response) {
			og.eventManager.fireEvent('ajax response', options);
			if (!options.options.hideLoading && !options.silent) {
				og.hideLoading();
			}
            
           og.eventManager.fireEvent('openLink callback', response);
            
			if (success) {
				UnTip(); //fixes ws tooltip is displayed some times when changing page
				if (og)
					clearTimeout(og.triggerFPTTO);
				try {
					try {
						var data = Ext.util.JSON.decode(response.responseText);
					} catch (e) {
						// response isn't valid JSON, display it on the caller panel or new tab
						if (!options.preventPanelLoad && !options.options.silent) {
							var p = Ext.getCmp(options.caller);
							if (p) {
								var tp = p.ownerCt;
								p.load(response.responseText);
								if (tp && tp.setActiveTab && options.options.show) {
									tp.setActiveTab(p);
								}
							} else {
								og.newTab(response.responseText);
							}
						}
					}
					var dont_process_response = typeof(data) != 'undefined' && data.dont_process_response;
					if (!dont_process_response) {
						og.processResponse(data, options);
					}
				} catch (e) {
					og.err(e.message);
				}
				var ok = typeof data == 'object' && data.errorCode == 0;
				if (typeof options.postProcess == 'function') options.postProcess.call(options.scope || this, ok, data || response.responseText, options.options);
				if (ok) {
					if (typeof options.onSuccess == 'function') options.onSuccess.call(options.scope || this, data || response.responseText, options.options);
				} else {
					if (typeof options.onError == 'function') options.onError.call(options.scope || this, data || response.responseText, options.options);
				}
			} else {
				if (!options.options.hideErrors && !options.options.silent && response.status > 0) {
					og.err(lang("http error", response.status, response.statusText));
					og.httpErrLog = og.clean(response.responseText);
				}
				if (typeof options.postProcess == 'function') options.postProcess.call(options.scope || this, false, data || response.responseText, options.options);
				if (typeof options.onError == 'function') options.onError.call(options.scope || this, data || response.responseText, options.options);
			}
			var endTime = new Date().getTime();
			//og.log(url + ": " + (endTime - startTime) + " ms");
		},
		caller: options.caller,
		postProcess: options.callback || options.postProcess,
		onSuccess: options.onSuccess,
		onError: options.onError,
		scope: options.scope,
		preventPanelLoad: options.preventPanelLoad,
		options: options
	});
	if (typeof oldTimeout != "undefined") {
		Ext.Ajax.timeout = oldTimeout;
	}
};

/**
 *  This function allows to submit a form containing a file upload without
 *  refreshing the whole page by using an iframe. The request will behave
 *  as an ajax request (openLink function). You can specify in
 *  the options parameter a forcedCallback property of type function that
 *  will be invoked after the upload.
 */
og.submit = function(form, options) {
	if (!options) options = {};
	// create an iframe
	var id = Ext.id();
	var frame = document.createElement('iframe');
	frame.id = id;
	frame.name = id;
	frame.className = 'x-hidden';
	document.body.appendChild(frame);
	if (Ext.isIE) frame.src = Ext.SSL_SECURE_URL;

	if(Ext.isIE){
	   document.frames[id].name = id;
	}
	options.panel = options.panel || Ext.getCmp('tabs-panel').getActiveTab().id;
	
	var origUrl = form.getAttribute('action');
	var origTarget = form.getAttribute('target');
	
	Ext.EventManager.on(frame, 'load', function() {
			if (frame.submitted) {
				form.setAttribute('action', origUrl);
				form.setAttribute('target', origTarget);
				
				if (typeof options.forcedCallback == 'function') {
					options.forcedCallback();
				}
				
				og.hideLoading();
				setTimeout(function(){Ext.removeNode(frame);}, 100);
			}
		}, frame
	);
	
	og.submit[id] = options;
	form.setAttribute('target', frame.name);
	var url = og.makeAjaxUrl(origUrl) + "&upload=true&current=" + options.panel + "&request_id=" + id;
	form.setAttribute('action', url);
	og.loading();
	frame.submitted = 1;
	form.submit();
	return false;
};

/**
 * Submits a form through an open link by serializing it.
 * Doesn't work with file uploads. Use og.submit for that purpose.
 */
og.ajaxSubmit = function(form, options) {
	if (!options) options = {};
	var params = Ext.Ajax.serializeForm(form);
	options[form.getAttribute('method').toLowerCase()] = params;
	og.openLink(form.getAttribute('action'), options);
	return false;
};

og.processResponse = function(data, options, url) {
	if (!data) return;
	
	// first load scripts
	og.loadScripts(data.scripts || [], {
		callback: function() {
			if (options) var caller = options.caller;
			
			if (data.errorCode == 2009 || data.u != og.loggedUser.id) {
				if (options) {
					og.LoginDialog.show(options.url, options.options);
				} else {
					og.LoginDialog.show();
				}
				return;
			}
			
			//Fire events
			if (data.events) {
				for (var i=0; i < data.events.length; i++) {
					og.eventManager.fireEvent(data.events[i].name, data.events[i].data);
				}
			}
			
			//Load data
			if (!options || !options.preventPanelLoad && (!options.options || !options.options.silent)){
				//Load data into more than one panel
				if (data.contents) {
					for (var k in data.contents) {
						var p = Ext.getCmp(k);
						if (p) {
							p.load(data.contents[k]);
						}
					}
				}
				
				//Loads data into a single panel
				if (data.current) {
					data.current.inlineScripts = data.inlineScripts;
					if (data.current.panel || caller) { //Loads data into a specific panel
						var panelName = data.current.panel ? data.current.panel : caller; //sets data into current.panel, otherwise into caller
						var p = Ext.getCmp(panelName);
						if (p) {
							var tp = p.ownerCt;
							p.load(data.current);
							if (tp && tp.setActiveTab && Ext.getCmp(panelName) && (options.options.show || data.current.panel)) {
								tp.setActiveTab(p);
							}
							
						} else {
							og.newTab(data.current, panelName, data); //Creates the panel if it doesn't exist
						}
					} else { //Loads the data into a new tab
						og.newTab(data.current);
					}
				}
				
				//Show help in content panel if help is available
				if (data.help_content){
					Ext.getCmp('help-panel').load(data.help_content);
				}
			}
			//Show messages if any
			if (data.errorCode != 0 && (!options.options || !options.options.hideErrors && !options.options.silent)) {
				og.err(data.errorMessage);
			} else if (data.errorMessage) {
				og.msg(lang("success"), data.errorMessage);
			}
		}
	});
};

og.newTab = function(content, id, data) {
	if (!data) data = {};
	if (!data.title) {
		data.title = id?lang(id):lang('new tab');
	}
	data.tabTip = data.tabTip || data.title;
	if (data.title.length >= 15) data.title = data.title.substring(0,12) + '...';
	data.iconCls = data.iconCls || data.icon || (id ? 'ico-' + id : 'ico-tab');
	var tp = Ext.getCmp('tabs-panel');
	var t = new og.ContentPanel(Ext.apply(data, {
		closable: true,
		id: id || Ext.id(),
		defaultContent: content
	}));
	tp.add(t);
	tp.setActiveTab(t);
};

/**
 *  adds an event handler to an element, keeping the previous handlers for that event.
 *  	elem: element to which to add the event handler (e.g. document)
 *  	ev: event to handle (e.g. mousedown)
 *  	fun: function that will handle the event. Arguments: (event, handler_id)
 *  	scope: (optional) on which object to run the function
 *      returns: id of the event handler
 */
og.addDomEventHandler = function(elem, ev, fun, scope) {
	if (scope) fun = fun.createCallback(scope);
	if (!elem[ev + "Handlers"]) {
		elem[ev + "Handlers"] = {};
		if (typeof elem["on" + ev] == 'function') {
			elem[ev + "Handlers"]['original'] = elem["on" + ev];
		}
		elem["on" + ev] = function(event) {
			for (var id in this[ev + "Handlers"]) {
				this[ev + "Handlers"][id](event, id);
			}
		};
	}
	var id = Ext.id();
	elem[ev + "Handlers"][id] = fun;
};

/**
 *  Removes an event handler for the event that was added
 *  with og.addDomEventHandler.
 *  	elem: dom element
 *  	ev: event
 *  	id: id of the handler that was returned by og.addDomEventHandler.
 * 
 */
og.removeDomEventHandler = function(elem, ev, id) {
	if (!elem || !id || !ev || !elem[ev + "Handlers"]) return;
	delete elem[ev + "Handlers"][id];
};

og.eventManager = {
	events: new Array() ,//new Array(),
	eventsById: new Array(),// new Array(),
	addListener: function(event, callback, scope, options) {
		if (!options) options = {};
		if (!this.events[event] || options.replace) {
			this.events[event] = new Array();
		}
		var id = Ext.id();
		var evobj = {
			id: id,
			callback: callback,
			scope: scope,
			options: options
		};
		this.events[event].push(evobj);
		this.eventsById[id] = evobj;
		return id;
	},
	
	removeListener: function(id) {	
		var ev = this.eventsById[id];
		if (!ev) {
			return;
		}
		this.eventsById[id] = null;
		
		for ( var i in this.events ) {
			if ( (i) && this.events[i] ){
				if (this.events[i].length) {
					for ( var j in this.events[i] ) {
						if( j=="remove" ) continue ;
						//alert(j);
						event = this.events[i][j];
						if (event) {
							if (event.id && event.id == id ) {
								this.events[i][j] = null ;
								this.events[i].splice(j,1);
								if (this.events[i].length == 0) {
									this.events[i] = null;
									this.events.splice(i,1);
								}

							}
						}
					}
				}
			}
		}	
		
	},
	
	fireEvent: function(event, arguments) {
		var list = this.events[event];
		if (!list) {
			return;
		}
		for (var i=list.length-1; i >= 0; i--) {
			if (!this.eventsById[list[i].id]) {
				list.splice(i, 1);
			}
			var ret = "";
			try {
				ret = list[i].callback.call(list[i].scope, arguments, list[i].id);
			} catch (e) {
				og.err(e.message);
			}
			if (list[i] && list[i].options.single || ret == 'remove') {
				list.splice(i, 1);;
			}
		}
	}
};

og.showHelp = function() {
	Ext.getCmp('help-panel').toggleCollapse();
};

og.extractScripts = function(html) {
	var id = Ext.id();
	html += '<span id="' + id + '"></span>';
	Ext.lib.Event.onAvailable(id, function() {
		try {
			var startTime = new Date().getTime();
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
						og.err(e.message);
					}
				}
			}
			var endTime = new Date().getTime();
			//og.log("scripts: " + (endTime - startTime) + " ms");
			var el = document.getElementById(id);
			if (el) { Ext.removeNode(el); }
		} catch (e) { alert(e);}
	});
	
	return html.replace(/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/ig, "");
};

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
};

og.closeView = function(obj){
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	if (currentPanel) currentPanel.back();
	var mails_cmp = Ext.getCmp('mails-manager');
	if (mails_cmp !== undefined) {
		var sm = mails_cmp.getSelectionModel();
		sm.clearSelections();
	}
};

og.activeTabHasBack = function(){
	return Ext.getCmp('tabs-panel').getActiveTab().hasBack();
}

og.slideshow = function(id) {
	var url = og.getUrl('files', 'slideshow', {fileId: id});
	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;
	window.open(url, 'slideshow', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')
};


og.getParentContentPanel = function(dom) {
	return Ext.fly(dom).findParentNode('.og-content-panel', 100);
};

og.getParentContentPanelBody = function(dom) {
	return Ext.fly(dom).findParentNode('.x-panel-body', 100);
};




og.removeLinkedObjectRow = function (r, tblId, confirm_msg){
	if (confirm(confirm_msg)){
		var i=r.parentNode.parentNode.rowIndex;		
		var tbl = document.getElementById(tblId);
		tbl.deleteRow(i);
		tbl.deleteRow(i-1);
	}
};

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
};



/***********************************************************************/
/*********** Extending Ext.PagingToolbar  ******************************/
/***********************************************************************/

og.PagingToolbar	=	function (config) {
	og.PagingToolbar.superclass.constructor.call (this, config);
};

Ext.extend (og.PagingToolbar, Ext.PagingToolbar, {
	// override the private function 'getPageData' so that Ext.PagingToolbar 
	// will read the 'start' parameter returned from server, 
	// and set the specified page number, while presume the default behavior 
	// when the server doesn't return the 'start' parameter.
	// (JSON example).
	getPageData : function(){
		var total = this.store.getTotalCount();
 		 		
 		var	ap	=	Math.ceil((this.cursor+this.pageSize)/this.pageSize);
		if (this.store.reader.jsonData) {
			var start = parseInt(this.store.reader.jsonData.start);
			// go to the specified page
			ap	=	Math.ceil((start + this.pageSize)/this.pageSize);
			// also set the cursor so that 'prev' and 'next' buttons behave correctly
			this.cursor	= start;
		}
		
		return {
			total : total,
			activePage : ap,
			pages :  total < this.pageSize ? 1 : Math.ceil(total/this.pageSize)
		};
	}
});

og.getGooPlayerPanel = function(callback) {
	var gppanel = Ext.getCmp('gooplayer-panel');
	if (gppanel) {
		callback();
	} else {
		og.loadScripts([
				og.getScriptUrl('og/ObjectPicker.js'),
				og.getScriptUrl('og/GooPlayer.js')
			], {
			callback: function() {
				og.newTab({
						type: "panel",
						data: "gooplayer",
						config: {
							id: 'gooplayer',
							sound: og.musicSound
						}
					},
					'gooplayer-panel', {
						title: 'GooPlayer',
						icon: 'ico-gooplayer'
					}
				);
				gppanel = Ext.getCmp('gooplayer-panel');
				callback();
			}
		});
	}
	return gppanel;
};

og.playMP3 = function(track) {
	if (og.isFlashSupported()) {
		var gppanel = og.getGooPlayerPanel(function() {
			Ext.getCmp('tabs-panel').setActiveTab(gppanel);
			var gooplayer = Ext.getCmp('gooplayer');
			gooplayer.loadPlaylist([track]);
			gooplayer.start();
		});
	} else if (track[6]) {
		window.open(track[6]);
	}
};

og.queueMP3 = function(track) {
	if (og.isFlashSupported()) {
		var gppanel = og.getGooPlayerPanel(function() {
			var gooplayer = Ext.getCmp('gooplayer');
			gooplayer.queueTrack(track);
		});
	} else if (track[6]) {
		window.open(track[6]);
	}
};

og.playXSPF = function(id) {
	if (og.isFlashSupported()) {
		var gppanel = og.getGooPlayerPanel(function() {
			Ext.getCmp('tabs-panel').setActiveTab(gppanel);
			var gooplayer = Ext.getCmp('gooplayer');
			gooplayer.loadPlaylistFromFile(id, true);
		});
	} else {
		window.open(og.getUrl('files', 'download_file', {id: id}));
	}
};

 
og.xmlFetchTag = function(xml, tag) {
	var i1 = xml.indexOf("<" + tag + ">");
	var i2 = xml.indexOf("</" + tag + ">");
	if (i1 >= 0 && i2 > i1) {
		return {
			found: true,
			value: xml.substring(i1 + tag.length + 2, i2),
			rest: xml.substring(i2 + tag.length + 3)
		};
	} else {
		return {
			found: false,
			value: "",
			rest: xml
		};
	}
};

og.clean = function(text) {
	return Ext.util.Format.htmlEncode(text);
};

og.removeTags = function(text) {
	return Ext.util.Format.stripTags(text);
};

og.displayFileContents = function(genid, isFull){
	var text = document.getElementById(genid + 'file_contents').innerHTML;
	if (text.length > 1000 && !isFull){
		text = text.substring(0,900);
		text += '&hellip;&nbsp;&nbsp;<a href="#" onclick="og.displayFileContents(\'' + genid + '\',true)">[' + lang('show more') + '&hellip;]</a>';
	}
	document.getElementById(genid + 'file_display').innerHTML = text;
};

og.dashExpand = function(genid, expand_id){
	if (!expand_id) expand_id = '_widget_body';
	var widget = Ext.get(genid + expand_id);
	if (widget){
		var setExpanded = widget.dom.style.display == 'none';
		
		if (setExpanded) widget.slideIn('t', {useDisplay:true, duration:.3});
		else widget.slideOut('t', {useDisplay:true, duration:.3});
		
		var expander = document.getElementById(genid + 'expander');
		expander.className = (setExpanded) ? "dash-expander ico-dash-expanded":"dash-expander ico-dash-collapsed";
	}
};

og.closeContextHelp = function(genid,option_name){
	var help = document.getElementById(genid + 'help');
	if (help){
		help.style.display = 'none';
		if(option_name != ''){
			var url = og.getUrl('account', 'update_user_preference', {name: 'show_' + option_name + '_context_help', value:0});
			og.openLink(url,{hideLoading:true});
		}
	}
};

og.billingEditValue = function(id){
	document.getElementById(id + 'bv').style.display = 'none';
	document.getElementById(id + 'bvedit').style.display = 'inline';
	document.getElementById(id + 'edclick').value = 1;
	document.getElementById(id + 'text').focus();
};

og.checkDownload = function(url, checkedOutById, checkedOutBy, file_id) {
	var checkOut = function() {
		og.ExtendedDialog.dialog.destroy();
		if (file_id) {
			og.openLink(og.getUrl('files', 'reload_file_view', {id:file_id, checkout:1}), {
				hideLoading:true, 
				hideErrors:true,
				callback: function(){
					setTimeout(function(){location.href = url + "&checkout=0";},1000);
				}
			});
		} else {
			location.href = url + "&checkout=1";
		}
	};
	var readOnly = function() {
		og.ExtendedDialog.dialog.destroy();
		location.href = url + "&checkout=0";
	}
	var checkedOutByName = checkedOutBy;
	if (checkedOutByName == 'self') {
		checkedOutByName = lang('you');
	}
	if (checkedOutById > 0) {
		var config = {
			title :lang('checkout notification'),
			y :50,
			id :'checkDownloadDialog',
			modal :true,
			height :150,
			width :300,
			resizable :false,
			closeAction :'hide',
			iconCls :'op-ico',
			border :false,
			buttons : [ {
				text :lang('download'),
				handler :readOnly,
				id :'download_button',
				scope :this
			} ],
			dialogItems : [ {
				xtype :'label',
				name :'checked_label',
				id :'checkedout',
				hideLabel :true,
				style: 'font-size:100%;',
				text :lang('document checked out by', checkedOutByName)
			} ]
		};
	} else {
		var config = {
			title :lang('checkout confirmation'),
			y :50,
			id :'checkDownloadDialog',
			modal :true,
			height :150,
			width :300,
			resizable :false,
			closeAction :'hide',
			iconCls :'op-ico',
			border :false,
			buttons : [ {
				text :lang('checkout and download'),
				handler :checkOut,
				id :'checkOut_button',
				scope :this
			}, {
				text :lang('download only'),
				handler :readOnly,
				id :'readOnly_button',
				scope :this
			} ],
			dialogItems : [{
				xtype :'label',
				name :'checked_label',
				id :'checkedout',
				hideLabel :true,
				style: 'font-size:100%;',
				text :lang('checkout recommendation')
			}]
		};
	}
	og.ExtendedDialog.show(config);
};

og.getScriptUrl = function(script) {
	return og.getHostName() + "/public/assets/javascript/" + script;
};

og.loadScripts = function(urls, config) {
	if (!config) config = {};
	if (typeof urls == "string") urls = [urls];
	
	// first load scripts
	var scriptsLeft = urls.length;
	var scripts = [];
	for (var i=0; i < urls.length; i++) {
		if (og.loadedScripts[urls[i]]) {
			scriptsLeft--;
		} else {
			og.loadedScripts[urls[i]] = true;
			if (!config.hideLoading) og.loading();
			Ext.Ajax.request({
				url: urls[i],
				callback: function(options, success, response) {
					scriptsLeft--;
					if (!config.hideLoading) og.hideLoading();
					if (success) {
						scripts[options.index] = response.responseText;
					}
				},
				index: i
			});
		}
	}
	var success = {};
	var count = 0;
	var postScript = function() {
		// wait for scripts to load
		if (scriptsLeft > 0) {
			setTimeout(postScript, 100);
			return;
		}
		
		// run scripts
		for (var i=0; i < scripts.length; i++) {
			if (scripts[i]) {
				try {
					if (window.execScript) {
						window.execScript(scripts[i]);
					} else {
						window.eval(scripts[i]);
					}
					success[urls[i]] = true;
					count++;
				} catch (e) {
					og.err(e.message);
				}
			}
		}
		if (typeof config.callback == 'function') {
			config.callback.call(config.scope, count, success);
		}
	};
	postScript();
};

og.loadedScripts = {};

og.ToggleTrap = function(trapid, fsid) {
	if (Ext.isIE) {
		if (!Ext.get(fsid).isDisplayed()) {
			Ext.get(fsid).setDisplayed('block');
		} else {
			Ext.get(fsid).setDisplayed('none');
		}
	}
};

og.FileIsZip = function(mimetype, name) {
	if (!name) return false;
	var ix = name.lastIndexOf('.');
	var extension = ix >= 0 ? name.substring(ix + 1) : "";
	return (mimetype == 'application/zip' || mimetype == 'application/x-zip-compressed' || 
			(mimetype == 'application/x-compressed' && extension == 'zip') || extension == 'zip');
};

og.disableEventPropagation = function(event) { 
	if (Ext.isIE) { 
		window.event.cancelBubble = true; 
	} else {
		event.stopPropagation();
	} 
};

og.showMoreActions = function(genid) {
	$("#otherActions" + genid).slideToggle('slow');
	$("#moreOption" + genid).hide();
};

og.loadEmailAccounts = function(type) {
	og.openLink(og.getUrl('mail', 'list_accounts', {type: type}),{
		callback: function(success, data) {
			if (success) {
				if (type == 'view') og.email_accounts_toview = data.accounts;
				else if (type == 'edit') og.email_accounts_toedit = data.accounts;
			}
		}
	});
};
//	SUBSCRIBERS LIST FUNCTIONS

og.rollOver = function(div)
{
	div.className += " rolling-over";
};
og.rollOut = function(div,isCompany)
{
	
	
	if (isCompany){
		isChecked=Ext.fly(div).hasClass("checked");
		div.className = "container-div company-name";
		if (isChecked){
			div.className += " checked";
		}
	}else{
		isChecked=Ext.fly(div).hasClass("checked-user");
		if (isChecked){
			div.className = "container-div checked-user";
		}else{
			div.className = "container-div user-name";
		}
	}
};
og.checkUser = function (div){
	var hiddy = document.getElementById(div.id.substring(3));
	if (hiddy) {
		if (hiddy.value == '1') {
			hiddy.value = '0';
			div.className = "container-div user-name";
		} else {
			hiddy.value = '1';
			div.className = "container-div checked-user";
		}
	}
};
og.subscribeCompany = function (div){
		var isChecked = Ext.fly(div).hasClass("checked");
		var hids = div.parentNode.getElementsByTagName("input");
		for (var i=0; i < hids.length; i++) {
			var hiddenTag = hids[i];
			if (!isChecked && !hiddenTag.checked || isChecked && hiddenTag.checked) {
				og.checkUser(hiddenTag.parentNode);
			}
		}
		
		if (!isChecked) {
			Ext.fly(div).addClass('checked');
		} else {
			Ext.fly(div).removeClass('checked');
		}
};

og.confirmRemoveTags = function(manager) {
	var man = Ext.getCmp(manager);
	
	var removeAction = function() {
		og.ExtendedDialog.dialog.destroy();
		if (man) man.removeTags();
	};
	
	var cancelAction = function() {
		og.ExtendedDialog.dialog.destroy();
	};
	
	var config = {
		title: lang('remove tags'),
		y :50,
		id :'removeTags',
		modal :true,
		height :125,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('yes'),
			handler :removeAction,
			id :'yes_button',
			scope :this
		}, {
			text :lang('no'),
			handler :cancelAction,
			id :'no_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'moveadd_label',
			id :'moveadd',
			hideLabel :true,
			style: 'font-size:100%;',
			text: lang('confirm remove tags')
		} ]
	};
	og.ExtendedDialog.show(config);
}

og.confirmMoveToAllWs = function(manager, text) {
	var man = Ext.getCmp(manager);
	
	var moveAction = function() {
		og.ExtendedDialog.dialog.destroy();
		man.moveObjectsToAllWs();
	};
	
	var cancelAction = function() {
		og.ExtendedDialog.dialog.destroy();
	};
	
	var config = {
		title: '',
		y :50,
		id :'moveToAllWs',
		modal :true,
		height :125,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('yes'),
			handler :moveAction,
			id :'yes_button',
			scope :this
		}, {
			text :lang('no'),
			handler :cancelAction,
			id :'no_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'moveadd_label',
			id :'moveadd',
			hideLabel :true,
			style: 'font-size:100%;',
			text: text
		} ]
	};
	og.ExtendedDialog.show(config);
}

og.moveToWsOrMantainMembers = function(manager, ws) {
	var man = Ext.getCmp(manager);
	
	var moveAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsToWsOrMantainMembers(0, ws);
//		man.getSelectionModel().clearSelections();
	};
	var mantainAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsToWsOrMantainMembers(1, ws);
//		man.getSelectionModel().clearSelections();
	};
	
	if (og.preferences['drag_drop_prompt'] == 'move') {
		moveAction();
		return;
	} else if (og.preferences['drag_drop_prompt'] == 'keep') {
		mantainAction();
		return;
	}

	var config = {
		title :lang('move to workspace or keep old ones'),
		y :50,
		id :'moveToWsOrAddWs',
		modal :true,
		height :150,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('move to workspace'),
			handler :moveAction,
			id :'move_button',
			scope :this
		}, {
			text :lang('keep old workspaces'),
			handler :mantainAction,
			id :'add_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'moveadd_label',
			id :'moveadd',
			hideLabel :true,
			style: 'font-size:100%;',
			text :lang('do you want to move objects to this ws or keep old ones and add this ws')
		} ]
	};
	og.ExtendedDialog.show(config);
};

og.askToClassifyUnclassifiedAttachs = function(manager, mantain, ws) {
	var man = Ext.getCmp(manager);
	
	var classifyAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsClassifyingEmails(mantain, ws, 1);
	};
	var leaveAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsClassifyingEmails(mantain, ws, 0);
	};
	
	if (og.preferences['mail_drag_drop_prompt'] == 'classify') {
		classifyAction();
		return;
	} else if (og.preferences['mail_drag_drop_prompt'] == 'dont') {
		leaveAction();
		return;
	}

	var config = {
		title :lang('classify mail attachments'),
		y :50,
		id :'classifyAttachs',
		modal :true,
		height :150,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('yes'),
			handler :classifyAction,
			id :'yes_button',
			scope :this
		}, {
			text :lang('no'),
			handler :leaveAction,
			id :'no_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'classify_label',
			id :'classify_leave',
			hideLabel :true,
			style: 'font-size:100%;',
			text :lang('do you want to classify the unclassified emails attachments')
		} ]
	};
	og.ExtendedDialog.show(config);
};


og.replaceAllOccurrences = function(str, search, replace) {
	while (str.indexOf(search) != -1) {
		str = str.replace(search, replace);
	}
	return str;
};

og.isFlashSupported = function() {
	return navigator.mimeTypes["application/x-shockwave-flash"] ? true : false;
};

og.showHide = function(itemId, mode) {
	if (!mode || (mode != 'block' && mode != 'inline')) mode = 'block';
	var el = document.getElementById(itemId);
	if (el) {
		if (el.style.display == 'none') el.style.display = mode;
		else el.style.display = 'none';
	}
};

og.calculate_time_zone = function(server) {
	var client = new Date();
	var diff = client.getTime() - server.getTime();
	diff = Math.round(diff*2/3600000);
	return diff / 2;
};

og.redrawLinkedObjects = function(id) {
	var div = Ext.get("linked_objects_in_prop_panel");
	if (div) {
		div.load({url: og.getUrl('object', 'redraw_linked_object_list', {id:id}), scripts: true});
	}
}

og.redrawSubscribers = function(id, genid) {
	var div = Ext.get(genid + "subscribers_in_prop_panel");
	if (div) {
		div.load({url: og.getUrl('object', 'redraw_subscribers_list', {id:id}), scripts: true});
	}
}

og.show_hide_subscribers_list = function(id, genid) {
	og.openLink(og.getUrl('object', 'add_subscribers_list', {obj_id: id, genid: genid}), {
		preventPanelLoad:true,
		onSuccess: function(data) {

			og.ExtendedDialog.show({
        		html: data.current.data,
        		height: 450,
        		width: 685,
        		ok_fn: function() {
        			formy = document.getElementById(genid + "add-User-Form");
        			var params = Ext.Ajax.serializeForm(formy);
        			var options = {callback: function(data, success){
            			og.redrawSubscribers(id, genid);
        			}}
    				options[formy.method.toLowerCase()] = params;
    				og.openLink(formy.getAttribute('action'), options);
    				og.ExtendedDialog.hide();        			
    			}        			
        	});
        	return;
		}
	});
};

/*
 * Adds the listener to manage concurrency while editing objects.
 * it shows a yes or no dialog, if the answer is yes re-send the form data
 * and set "merge-changes" attribute to true so that the object list view is shown.
 *  If no is choosen it sent the form and overwrite the submited data. 
 */
og.eventManager.addListener('handle edit concurrence', 
	function (data) {
		var genid = data['genid'];
		var elem = document.getElementById( genid + 'merge-changes-hidden');
		elem.value = '';
		var hidden = document.getElementById(genid + "updated-on-hidden");
 		if (hidden) {
 			hidden.value = data['updatedon'];
 		}
		var dialog = '<div style="padding:10px;">';
		dialog += '<h1>' + lang('allready updated object') + '</h1><br />';
		dialog += '<div>' + lang('allready updated object desc') + '</div></div>';
		og.ExtendedDialog.show({
    		html: dialog,
    		height: 250,
    		width: 350,
    		YESNO: true,
    		ok_fn: function() {
    			og.ExtendedDialog.hide();
    			elem.value = 'true';
    			var form = document.getElementById(genid + "submit-edit-form");
    			form.onsubmit();
    			elem.value = '';
			}
    	});
	}
);

og.getCkEditorInstance = function(name) {
	var editor = null;
	for (instName in CKEDITOR.instances) {
		if (instName == name) {
			editor = CKEDITOR.instances[instName];
			break;
		}
	}
	return editor;
};

og.adjustCkEditorArea = function(genid, id, keep_bottom) {
	if(id == undefined) id = '';
	var el = document.getElementById('cke_' + genid + 'ckeditor' + id);
	if (el) el.style.padding = '0px';
	
	var cont = document.getElementById('cke_contents_' + genid + 'ckeditor' + id);
	if (cont) {
		cont.style.padding = '0px';
		cont.style.border = '0px none';
	}
	if (!keep_bottom) {
		var bot = document.getElementById('cke_bottom_' + genid + 'ckeditor' + id);
		if (bot) bot.style.display = 'none';
	}
};

og.hideFlashObjects = function() {
	var flash = document.getElementsByTagName('embed');
	for (var i=0; i < flash.length; i++) {
		flash[i].style.visibility = 'hidden';
		flash[i].hiddenFlashObject = true;
	}
};

og.restoreFlashObjects = function() {
	var flash = document.getElementsByTagName('embed');
	for (var i=0; i < flash.length; i++) {
		if (flash[i].hiddenFlashObject) flash[i].style.visibility = 'visible';
		flash[i].hiddenFlashObject = false;
	}
};

og.promptDeleteAccount = function(account_id, reload) {
	var check_id = Ext.id();
	var config = {
		genid: Ext.id(),
		title: lang('confirm delete mail account'),
		height: 150,
		width: 250,
		labelWidth: 150,
		ok_fn: function() {
			var checked = Ext.getCmp(check_id).getValue();
			og.openLink(og.getUrl('mail', 'delete_account', {
				id: account_id,
				deleteMails: checked ? 1 : 0,
				reload: reload ? 1 : 0
			}));
			og.ExtendedDialog.hide();
		},
		dialogItems: {
			xtype: 'checkbox',
			fieldLabel: lang('delete account emails'),
			id: check_id,
			value: false
		}
	};
	og.ExtendedDialog.show(config);
};

og.promptDeleteCalendar = function(calendar_id) {
	var check_id = Ext.id();
	var config = {
		genid: Ext.id(),
		title: lang('delete calendar'),
		height: 200,
		width: 250,
		labelWidth: 150,
		ok_fn: function() {
			var checked = Ext.getCmp(check_id).getValue();
			og.openLink(og.getUrl('event', 'delete_calendar', {
				cal_id: calendar_id,
				deleteCalendar: checked ? 1 : 0
			}));
			og.ExtendedDialog.hide();
		},
		dialogItems: {
			xtype: 'checkbox',
			fieldLabel: lang('delete calendar events'),
			id: check_id,
			value: false
		}
	};
	og.ExtendedDialog.show(config);
};

og.htmlToText = function(html) {
	// remove line breaks
	html = html.replace(/[\n\r]\s*/g, "");
	// change several white spaces for one
	html = html.replace(/[ \t][ \t]+|&nbsp;/g, " ");
	// insert line breaks were they belong
	html = html.replace(/(<\/table>|<\/tr>|<\/div>|<br *\/?>|<\/p>)/g, "$1\n");
	// insert tabs on tables
	html = html.replace(/(<\/td>)/g, "$1\t");
	// strip tags
	html = html.replace(/<[^>]*>/g, "");

	return html;
};

og.updateUnreadEmail = function(unread) {
	if (og.preferences['show_unread_on_title']) {
		var title = document.title;
		if (title.charAt(0) == '(' && title.indexOf(')') > 0) {
			title = title.substring(title.indexOf(')') + 2);
		}
		if (unread > 0) {
			document.title = "(" + unread  + ") " + title;
		} else {
			document.title = title;
		}
	}
	var panel = Ext.getCmp('mails-panel');
	if (panel) {
		if (unread > 0) {
			panel.setTitle(lang('email tab') + " (" + unread  + ")");
		} else {
			panel.setTitle(lang('email tab'));
		}
	} else {
		var tab = Ext.select("#tabs-panel__mails-panel span.x-tab-strip-text");
		tab.each(function() {
			if (unread > 0) {
				this.innerHTML = lang('email tab') + " (" + unread + ")";
			} else {
				this.innerHTML = lang('email tab');
			}
		});
	}
};

og.onChangeObjectCoType = function(genid, manager, id, new_cotype) {
	og.openLink(og.getUrl('object', 're_render_custom_properties', {id:id, manager:manager, req:1, co_type:new_cotype}), 
		{callback: function(success, data) {
			if (success) {
				var div = Ext.get(genid + 'required_custom_properties');
				if (div) div.remove();
				var container = Ext.get(genid + 'required_custom_properties_container');
				if (container) {
					container.insertHtml('beforeEnd', '<div id="'+genid+'required_custom_properties">'+data.html+'</div>');
					eval(data.scripts);
				}
			}
		}}
	);
/*	og.openLink(og.getUrl('object', 're_render_custom_properties', {id:id, manager:manager, req:0, co_type:new_cotype}), 
		{callback: function(success, data) {
			if (success) {
				var div = Ext.get(genid + 'not_required_custom_properties');
				if (div) div.remove();
				var container = Ext.get(genid + 'not_required_custom_properties_container');
				if (container) {
					container.insertHtml('beforeEnd', '<div id="'+genid+'not_required_custom_properties">'+data.html+'</div>');
					eval(data.scripts);
				}
			}
		}}
	);
*/
};

og.expandDocumentView = function(link) {
	var document_view = $(link).parent();
	var container = $(link).closest(".x-panel-body");

	if (link.expanded) {

		$(document_view).css({
			'height': link.old_height + 'px',
			'position':'relative'
		});
		link.title = lang('expand');
		link.className = 'ico-expand';

		$(container).animate({ scrollTop: 0 }, 0);
		$(container).css('overflow-y', 'auto');
		
		link.expanded = false;
	} else {

		link.old_height = $(document_view).height();
		$(document_view).css({
			'z-index': '500',
			'top': '0px',
			'height': '100%',
			'position':'absolute'
		});

		link.title = lang('collapse');
		link.className = 'ico-collapse';

		$(container).animate({ scrollTop: 0 }, 0);
		$(container).css('overflow-y', 'hidden');
		
		link.expanded = true;
	}
};

og.getHostName = function() {
	og.hostName = og.hostName.replace(/\/+$/, "");
	return og.hostName;
};

og.handleMemberChooserSubmit = function(genid, objectType, preHfId) {
	if (!preHfId) preHfId = "";
	var panels = Ext.getCmp(genid + "-member-chooser-panel-" + objectType);
	if (panels) {
		var memberChoosers = panels.items ;
		var members = [] ;
		if ( memberChoosers ) {
			memberChoosers.each(function(item, index, length) {
				var checked = item.getChecked("id");
				for (var j = 0 ; j < checked.length ; j++ ) {
					members.push(checked[j]);
				}
			});
			if (og.can_submit_members){
				document.getElementById(genid + preHfId + member_selector[genid].hiddenFieldName).value = Ext.util.JSON.encode(members);
			}
			var el = document.getElementById(genid + preHfId + "trees_not_loaded");
			if (el) el.value = og.can_submit_members ? 0 : 1;
		}
	}
	return true;
}

og.getSandboxName = function() {
	og.sandboxName = og.sandboxName ? og.sandboxName.replace(/\/+$/, "") : og.getHostName();
	return og.sandboxName;
};

og.formatPopupMemberChooserSelectedValues = function(genid, selected) {
	var html = '';
	var title = '';
	var memberChoosers = Ext.getCmp("menu-panel").items;
	for (i=0; i<selected.length; i++) {
		if ( memberChoosers ) {
			memberChoosers.each(function(item, index, length) {
				var node = item.getNodeById(selected[i]);
				if (node) {
					title += node.text;
					if (i < selected.length - 1) title += ',';
					title += ' ';
				}
			});
		}
	}
	html = title.length > 40 ? title.substring(0, 37) + "..." : title;
	var ico = Ext.get(genid + 'popup_ms_icon');
	if (ico) {
		ico.dom.className = 'ico-edit';
		ico.dom.innerHTML = lang('edit');
	}
	
	return {html:html, title:title};
}

og.popupMemberChooserHtml = function(genid, obj_type, hf_members_id, selected, no_label) {
	var ico_cls = 'db-ico ico-add';
	var action = lang('add');
	var to_show = {html:'<span class="desc">' + lang('none selected') + '</span>', title:''};
	if (selected) {
		to_show = og.formatPopupMemberChooserSelectedValues(genid, selected);
		ico_cls = 'db-ico ico-edit';
		action = lang('edit');
	}
	var onclick_ev = 'og.showPopupMemberChooser(\''+genid+'\', \''+obj_type+'\', \''+hf_members_id+'\', \''+selected+'\');';
	var html = '';
	if (!no_label)
		html += '<div style="padding-top:5px;"><label style="font-size:100%;display:inline;margin-right:30px;">'+lang('context')+':&nbsp;</label>';
	html += '<span id="'+genid+'popup_member_selector" onclick="'+ onclick_ev +'" style="cursor:pointer;" title="' + to_show.title + '">' + to_show.html + '</span>';
	html += '<span id="'+genid+'popup_ms_icon" class="'+ico_cls+'" onclick="'+ onclick_ev +'" style="cursor:pointer; padding:5px 0 0 20px; margin-left:5px;">' + action + '</span>'
	html += '</div>';
	return html;
};

og.showPopupMemberChooser = function(genid, obj_type, hf_members_id, selected) {
	og.openLink(og.getUrl('object', 'popup_member_chooser', {obj_type: obj_type, genid: genid, selected: selected}), {
		preventPanelLoad:true,
		onSuccess: function(data) {
			var dialog = og.ExtendedDialog.show({
				html: data.current.data,
				title: lang('select context members'),
				iconCls: 'ico-workspace',
				resizable: true,
				minHeight: 273,
				minWidth: 480,
				height: 273,
				width: 480,
				ok_fn: function() {
					og.handleMemberChooserSubmit(genid, obj_type);	
					var sel_members = Ext.get(genid + member_selector[genid].hiddenFieldName).getValue();
					var hf = Ext.get(genid + hf_members_id);
					hf.dom.value = sel_members;
					
					og.ExtendedDialog.hide();
					if (sel_members != '') {
						var to_show = og.formatPopupMemberChooserSelectedValues(genid, Ext.util.JSON.decode(sel_members));
						var sel = Ext.get(genid + 'popup_member_selector');
						sel.dom.innerHTML = to_show.html;
						sel.dom.title = to_show.title;
					}
				}        			
			});

			return;
		}
	});
}

og.drawComboBox = function(config) {
	if (!config) config = {};
	if (!config.render_to) config.render_to = '';
	if (!config.id) config.id = Ext.id();
	if (!config.name) config.name = Ext.id();
	if (!config.selected) config.selected = 0;
	if (!config.store) config.store = [];
	if (!config.empty_text) config.empty_text = '';
	if (!config.tab_index) config.tab_index = '500';
	if (!config.width) config.width = 200;
	if (!config.typeAhead) config.typeAhead = false;
	//if (!config.editable) config.editable = true;
	
	var combo = new Ext.form.ComboBox({
		renderTo: config.render_to,
		name: config.name,
		id: config.id,
		value: config.selected,
		store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : config.store
	    }),
	    emptyText: config.empty_text,
	    width: config.width,
        listWidth: config.width,
        tabIndex: config.tab_index,
        displayField: 'text',
        editable: config.editable == true,
        typeAhead: config.typeAhead,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus: true,
        valueField: 'value',
        valueNotFoundText: '',
        disabled: config.disabled == true,
        hidden: config.hidden == true
	});
	
	Ext.get(config.id).setWidth(config.width - 18);
	combo.setWidth(config.width);
	return combo;
}


og.drawDateMenuPicker = function(config) {
	var datemenu = new Ext.menu.DateMenu({
	    id: config.id ? config.id : Ext.id(),
	    format: og.preferences['date_format'],
	    startDay: og.preferences['start_monday'],
		altFormats: lang('date format alternatives'),
		listeners: config.listeners,
		items: config.items
	});
	
	Ext.apply(datemenu.picker, { 
		okText: lang('ok'),
		cancelText: lang('cancel'),
		monthNames: [lang('month 1'), lang('month 2'), lang('month 3'), lang('month 4'), lang('month 5'), lang('month 6'), lang('month 7'), lang('month 8'), lang('month 9'), lang('month 10'), lang('month 11'), lang('month 12')],
		dayNames:[lang('sunday'), lang('monday'), lang('tuesday'), lang('wednesday'), lang('thursday'), lang('friday'), lang('saturday')],
		monthYearText: '',
		nextText: lang('next month'),
		prevText: lang('prev month'),
		todayText: lang('today'),
		todayTip: lang('today')
	});
	
	return datemenu;
}

og.quickForm = function (config) {
	if (!config) return false ;
	switch (config.type) {
		case "member":
			var d = config.dimensionId ;
			var tree = Ext.getCmp("dimension-panel-"+d);
			if (tree) {
				var selected = tree.getSelectionModel().getSelectedNode();
				if (!selected || selected.getDepth() == 0  ) {
					var parent = 0 ; 
				}else{
					var parent = selected.id ;
				}
				
				var e = $("#"+config.elId) ;
				if (d) {
					if (og.quick_form_visible == d && $("#quick-form").css('display') != 'none') {
						og.quick_form_visible = 0;
						$("#quick-form").slideUp();
					} else {
						og.openLink(og.getUrl('member', 'quick_add_form',{dimension_id: config.dimensionId, parent_member_id: parent}), {
							preventPanelLoad: true,
							callback: function(success, data) {
								
								og.quick_form_visible = d;
								
								if (data.draw_menu) {
									var html = '<ul class="quick-menu-list">';
									$("#quick-form").addClass("menu");
									for (var k=0; k<data.urls.length; k++) {
										var url_obj = data.urls[k];
										html += '<li class="quick-menu-item">';
										html += '<a class="link-ico '+url_obj.iconcls+'" href="#" onclick="og.openLink(\''+ url_obj.url +'\'); $(\'#quick-form\').hide(); return false;">'+ url_obj.link_text +'</a></li>';
									}
									html += "</ul>";
									
									var offset = e.offset();
									$("#quick-form .form-container").html('').html(html);
									$("#quick-form .form-container").parent().css({top: offset.top + 15, left: offset.left + 15}).slideDown('normal', function(){
										var bottom = $("#quick-form .form-container").css('bottom').replace('px', '');
										if (bottom < 0) $("#quick-form .form-container").animate({"top" : "+="+bottom+"px"});
									});
									
								} else {
									if (data.urls && data.urls.length > 0) {
										var url_obj = data.urls[0];
										og.openLink(url_obj.url);
										
										if ($("#quick-form").css('display') != 'none') {
											og.quick_form_visible = 0;
											$("#quick-form").slideUp();
										}
									}
								}
								
							}
						});
					
					}
				}
			}
			break;
                case "configFilter":				
				var e = $("#" + config.genid + "configFilters") ;    
                                $("#quick-form .form-container").html('').load(og.getUrl('contact', 'quick_config_filter_activity',{members: config.members}),function(){
                                        var new_offset = {top:e.offset().top,left:e.offset().left-240,right:e.offset().right,bottom:e.offset().bottom};
                                        $(this).parent().css(new_offset).slideDown();
                                    return true ;
                                });
                                return false;
			break;
		default: 
			break
	}
	return false ;
}

og.flash2img = function() {
	$.each ( $('embed') , function(k,elem) {
		var convert =  (typeof elem.get_img_binary == "function") ;
		if ( convert ) {
			var base64 = elem.get_img_binary();
			if ( base64 ){  // Arbitrary min size to check if is image  
				var image = document.createElement('img');
				image.src = "data:image/jpg;base64,"+base64 ;
				$(elem).replaceWith( image );
			}
		}
	});

}

og.getMemberTreeNodeColor = function(node) {
	var color = "";
	if (node.ui && node.ui.getIconEl()) {
		classes = node.ui.getIconEl().className.split(" ");
		for(j=0; j<classes.length; j++) {
			if (classes[j].indexOf('ico-color') >= 0) color = classes[j].replace('ico-color', "");
		}
	}
	return color;
}


og.getMemberFromTrees = function(dim_id, mem_id, include_parents) {
	var texts = [];
	var tree = Ext.getCmp("dimension-panel-" + dim_id);
	if (tree) {
		//og.expandCollapseDimensionTree(tree);
		
		var selnode = tree.getSelectionModel().getSelectedNode();
		selnode_id = selnode ? selnode.id : -1;
		node = tree.getNodeById(mem_id);
		if (node) {
			//if (node.id != selnode_id) {
				texts.push({id:node.id, text:node.text, ot:node.object_type_id, c:og.getMemberTreeNodeColor(node)});
				if (include_parents) {
					while(node.parentNode && node.parentNode.id > 0 && node.parentNode.id != selnode_id) {
						node = node.parentNode;
						if (node) texts.push({id:node.id, text:node.text, ot:node.object_type_id, c:og.getMemberTreeNodeColor(node)});
					}
				}
			//}
		}
	}
	return texts;
}

og.expandCollapseDimensionTree = function(tree, previous_exp, selection_id) {
	if (tree && !tree.expanded_once) {
		if (previous_exp) {
			expanded = previous_exp;
		} else {
			expanded = [];
			tree.root.cascade(function(){
				if (this.isExpanded()) expanded.push(this.id);
			});
		}
		if (selection_id) {
			tree.root.expand(true, false, function(){tree.selectNodes([selection_id])});
		}else{
			tree.root.expand(true, false);
		}
		tree.root.collapse(true, false);
		
		for(i=0; i<expanded.length; i++) {
			node = tree.getNodeById(expanded[i]);
			if (node) node.expand(false);
		}
		
		tree.expanded_once = true;
	}
}

og.memberTreeExternalClick = function(tree_id, member_id) {
	var dimensions_panel = Ext.getCmp('menu-panel');
	dimensions_panel.items.each(function(item, index, length) {
		if (item.dimensionCode == tree_id) {
			item.onMemberExternalClick(member_id);				
		}
	});
	
}

/*
 * The email must contain an @ sign and at least one dot (.).
 *  Also, the @ must not be the first character of the email address,
 *   and the last dot must be present after the @ sign, and minimum 2 characters before the end
 */
og.checkValidEmailAddress = function(email) {
	  var atpos=email.indexOf("@");
	  var dotpos=email.lastIndexOf(".");
	  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
	      return false;
	  }else{
		  return true;
	  }
	  
}

og.checkEmailAddress = function(element,id_contact) {
	$(element).blur(function(){
		var field = $(this);
		// Ajax to ?c=contact&a=check_existing_email&email=admin@admin.com&ajax=true
		var url = og.makeAjaxUrl(og.getUrl("contact", "check_existing_email", {email: field.val(),id_contact:id_contact}));
		og.loading();
		$.getJSON(url, function(data) {
			$(".field-error-msg").remove();
			var contact = data.contact;
			if (contact.status) {
				$(field).addClass("field-error");
				$(field).after("<div class='field-error-msg'>"+lang("email already taken by",contact.name)+" </div>");
				$(field).focus();
			}else{
				$(field).removeClass("field-error");
				if(contact.id){
					og.openLink(og.getUrl('contact', 'edit',{id:contact.id,isEdit:1}));
					$("#quick-form").hide();
				}
			}
			og.hideLoading();
		});

		setTimeout(function(){og.hideLoading()}, 5000); //If ajax fails
	});
}

og.selectDimensionTreeMember = function(data) {
	var tree = Ext.getCmp("dimension-panel-" + data.dim_id);
	if (tree) {
		if (data.node == 'root') {
			og.contextManager.cleanActiveMembers(data.dim_id);
			if (!tree.hidden) og.contextManager.addActiveMember(0, data.dim_id, tree.root);
			tree.selectRoot();
		} else {
			var treenode = tree.getNodeById(data.node);
			if (treenode) {
				treenode.select();
				treenode.ensureVisible();
				if (!tree.hidden) og.contextManager.addActiveMember(node, data.dim_id, treenode);
			}
		}
	}
}


og.loadWidget = function (name, callback ){
	var url = og.getUrl('dashboard', 'load_widget', {name: name});
	var params = {callback: callback} ;
	og.openLink(url , params) ;
	
}

og.quickAddTask = function (data, callback) {
	var name = data.name ;
	var due_date = data.due_date ;
	var due_time = data.due_time ;
	var assigned_to = data.assigned_to | 0;
	
	var ajaxOptions = {
		post : {
			'task[assigned_to_contact_id]': assigned_to ,
			'task[name]': name,
			'task[task_due_date]': due_date,
			'task[task_due_time]': due_time
		},
		callback : callback 
	};
	var url = og.makeAjaxUrl(og.getUrl('task', 'quick_add_task', ajaxOptions));
	og.openLink(url, ajaxOptions);
}

og.quickAddWs = function (data, callback) {
	var name = data.name ;
	var parent = data.parent | 0;
	
	var ajaxOptions = {
		post : {
			'member[name]': name,
			'member[dimension_id]': data.dim_id,
			'member[parent_member_id]': parent,
			'member[object_type_id]': data.ot_id
		},
		callback : callback 
	};
	var url = og.makeAjaxUrl(og.getUrl('member', 'add', ajaxOptions));
	og.openLink(url, ajaxOptions);
}



og.onPersonClose = function() {
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	if (currentPanel.id != 'overview-panel') {
		og.closeView();
		return;
	}
	
	var actual_sel = og.core_dimensions.prev_selection.pop();
	var prev_sel = null;
	if (og.core_dimensions.prev_selection.length > 0) {
		prev_sel = og.core_dimensions.prev_selection[og.core_dimensions.prev_selection.length-1];
	} else {
		if (currentPanel.closable) og.closeView();
	}

	var dimensions_panel = Ext.getCmp('menu-panel');
	dimensions_panel.items.each(function(item, index, length) {
		if (item.dimensionCode == 'feng_persons') {
			if (prev_sel) {
				og.expandCollapseDimensionTree(item);
				var n = item.getNodeById(prev_sel);
				if (n) {
					if (n.parentNode) item.expandPath(n.parentNode.getPath(), false);
					item.fireEvent('click', n);
					og.contextManager.addActiveMember(n.id, item.dimensionId);
				} else {
					item.selectRoot();
					n = item.getRootNode();
					item.fireEvent('click', n);
					og.contextManager.cleanActiveMembers(item.dimensionId);
				}
			} else {
				item.selectRoot();
				n = item.getRootNode();
				item.fireEvent('click', n);
				og.contextManager.cleanActiveMembers(item.dimensionId);
			}
			
			setTimeout(function() {
		//		og.Breadcrumbs.refresh(n);
				if (n.id == item.getRootNode().id) {
					item.getSelectionModel().fireEvent('selectionchange', item.getSelectionModel(), n);
				}
			}, 500);
		}
	});
}

og.checkRelated = function(type,related_id) {
    var return_data = false;
    var url;
    switch (type) {
        case "task":            
            url = og.makeAjaxUrl(og.getUrl("task", "check_related_task"));
            $.ajax({
                url: url,
                dataType: 'json',
                async: false,
                data: {related_id: related_id},
                success: function(data) {
                    return_data = data.status;
                }
            });
            return return_data;
            break;
        case "event":
            url = og.makeAjaxUrl(og.getUrl("event", "check_related_event"));
            $.ajax({
                url: url,
                dataType: 'json',
                async: false,
                data: {related_id: related_id},
                success: function(data) {
                    return_data = data.status;
                }
            });
            return return_data;
        default: 
            return return_data;
            break
    }
}

og.openTab = function (id) {
	Ext.getCmp('tabs-panel').activate(id);
}

og.reload_subscribers = function(genid, object_type_id, user_ids) {
	if (!user_ids) {
		var uids = App.modules.addMessageForm.getCheckedUsers(genid);
	} else {
		var uids = user_ids;
	}
	Ext.get(genid + 'add_subscribers_content').load({
		url: og.getUrl('object', 'render_add_subscribers', {
			context: Ext.util.JSON.encode(member_selector[genid].sel_context),
			users: uids,
			genid: genid,
			otype: object_type_id
		}),
		scripts: true
	});
}

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects
		 for(var item in arr) {
			  var value = arr[item];
			 
			  if(typeof(value) == 'object') { //If it is an array,
				   dumped_text += level_padding + "'" + item + "' ...\n";
				   dumped_text += dump(value,level+1);
			  } else {
	 			   dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			  }
		 }
	} else { //Stings/Chars/Numbers etc.
	 dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

og.load_company_combo = function(combo_id, selected_id) {
	if (!og.json_companies) {
		$("#"+combo_id).css('display', 'none');
		$("#"+combo_id+"-loading").css('display', '');
		$.ajax({
			type: "GET",
			url: og.getUrl('contact', 'get_companies_json'),
			dataType: "json",
			async: true,
			success: function(data, textStatus) {
				var html = "";
				for (var i=0; i<data.length; i++) {
					sel = selected_id && selected_id == data[i].id ? " selected=selected " : "";
					html += "<option value=\"" + data[i].id + "\"" + sel + ">" + data[i].name + "</option>";
				}
				$("#"+combo_id).empty().append(html);
	
				// cache if there are many companies
				if (data.length > 1000) {
					og.json_companies = data;
				}

				$("#"+combo_id+"-loading").css('display', 'none');
				$("#"+combo_id).css('display', '');
			}
		});
	} else {
		$("#"+combo_id).css('display', 'none');
		$("#"+combo_id+"-loading").css('display', '');
		
		data = og.json_companies;
		var html = "";
		for (var i=0; i<data.length; i++) {
			sel = selected_id && selected_id == data[i].id ? " selected=selected " : "";
			html += "<option value=\"" + data[i].id + "\"" + sel + ">" + data[i].name + "</option>";
		}
		$("#"+combo_id).empty().append(html);
	
		$("#"+combo_id+"-loading").css('display', 'none');
		$("#"+combo_id).css('display', '');
	}
}

/**
 * Clears all dimension tree selections  
 */
og.clearDimensionSelection = function() {
	var dimensions_panel = Ext.getCmp('menu-panel');
	var n = null;
	var tree = null;
	
	// select all root nodes
	dimensions_panel.items.each(function(item, index, length) {
		item.selectRoot();
		if (n == null || tree == null) {
			n = item.getRootNode();
			tree = item;
		}
		og.contextManager.cleanActiveMembers(item.dimensionId);
	});
	
	// reset bradcrumbs with the first dimension onclick event
	if (tree != null && n != null) {
		tree.fireEvent('click', n);
	}
	
	// force all tab panels reload when needed
	Ext.getCmp('tabs-panel').items.each(function(tab, index, length) {
		tab.loaded = false;
	});

	// relaod current tab
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	if (currentPanel && currentPanel.id != 'overview') {
		currentPanel.reload();
	}
}

/**
 * Dimension column renderer for ext grid listings
 */
og.renderDimCol = function(value, p, r) {
	var dim_id = p.id.replace(/dim_/, '');
	var text = '';
	var mpath = Ext.util.JSON.decode(r.data.memPath);
	//console.log(value);console.log(p);console.log(r);console.log(mpath);console.log("-------------------------");
	if (mpath) {
		var mpath_aux = {};
		mpath_aux[dim_id] = {};
		for (t in mpath[dim_id]) {
			mpath_aux[dim_id][t] = mpath[dim_id][t];
		}
		text = "<div class='breadcrumb-container' style='width: 100%;'>";
		text += og.getEmptyCrumbHtml(mpath_aux, '.breadcrumb-container');
		text += "</div>";
	}
	return text;
}

og.expandMenuPanel = function(options) {
	var animate = options.animate ? options.animate : true;
	if (options.expand) Ext.getCmp('menu-panel').expand(animate);
	else if (options.collapse) Ext.getCmp('menu-panel').collapse(animate);
}

og.addNodesToTree = function(tree_id) {
	var tree = Ext.getCmp(tree_id);
	var o = og.tmp_members_to_add[tree_id].pop();
	
	if (o) {
		for (i=0; i<o.length; i++) {
			if (!o[i]) continue;
			var n = tree.loader.createNode(o[i]);
			n.object_id = o[i].object_id;
			n.options = o[i].options;
			n.object_controller = o[i].object_controller;
			n.allow_childs = o[i].allow_childs;

			if (n) og.tmp_node[tree.dimensionId].appendChild(n);
		}
	}
}

og.showHideWidgetMoreLink = function(cls, linkid, show) {
	og.showHide('hidelnk' + linkid);
	og.showHide('showlnk' + linkid);

	if (show) $(cls).show("slow");
	else $(cls).hide("slow");
}

og.getColorInputHtml = function(genid, field_name, value, col, label) {
	if (!col) col = 'color';
	if (!field_name) field_name = 'member';
	if (!value) value = 0;
	
	var html = '';
	if (label) {
		html += '<label for="'+ genid + field_name +'_' + col +'">' + label + ':</label>';
	}
	html += '<input name="'+field_name+'[' + col + ']" id="'+ genid + field_name +'_' + col +'" class="color-code" type="hidden" value="'+value+'" />';
	html += "<div class='ws-color-chooser'>";
	for (var i=1; i<=24; i++) {
		var cls = (value == i)?'selected':'';
		html += "<div  class='ico-color"+i+ " "+ cls + " color-cell'  onClick='$(\"input.color-code\").val(\""+i+"\");$(\".color-cell\").removeClass(\"selected\");$(this).addClass(\"selected\");'></div>";
		if (i==12) {
			html +=	'<div class="x-clear"></div>';
		}
	}
	html+=	'<div class="x-clear"></div>';
	html+=	'</div>';
	
	return html;
}


og.showSelectTimezone = function(genid)	{
	var check = document.getElementById(genid + "userFormAutoDetectTimezoneYes");
	var div = document.getElementById(genid + "selecttzdiv");
	if (check && div) div.style.display = check.checked ? "none" : "";
};

og.getTimezoneFromBrowser = function(server, genid) {
	var check = document.getElementById(genid + 'userFormAutoDetectTimezoneYes');
	var combo = document.getElementById(genid + 'userFormTimezone');
	if (check.checked){
		var client = new Date();
		var diff = client.getTime() - server.getTime();
		diff = Math.round(diff*2/3600000);
		for (var i=0; i<combo.options.length; i++) {
			if (combo.options[i].value == diff/2) {
				combo.options[i].selected = 'selected';
			}
		}
	}
};

og.goToOverview = function(close_active_tab) {
	var opanel = Ext.getCmp('overview-panel');
	if (opanel) {
		var active_tab = Ext.getCmp('tabs-panel').getActiveTab();
		Ext.getCmp('tabs-panel').setActiveTab(opanel);
		if (close_active_tab && active_tab) {
			Ext.getCmp('tabs-panel').remove(active_tab);
		}
	}
}

og.goback = function(btn) {
	var p = og.getParentContentPanel(Ext.fly(btn));
	if (p) Ext.getCmp(p.id).back();
};

og.fade_background_color = function(id, color) {
	if (!color) color = "white";
	$("#"+id).animate({
	   backgroundColor: color
	}, 'slow');
}


og.dimensionTreeDoLayout = function(genid, dim_id) {
	var memberChooserPanel = Ext.getCmp(genid + '_with_permissions_' + dim_id);
	if (memberChooserPanel && !memberChooserPanel.initialized) {
		memberChooserPanel.doLayout();
		memberChooserPanel.initialized = true;
	}
	var memberChooserPanel2 = Ext.getCmp(genid + '_without_permissions_' + dim_id);
	if (memberChooserPanel2 && !memberChooserPanel2.initialized) {
		memberChooserPanel2.doLayout();
		memberChooserPanel2.initialized = true;
	}
}


og.onParentMemberRemove = function (genid){	
	document.getElementById(genid + "memberParent").value = 0;
}
/*
og.onParentMemberSelect = function (genid, container_id, dimension_id, item){
	if (!item) {
		// remove member
		document.getElementById(genid + "memberParent").value = 0;
		return;
	}
	var member_id = item.value;
	if(member_id != "more"){
		document.getElementById(genid + "memberParent").value = member_id;
		if (og.prev_parent) {
			member_selector.remove_relation(dimension_id, genid, og.prev_parent, true);
		}
		member_selector.add_relation(dimension_id, genid, member_id);
		og.prev_parent = member_id;
		
	}else if (member_id == "more"){
		$("#"+container_id+"-input").val(item.label);
		//increase the limit
		ogSearchSelector.resetLimit(container_id, item.limit);
		//fire the search
		$("#"+container_id+"-input").keydown();
	}	
}*/

og.onParentMemberSelect = function (genid, dimension_id, member_id){	
	member_selector.remove_all_selections(genid);
	if (!member_id) {
		// remove member
		document.getElementById(genid + "memberParent").value = 0;
		return;
	}
	
	
	document.getElementById(genid + "memberParent").value = member_id;
	member_selector.add_relation(dimension_id, genid, member_id,false);
	og.prev_parent = member_id;
	
	og.userPermissions.reload_member_permissions(genid, dimension_id, member_id);
}



/**
 * Create style sheet for current colors
 */
og.createBrandColorsSheet = function(brand_colors) {
	var header_back = brand_colors['brand_colors_head_back'];
	var tabs_back = brand_colors['brand_colors_tabs_back'];
	var tabs_font = brand_colors['brand_colors_tabs_font'];
	var header_font = brand_colors['brand_colors_head_font'];

	var texture = //'background-image: -moz-linear-gradient(45deg, rgba(0, 0, 0, 0.25) 25%, transparent 25%, transparent 75%, rgba(0, 0, 0, 0.25) 75%, rgba(0, 0, 0, 0.25)), -moz-linear-gradient(45deg, rgba(0, 0, 0, 0.25) 25%, transparent 25%, transparent 75%, rgba(0, 0, 0, 0.25) 75%, rgba(0, 0, 0, 0.25));'
			//+ 'background-image: -webkit-linear-gradient(45deg, rgba(0, 0, 0, .25) 25%, transparent 25%, transparent 75%, rgba(0, 0, 0, .25) 75%, rgba(0, 0, 0, .25)), -webkit-linear-gradient(45deg, rgba(0, 0, 0, .25) 25%, transparent 25%, transparent 75%, rgba(0, 0, 0, .25) 75%, rgba(0, 0, 0, .25));'
			 'background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 75%, rgba(255, 255, 255, 0.05) 75%, rgba(255, 255, 255, 0.05)), linear-gradient(45deg, rgba(255, 255, 255, 0.05) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 75%, rgba(255, 255, 255, 0.05) 75%, rgba(255, 255, 255, 0.05));'
			+ 'background-position: 0 0pt, 2px 2px;'
			+ 'background-size: 4px 4px; ';
	
	var cssRules = '.x-accordion-hd, ul.x-tab-strip li {background-color: #' + tabs_back + '; ' + texture + '}';
	cssRules += '.x-accordion-hd, ul.x-tab-strip {background-color: #' + tabs_back + '; ' + texture + '}';
	cssRules += 'ul.x-tab-strip li {border-color: #' + tabs_back + '}';
	cssRules += '#header {background-color: #' + header_back + '; ' + texture + '}';
	cssRules += '.x-accordion-hd, .x-tab-strip span.x-tab-strip-text {color: #' + tabs_font + '}';

	//cssRules += 'ul.x-tab-strip li.x-tab-strip-active span.x-tab-strip-text {color: #' + tabs_back + ' !important}';
	cssRules += '#logodiv h1, div.og-loading, div.header-breadcrumb-container {color: #' + header_font + '}';
	// dimension title
	cssRules += '.x-accordion-hd {background-color: #' + tabs_back + '}';
	
	// selected member
	var node_selected_back = color_utils.make_transparent_color('#' + tabs_back);
	if (node_selected_back) {
		cssRules += '.x-tree-node .x-tree-selected {background-color: ' + node_selected_back + '; border-color: ' + color_utils.darker_html_color(node_selected_back) + '}';
	}
			
	var styleElement = document.createElement("style");
	styleElement.type = "text/css";
	if (styleElement.styleSheet) {
		styleElement.styleSheet.cssText = cssRules;
	} else {
		styleElement.appendChild(document.createTextNode(cssRules));
	}
	document.getElementsByTagName("head")[0].appendChild(styleElement);
}



/**
 * Renders a modal form
 */
og.render_modal_form = function(genid, options) {
	var parameters = options.params || {};
	parameters.modal = 1;
	
	og.openLink(og.getUrl(options.c, options.a, parameters), {
		preventPanelLoad: true,
		callback: function(success, data) {
			
			if (!success) return;

			var id = genid + (options.id ? options.id : '');
			var div = document.createElement('div');
			var close_cls = options.close_cls || '';
			
			div.className = options.cls || '';
			div.id = id;
			div.innerHTML = data.current.data;

			var modal_params = {
				'escClose': typeof(options.escClose) != 'undefined' ? options.escClose : true,
				'overlayClose': typeof(options.overlayClose) != 'undefined' ? options.overlayClose : true,
				'closeHTML': '<a id="'+genid+'_close_link" class="'+close_cls+' modal-close" title="'+lang('close')+'"></a>',
				'onShow': function (dialog) {
					// add close image to close-link
					if (!options.hideCloseIcon) {
						$("#"+genid+"_close_link").addClass("modal-close-img");
					}
					
					// resize and reposition form when changing tab and content is larger than the available space
					$(".ui-tabs-anchor").click(function(){ og.resize_modal_form(); });
					og.resize_modal_form();
					
					// first execution sometimes fails to center the modal
					var offset = $(".simplemodal-data").offset();
					if (offset.top == 0) {
						setTimeout(function(){
							var h = $(".simplemodal-data").innerHeight();
							var h2 = $(".simplemodal-data").closest(".simplemodal-container").innerHeight();
							var d = h2 - h;
							if (d > 0) {
								$(".simplemodal-container").css({top: Math.floor(d/2) + 'px'});
							}
						}, 100);
					}
					
					og.resize_modal_form();
					
					// set main input width
					og.update_modal_main_input_width();
			    }
			};
			setTimeout(function() {
				$.modal(div, modal_params);
			}, 100);
		}
	});
}

og.resize_modal_form = function() {
	//if form height is larger than screen height => resize it or reposition 
	setTimeout(function() {
		var offset = $(".simplemodal-data").offset();
		var modalh = $(".simplemodal-data").height();
		var winh = $(".simplemodal-overlay").height();
		var headerh = $(".simplemodal-data .coInputHeader").height();
		var cont_offset = $(".simplemodal-container").offset();
		
		$(".simplemodal-data .form-tab").css({'max-height':(winh - (cont_offset && cont_offset.top ? cont_offset.top : 0) - 175)+'px', overflow:'auto'});
		
		if (modalh > winh) {
			// resize and reposition
			$(".simplemodal-container").css({top:'10px', height:(winh - 10)+'px'});
			$(".simplemodal-data .form-tab").css({'max-height':(winh - headerh - 125)+'px', overflow:'auto'});
		} else if (offset && modalh + offset.top > winh) {
			// only reposition
			var otop = (winh - modalh) / 2;
			if (otop < 0) otop = 0;
			$(".simplemodal-container").css({top:(otop)+'px'});
			$(".simplemodal-data .form-tab").css({'max-height':(winh - headerh - 175)+'px', overflow:'auto'});
		}
	}, 500);
}

og.update_modal_main_input_width = function() {
	var title_w = $(".simplemodal-data .coInputHeader .coInputHeaderUpperRow .coInputTitle").width();
	var buttons_w = $(".simplemodal-data .coInputHeader .coInputButtons").width();
	var total_w = $(".simplemodal-data .coInputHeader").width();
	
	var input_count = $(".simplemodal-data .coInputHeader .coInputName input.title").length;
	if (input_count < 1) input_count = 1;
	
	$(".simplemodal-data .coInputHeader .coInputName input.title").css('width', (((total_w - title_w - buttons_w) / input_count) - 35) + 'px');
}

/**
 * Submits a modal form
 */
og.submit_modal_form = function(form_id, callback_fn, options) {
	options = options || {};
	var form = document.getElementById(form_id);
	var params = {modal: 1};

	var all_inputs = $('#'+form_id+' input');
	for (var i=0; i<all_inputs.length; i++) {
		if(all_inputs[i].type == 'checkbox') {
			params[all_inputs[i].name] = all_inputs[i].checked;
		} else if (all_inputs[i].type == 'radio') {
			if (all_inputs[i].checked) {
				params[all_inputs[i].name] = params[all_inputs[i].name] = all_inputs[i].value;
			}
		} else {
			//check multiple values (if thers [] at the end of the input name) 
			//EXAMPLE object_custom_properties[2][] object_custom_properties[2][] => object_custom_properties[2][0] object_custom_properties[2][1]
			if(all_inputs[i].name.indexOf("[]") > -1 && all_inputs[i].name.slice(-2) == "[]"){
				var in_name = all_inputs[i].name;
				in_name = in_name.substring(0, in_name.length - 2);	
				var arr_index = 0;
				while (arr_index < all_inputs.length) {
					var new_in_name = in_name + "[" + arr_index + "]";
					if(!(new_in_name in params)){
						params[new_in_name] = all_inputs[i].value;
						break;
					}
					arr_index++;
				}				
			}else{
				params[all_inputs[i].name] = all_inputs[i].value;
			}
		}	
	}
	var all_selects = $('#'+form_id+' select');
	for (var i=0; i<all_selects.length; i++) {
		params[all_selects[i].name] = all_selects[i].options[all_selects[i].selectedIndex].value;
	}
	var all_textareas = $('#'+form_id+' textarea');
	for (var i=0; i<all_textareas.length; i++) {
		params[all_textareas[i].name] = all_textareas[i].value;
	}

	og.openLink(form.action, {
		post: params,
		preventPanelLoad: true,
		hideLoading: options.hideLoading || false,
		hideErrors: options.hideErrors || false,
		callback: function(success, data) {
			if (data.errorCode > 0) {
				if (data.showMessage) og.err(data.errorMessage);
				return;
			} else {
				if (callback_fn && typeof(callback_fn) == 'function') {
					callback_fn.call(null, data);
				}
				
				if (data.msg) {
					og.msg(lang('success'), data.msg);
				}
				$('.modal-close').click();
			}
		}
	});
}


og.checkAndAdjustTabsSize = function() {
  setTimeout(function() {
	
	$(".x-tab-with-icon .x-tab-strip-text").css('width', 'auto');
	
	var total_tabs_w = 40;
	var all_tabs = $("li.x-tab-with-icon");
	for (var j=0; j<all_tabs.length; j++) {
		total_tabs_w += $(all_tabs[j]).outerWidth();
	}
	var container_w = $(".x-tab-strip-wrap").width();

	if (container_w < total_tabs_w) {
		
		$(".x-tab-with-icon .x-tab-strip-text").css('width', '0px');
		$(".x-tab-with-icon.x-tab-strip-active .x-tab-strip-text").css('width', 'auto');
		
		$(".x-tab-with-icon .x-tab-left").css('padding-right', '0px');
		$(".x-tab-with-icon.x-tab-strip-active .x-tab-left").css('padding-right', '10px');
		
	} else {
		
		$(".x-tab-with-icon .x-tab-left").css('padding-right', '10px');
		$(".x-tab-with-icon.x-tab-strip-active .x-tab-left").css('padding-right', '10px');
		
	}
  }, 500);
}

og.reload_active_tab = function() {
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	if (currentPanel) {
		currentPanel.reload();
	}
}

og.removeFileExtension = function(filename) {
	if (filename.lastIndexOf('.') >= 0) {
		return filename.substring(0, filename.lastIndexOf('.'));
	} else {
		return filename;
	}
}

// animates an element using shake effect
og.single_shake = function(selector, direction, distance, times) {
	direction = direction || 'up';
	distance = distance || 3;
	times = times || 5;
	
	$(selector).effect("shake", {direction:direction, distance: distance, times: times});
}

// draws a highlight hint, used when highlighting a link
og.draw_highlight_hint = function(selector, hint_id, hint_text, hint_pos) {
	$('.highlight-hint').remove();
	if (!hint_pos) hint_pos = 'right';
	if (!hint_text) hint_text = lang('click here');
	$("<div>"+ hint_text +"</div>").attr('id', hint_id).addClass('highlight-hint').appendTo('body');

	var offset = $(selector).offset();
	$("#" + hint_id).click(function(){
		$(selector).click();
		$(selector).removeClass('highlighted');
		$(this).remove();
	});
	switch (hint_pos) {
		case 'right':
			$("#" + hint_id).css('top', offset.top + 'px');
			$("#" + hint_id).css('left', (offset.left + $(selector).width() + 25) + 'px');
			break;
		case 'left':
			$("#" + hint_id).css('top', offset.top + 'px');
			$("#" + hint_id).css('left', (offset.left - $("#" + hint_id).width() - 25) + 'px');
			break;
		case 'top':
			$("#" + hint_id).css('top', (offset.top - $("#" + hint_id).width() - 25)+ 'px');
			$("#" + hint_id).css('left', offset.left + 'px');
			break;
		case 'bottom':
			$("#" + hint_id).css('top', (offset.top + $(selector).height() + 25)+ 'px');
			$("#" + hint_id).css('left', offset.left + 'px');
			break;
		default: break;
	}
	
	
	$("#" + hint_id).show();
}

// highlights a link, with animation and hint
og.highlight_link = function(config) {
	var selector = config.selector;
	var step = config.step;
	var time_active = config.time_active;
	var timeout = config.timeout;
	var hint_text = config.hint_text;
	
	if (!selector) return;
	
	if ($(selector).length == 0) {
		setTimeout(function() {
			og.highlight_link(config);
		}, 500);
		return;
	}
	
	var hint_id = Ext.id();
	timeout = timeout || 10;
	time_active = time_active || 3000;
	
	setTimeout(function(){
		$(selector).addClass('highlighted');
		og.draw_highlight_hint(selector, hint_id, hint_text, config.hint_pos);
		// shake 2 times
		if (config.shake) {
			og.single_shake(selector, 'up', 3, 5);
			setTimeout(function(){ og.single_shake(selector, 'up', 3, 5); }, 1500);
		}
		if (config.animate_opacity > 0) {
			var animate_times = 0;
			while (animate_times < config.animate_opacity) {
				$(selector).animate({opacity:'.5'}, 'slow').animate({opacity:'1.0'}, 'slow');
				animate_times++;
			}
		}
		// remove class after time_active miliseconds
		setTimeout(function(){ 
			$(selector).removeClass('highlighted');
			$("#" + hint_id).remove();
		}, time_active);
		
		$(selector).click(function(){
			// on click remove class
			$(selector).removeClass('highlighted');
			$("#" + hint_id).remove();
			
			// update step after clicking hint
			if (step && step > 0) {
				var reload = config.reload_panel ? config.reload_panel : '0';
				og.openLink(og.getUrl('more','set_getting_started_step', {step: step, reload_panel: reload}), {hideLoading:true});
				if (step == 99) {
					$("#tabs-panel__more-panel").addClass("x-tab-strip-closable");
					$("#tabs-panel__more-panel .x-tab-strip-text").removeClass("ico-more-tab");
					$("#tabs-panel__more-panel .x-tab-strip-text").addClass("ico-administration");
					$("#tabs-panel__more-panel .x-tab-strip-text").html(lang('more-panel'));
				}
			}
		});
	}, timeout);
}

og.initPopoverBtns = function(btns){
	for (var i = 0; i < btns.length; i++) {
	    var btn = $("#"+btns[i].id);
	    btn.popover({ content: "example", 
	    	delay: { 
	    	       show: "100", 
	    	       hide: "200"
	    	    },
        	template : $("#"+btn.data("templateid")).html()
        });		   
	}		
}

og.setSettingsClosed = function() {
	og.openLink(og.getUrl('more', 'set_settings_closed'), {hideLoading: true});
}



og.renderUserTypeSelector = function(config) {
	container_id = config.container_id;
	if (!config.id) config.id = Ext.id() + '_user_type_sel';

	var selected_type = 0;
	for (role_id in og.userRoles) {
		if (role_id == config.selected_value) {
			selected_type = og.userRoles[role_id].parent;
			break;
		}
	}

	var sel_type = document.createElement("select");
	sel_type.setAttribute("onchange", "og.reloadUserRoleSelector({id:'"+config.id+"', input_name:'"+config.input_name+"'}, this.value);");
	sel_type.setAttribute("class", "user-typegroup-selector");
	sel_type.id = config.id + '_type';
	document.getElementById(container_id).appendChild(sel_type);
	
	for (type_id in og.userTypes) {
	    var option = document.createElement("option");
	    option.value = type_id;
	    //option.text = og.userTypes[type_id].name;
	    option.innerHTML = og.userTypes[type_id].name;
	    if (selected_type == type_id) {
		    option.setAttribute('selected', 'selected');
	    }
	    sel_type.appendChild(option);
	}
	
	og.renderUserRoleSelector(config, selected_type);
	
	// explanation div
	$("#"+container_id).append('<div style="display:none;" id="'+genid+'user_role_explanation" class="user-role-explanation">'+ og.userRoles[config.selected_value].hint +'</div><div class="clear"></div>');
	setTimeout(function(){
		$("#"+genid+"user_role_explanation").css('width', ($("#"+container_id).width() - 275 - $("#"+config.id+"_type").outerWidth() - $("#"+config.id+"_role").outerWidth() ) + 'px').show();
	}, 100);
}

og.renderUserRoleSelector = function(config, parent_type) {
	container_id = config.container_id;

	var sel_role = document.createElement("select");
	if (config.input_name) sel_role.name = config.input_name;
	sel_role.onchange = "";
	sel_role.id = config.id + '_role';
	sel_role.className = "user-type-selector";
	document.getElementById(container_id).appendChild(sel_role);
	
	for (role_id in og.userRoles) {
		if (og.userRoles[role_id].parent == parent_type) {
		    var option = document.createElement("option");
		    option.value = role_id;
		    //option.text = og.userRoles[role_id].name;
		    option.innerHTML = og.userRoles[role_id].name;
		    if (config.selected_value) {
			    if (config.selected_value == role_id) {
			    	option.setAttribute('selected', 'selected');
			    }
		    } else {
		    	if (role_id == og.defaultRoleByType[parent_type]) {
		    		option.setAttribute('selected', 'selected');
		    	}
		    }
		    sel_role.appendChild(option);
		}
	}
}

og.reloadUserRoleSelector = function(config, parent_type) {
	var sel_role = document.getElementById(config.id + '_role');
	for (var i=sel_role.options.length - 1; i>=0; i--) {
		sel_role.remove(i);
	}

	for (role_id in og.userRoles) {
		if (og.userRoles[role_id].parent == parent_type) {
		    var option = document.createElement("option");
		    option.value = role_id;
		    option.text = og.userRoles[role_id].name;
		    if (role_id == og.defaultRoleByType[parent_type]) {
	    		option.setAttribute('selected', 'selected');
	    	}
		    sel_role.appendChild(option);
		}
	}
	$(sel_role).change();
}


og.addUserGroupToUser = function(genid, container_id, group) {
	if (typeof(group) == 'string') group = Ext.util.JSON.decode(group);
	
	var values = $("#"+genid+"_user_groups").val();
	values = values.split(',');
	var idx = values.indexOf(group.id.toString());
	if (idx < 0) {
		
		var remove_link = '&nbsp;<a class="remove-link link-ico ico-delete" href="#" title="'+lang('remove')+'" onclick="og.removeUserFromUserGroup(\''+genid+'\', '+group.id+');">&nbsp;</a>';
		//var group_link = '<a href="#" onclick="og.openLink(og.getUrl(\'group\', \'view\', {id:'+group.id+'}))">'+ group.name +'<a/>';
		var group_link = group.name;
		
		var html = '<div class="user-group" id="'+genid+'user_group_'+group.id+'">' + group_link + remove_link + '</div>';
		$("#"+container_id).append(html);

		values.push(group.id);
		$("#"+genid+"_user_groups").val(values.join());
	}
}

og.removeUserFromUserGroup = function(genid, group_id) {
	var values = $("#"+genid+"_user_groups").val();
	values = values.split(',');
	
	var idx = values.indexOf(group_id.toString());
	if (idx >= 0) {
		values.splice(idx, 1);
		$("#"+genid+"_user_groups").val(values.join());
	}
	$("#"+genid+"user_group_"+group_id).remove();
}