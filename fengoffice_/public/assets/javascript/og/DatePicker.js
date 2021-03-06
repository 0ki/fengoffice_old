og.DatePicker = function(config) {
	Ext.apply(this, config, {
		minDate: new Date(1970, 0, 1), // 1/1/1970
		maxDate: new Date(2100, 0, 1), // 1/1/2100
		startDate: new Date()
	});
	var div = document.createElement('div');
	div.className = 'og-date-picker';
	
	//year
	var dropyear = document.createElement('select');
	dropyear.className = 'og-date-picker-year';
	for (var i=this.minDate.getFullYear(); i < this.maxDate.getFullYear(); i++) {
		var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i;
		if (i == this.startDate.getFullYear()) {
			opt.selected = "selected";
		}
		dropyear.appendChild(opt);
	}
	dropyear.datePicker = this;
	dropyear.onchange = function() {
		this.datePicker.setYear(this.value);
	};
	div.appendChild(dropyear);
	
	// month
	var dropmonth = document.createElement('select');
	dropmonth.className = 'og-date-picker-month';
	for (var i=0; i < 12; i++) {
		var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i+1;
		if (i == this.startDate.getMonth()) {
			opt.selected = "selected";
		}
		dropmonth.appendChild(opt);
	}
	dropmonth.datePicker = this;
	dropmonth.onchange = function() {
		this.datePicker.setMonth(this.value);
	};
	div.appendChild(dropmonth);
	
	// day
	var dropday = document.createElement('select');
	dropday.className = 'og-date-picker-day';
	for (var i=1; i <= this.startDate.getDaysInMonth(); i++) {
		var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i;
		if (i == this.startDate.getDate()) {
			opt.selected = "selected";
		}
		dropday.appendChild(opt);
	}
	dropday.datePicker = this;
	dropday.onchange = function() {
		this.datePicker.setDay(this.value);
	};
	div.appendChild(dropday);
	
	this.date = this.startDate;
	this.dom = this.el = div;
	this.dropyear = dropyear;
	this.dropmonth = dropmonth;
	this.dropday = dropday;
};

og.DatePicker.prototype = {

	getValue: function() {
		return this.date;
	},
	
	setYear: function(year) {
		this.dropyear.value = year;
		
		var aux = new Date(year, this.date.getMonth(), 1);

		this.date = new Date(year, this.dropmonth.value, Math.min(aux.getDaysInMonth(), this.dropday.value));
	},
	
	setMonth: function(month) {
		this.dropmonth.value = month;
		
		var aux = new Date(this.date.getFullYear(), month, 1);

		this.date = new Date(this.date.getFullYear(), month, Math.min(aux.getDaysInMonth(), this.dropday.value));
	},
	
	setDay: function(day) {
		this.dropday.value = day;
		
		this.date = new Date(this.date.getFullYear(), this.date.getMonth(), day);
	},
	
	setDate: function(date) {
		this.date = date;
		this.dropyear.value = date.getFullYear();
		this.dropmonth.value = date.getMonth();
		this.dropdya.value = date.getDate();
	}

};