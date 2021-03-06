og.RowExpander = function(config) {
	Ext.apply(this, config);

	this.addEvents({
		beforeexpand: true,
	    expand: true,
	    beforecollapse: true,
		collapse: true
	});

	og.RowExpander.superclass.constructor.call(this);

	if (this.tpl) {
		if (typeof this.tpl == 'string') {
			this.tpl = new Ext.Template(this.tpl);
		}
		this.tpl.compile();
	}

	this.state = {};
	this.bodyContent = {};
};

Ext.extend(og.RowExpander, Ext.util.Observable, {
	header: "",
	width: 20,
	sortable: false,
	fixed: true,
	menuDisabled: true,
	dataIndex: '',
	id: 'expander',
	lazyRender: true,
	enableCaching: true,

	getRowClass: function(record, rowIndex, p, ds) {
		p.cols = p.cols-1;
		var content = this.bodyContent[record.id];
		if (!content && !this.lazyRender) {
			content = this.getBodyContent(record, rowIndex);
		}
		if (content) {
			p.body = content;
		}
		return this.state[record.id] ? 'x-grid3-row-expanded' : 'x-grid3-row-collapsed';
	},

	init: function(grid) {
		this.grid = grid;
		
		var view = grid.getView();
		view.getRowClass = this.getRowClass.createDelegate(this);
		
		//view.enableRowBody = true;
		
		grid.on('render', function() {
			view.mainBody.on('mousedown', this.onMouseDown, this);
		}, this);
	},

	getBodyContent: function(record, index) {
		if (!this.enableCaching) {
			return this.tpl.apply(record.data);
		}
		var content = this.bodyContent[record.id];
		if (!content) {
			content = this.tpl.apply(record.data);
			this.bodyContent[record.id] = content;
		}
		return content;
	},

	onMouseDown: function(e, t) {
		if (t.className == 'x-grid3-row-expander') {
			e.stopEvent();
			var row = e.getTarget('.x-grid3-row');
			this.toggleRow(row);
		}
	},

	renderer: function(v, p, record) {
		return '<div class="x-grid3-row-expander">&#160;</div>';
	},

	beforeExpand: function(record, body, rowIndex) {
		if (this.fireEvent('beforeexpand', this, record, body, rowIndex) !== false) {
			if (this.tpl && this.lazyRender) {
				body.innerHTML = this.getBodyContent(record, rowIndex);
			}
			return true;
		} else {
			return false;
		}
	},

	toggleRow: function(row) {
		if (typeof row == 'number') {
			row = this.grid.view.getRow(row);
		}
		this[Ext.fly(row).hasClass('x-grid3-row-collapsed') ? 'expandRow' : 'collapseRow'](row);
	},

	expandRow : function(row) {
		if(typeof row == 'number'){
			row = this.grid.view.getRow(row);
		}
		var record = this.grid.store.getAt(row.rowIndex);
		var tr1 = Ext.DomQuery.selectNode('tr:nth(1)', row);
		var tr2 = Ext.DomQuery.selectNode('tr:nth(2)', row);
		if (!tr2) {
			// cargar sub tareas
			var count = 0;
			var elem = tr1.firstChild;
			while (elem) {
				if (elem.tagName && elem.tagName == 'TD') {
					count++;
				}
				elem = elem.nextSibling;
			}
			var tr2 = document.createElement('TR');
			var td = document.createElement('TD');
			td.colspan = count;
			td.innerHTML = 'Loading...';
			tr2.appendChild(td);
			tr1.parentNode.appendChild(tr2);
			og.openLink(og.getUrl('task', 'list_tasks', {ajax:true}), {
				callback: function(success, data) {
					if (success) {
						tr1.parentNode.removeChild(tr2);
						for (var i=0; i < data.objects.length; i++) {
							var task = data.objects[i];
							var elem = tr1.firstChild;
							var tr = document.createElement('TR');
							while (elem) {
								if (elem.tagName && elem.tagName == 'TD') {
									var splitString = 'x-grid3-td-';
									var index = elem.className.indexOf(splitString);
									var colName = elem.className.substring(index + splitString.length());
									colName = colName.substring(0, colName.indexOf(' '));
									alert(colName);
									var td = document.createElement('TD');
									td.innerHTML = task[colName];
									tr.appendChild(td);
								}
								elem = elem.nextSibling;
							}
							tr1.parentNode.appendChild(tr);
						}
					} else {
						td.innerHTML = "Error";
					}
				}
			});
		}
		tr2.style.display = tr1.style.display;

		this.state[record.id] = true;
		Ext.fly(row).replaceClass('x-grid3-row-collapsed', 'x-grid3-row-expanded');
	},

	collapseRow : function(row) {
		if (typeof row == 'number') {
			row = this.grid.view.getRow(row);
		}
		var record = this.grid.store.getAt(row.rowIndex);
		var tr2 = Ext.fly(row).child('tr:nth(2)', true);
		if (tr2) {
			tr2.style.display = 'none';
		}

		this.state[record.id] = false;
		Ext.fly(row).replaceClass('x-grid3-row-expanded', 'x-grid3-row-collapsed');
	}
});
