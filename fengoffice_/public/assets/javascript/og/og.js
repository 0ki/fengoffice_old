var og = {};

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
	m.slideIn('t').pause(1).ghost("t", {remove:true});
}

og.toggle = function(id, btn) {
	var obj = Ext.getDom(id);
	if (obj.style.display == 'block') {
		obj.style.display = 'none';
		if (btn) btn.className = 'toggle_collapsed';
	} else {
		obj.style.display = 'block';
		if (btn) btn.className = 'toggle_expanded';
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

og.submit = function(form) {
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
	function endSubmit() {
		this.loadingIndicator.style.visibility = 'hidden';
		var doc;
		if (Ext.isIE) {
			doc = this.contentWindow.document;
		} else {
			doc = (this.contentDocument || window.frames[id].document);
		}
		var json = doc.body.innerHTML.trim();
		if (json) {
			var o = Ext.util.JSON.decode(json);
			if (o.success) {
				og.msg(lang('success'), o.error);
				if (o.forward) {
					og.openLink(o.forward.replace(/&amp;/g, "&"));
				}
			} else {
				og.msg(lang('error'), o.error);
			}
		} else {
			og.msg(lang('error'), lang('unexpected server response'));
		}
		setTimeout(function(){Ext.removeNode(frame);}, 100);
	}
	Ext.EventManager.on(frame, 'load', endSubmit, frame);;
	
	form.target = frame.name;
	var div;
	if (!div) {
		div = document.createElement('div');
		div.innerHTML = lang('uploading file');
		div.className = 'loading-indicator';
		div.style.position = 'absolute';
		div.style.top = '0';
		div.style.left = '45%';
		document.body.appendChild(div);
	}
	div.style.visibility = 'visible';
	frame.loadingIndicator = div;
	form.submit();
	return false;
}

og.makeAjaxUrl = function(url) {
	var q = url.indexOf('?');
	var n = url.indexOf('#');
	if (q < 0) {
		if (n < 0) {
			return url + "?ajax=true";
		} else {
			return url.substring(0, n) + "?ajax=true" + url.substring(n);
		}
	} else {
		return url.substring(0, q + 1) + "ajax=true&" + url.substring(q + 1);
	}
}