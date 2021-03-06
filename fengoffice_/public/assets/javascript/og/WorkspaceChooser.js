/**
 *  config options:
 *  	ws: array of workspaces {id, name, selected}
 *  	el: id of the element where to render the control
 *  	name: control name
 *  	id: control id
 */
og.WorkspaceChooser = function(config) {
	this.el = document.getElementById(config.el);
	this.el.className = this.el.className + " og-wschooser";
	
	this.wsList = document.createElement('select');
	this.wsList.multiple = "multiple";
	
	this.selList = document.createElement('select');
	this.selList.multiple = "multiple";
	
	var csv = '';
	for (var i=0; i < config.ws.length; i++) {
		var ws = config.ws[i];
		var opt = document.createElement('option');
		opt.innerHTML = ws.name;
		opt.value = ws.id;
		if (ws.selected) {
			this.selList.appendChild(opt);
			if (csv != '') csv += ',';
			csv += ws.id;
		} else {
			this.wsList.appendChild(opt);
		}
	}

	this.val = document.createElement('input');
	this.val.type = 'hidden';
	this.val.id = config.id;
	this.val.name = config.name;
	this.val.value = csv;
	
	this.btAdd = document.createElement('button');
	this.btAdd.onclick = this.addWS.createDelegate(this);
	this.btAdd.innerHTML = '&gt;&gt;';
	
	this.btDel = document.createElement('button');
	this.btDel.onclick = this.delWS.createDelegate(this);
	this.btDel.innerHTML = '&lt;&lt;';
	
	var t = document.createElement('table');
	var tb = document.createElement('tbody');
	t.appendChild(tb);
	var trh = document.createElement('tr');
	tb.appendChild(trh);
	var th1 = document.createElement('th');
	th1.innerHTML = lang('wschooser desc from') + ":";
	var th2 = document.createElement('th');
	var th3 = document.createElement('th');
	th3.innerHTML = lang('wschooser desc to') + ":";
	trh.appendChild(th1);
	trh.appendChild(th2);
	trh.appendChild(th3);
	var tr = document.createElement('tr');
	tb.appendChild(tr);
	var td1 = document.createElement('td');
	td1.className = 'wschooser-from';
	td1.appendChild(this.wsList);
	var td2 = document.createElement('td');
	td2.className = 'wschooser-buttons';
	td2.appendChild(this.btAdd);
	td2.appendChild(document.createElement('br'));
	td2.appendChild(this.btDel);
	var td3 = document.createElement('td');
	td3.className = 'wschooser-to';
	td3.appendChild(this.selList);
	tr.appendChild(td1);
	tr.appendChild(td2);
	tr.appendChild(td3);
	this.el.appendChild(t);
	this.el.appendChild(this.val);
};

og.WorkspaceChooser.prototype = {
	addWS: function() {
		for (var i=0; i < this.wsList.options.length; i++) {
			var opt = this.wsList.options[i];
			if (opt.selected) {
				this.wsList.removeChild(opt);
				this.selList.appendChild(opt);
				i--;
			}
		}
		this.updateVal();
		return false;
	},
	delWS: function() {
		for (var i=0; i < this.selList.options.length; i++) {
			var opt = this.selList.options[i];
			if (opt.selected) {
				this.selList.removeChild(opt);
				this.wsList.appendChild(opt);
				i--;
			}
		}
		this.updateVal();
		return false;
	},
	updateVal: function() {
		this.val.value = "";
		for (var i=0; i < this.selList.options.length; i++) {
			var opt = this.selList.options[i];
			if (this.val.value != "") 
				this.val.value += ",";
			this.val.value += opt.value;
		}
	}
};

