	og.selectingCells = false;
	og.actualSelCell = '';
	og.selectedCells = [];
	og.paintingDay = 0;
	og.old_style = {'background-color':'transparent', 'opacity':'1', 'filter':'alpha(opacity = 100)'};

	var scroll_to = -1;
	var cant_tips = 0;
	var tips_array = [];
	
	og.eventSelected = function(checked) {
		if (checked) og.events_selected += 1;
		else if (og.events_selected > 0) og.events_selected -= 1;
		var topToolbar = Ext.getCmp('calendarPanelTopToolbarObject');
		if (topToolbar) topToolbar.updateCheckedStatus(og.events_selected);
	}
	
	/*******************************************
		DRAGGING & RESIZING
	*******************************************/

	// month view
	og.monthViewEventDD = Ext.extend(Ext.dd.DDProxy, {
	    startDrag: function(x, y) {
	        var dragEl = Ext.get(this.getDragEl());
	        var el = Ext.get(this.getEl());

	        dragEl.applyStyles({border:'','z-index':2000});
	        dragEl.update(el.dom.innerHTML);
	        if (el.getStyle('background-color') == 'transparent') {
	        	dragEl.setStyle('background-color', '#99CC66');
	        }
	        dragEl.applyStyles('opacity: 0.5; filter: alpha(opacity = 50);');
	    },
		onDragOver: function(e, targetId) {
			var target = Ext.get(targetId);
			if (target) this.lastTarget = target;
		},
		onDragOut: function(e, targetId) {
			var target = Ext.get(targetId);
			if (target) this.lastTarget = target;
	    },
		endDrag: function() {
			date = null;
			for (i=0; i<og.ev_cell_dates.length; i++) {
				if (og.ev_cell_dates[i].key == this.lastTarget.id) {
					date = og.ev_cell_dates[i];
					break;
				}
			}
			if (date != null) {
				var el = Ext.get(this.getEl());
				var parent = Ext.get(date.key);
				parent.appendChild(el);
			
				this.config.dragData.day = date.day;
				this.config.dragData.month = date.month;
				this.config.dragData.year = date.year;
				this.config.fn.apply(this.config.scope || window, [this, this.config.dragData]);
			} else {
				og.err('Invalid grid cell');
			}
		}
	});

	// week and day views
	og.eventDD = Ext.extend(Ext.dd.DDProxy, {
	    startDrag: function(x, y) {
	        var dragEl = Ext.get(this.getDragEl());
	        var el = Ext.get(this.getEl());

	        dragEl.applyStyles({border:'','z-index':2000});
	        dragEl.update(el.dom.innerHTML);
	        dragEl.applyStyles('opacity: 0.5; filter: alpha(opacity = 50);');
	    },
		onDragOver: function(e, targetId) {
			var target = Ext.get(targetId);
			if (target) {
				this.lastTarget = target;
			}
		},
		onDragOut: function(e, targetId) {
			var target = Ext.get(targetId);
			if (target) {
				this.lastTarget = target;
			}
	    },
		endDrag: function() {
			var el = Ext.get(this.getEl());
			if(this.lastTarget) {
				var str_temp = this.lastTarget.id.split	('_');
				isAllDay = (this.lastTarget.id.indexOf('alldayeventowner_') >= 0) || (this.lastTarget.id.indexOf('alldaycelltitle_') >= 0);
				if (isAllDay) {
					var parent = Ext.get('alldayeventowner_'+str_temp[1]);
					parent.appendChild(el);
					og.reorganizeAllDayGrid();
				} else {
					var grid = Ext.get('grid');
					var parent = Ext.get('eventowner');
					
					var lt = Ext.get(this.lastTarget);
					var top = lt.getTop() - parent.getTop();
					var left = 100 * (lt.getLeft() - parent.getLeft() + 3) / grid.getWidth();
					
					el.applyStyles('top:'+top+'px;left:'+left+'%;');				
					parent.appendChild(el);
					
					/*var cont = Ext.get('gridcontainer');
					if (cont.getTop() + cont.getHeight() < el.getTop() + el.getHeight()) {
						style = 'height:'+ (cont.getTop() + cont.getHeight() - el.getTop() - 1) +'px';
						el.applyStyles(style);
						Ext.get(this.getDragEl()).update(el.dom.innerHTML);
					}*/
				}	
				if(this.config.fn && 'function' === typeof this.config.fn) {
					if (isAllDay) {
						date = og.ev_cell_dates[str_temp[1]];
					} else {
						date = og.ev_cell_dates[str_temp[0].substr(1)];
					}
					if (date) {
						this.config.dragData.day = date.day;
						this.config.dragData.month = date.month;
						this.config.dragData.year = date.year;
						if (!isAllDay) {
							this.config.dragData.hour = Math.floor(str_temp[1] / 2);
							this.config.dragData.min = (str_temp[1] % 2 == 0 ? 0 : 30);
						}
						
						this.config.fn.apply(this.config.scope || window, [this, this.config.dragData]);
					} else {
						og.err('Invalid grid cell');
					}
				}
			}
		}
		
	});
	
	og.createEventDrag = function(div_id, obj_id, type, isAllday, dropzone) {
		var obj_div = Ext.get(div_id);
		
		obj_div.dd = new og.eventDD(div_id, dropzone, {
			dragData: {id: obj_id},
			scope: this,
			isTarget:false,
			fn: function(dd, ddata) {
				switch (type) {
					case 'event':
						if (isAllday) {
							ddata.hour = -1;
							ddata.min = -1;
						}
						og.openLink(og.getUrl('event', 'move_event', {id:ddata.id, year:ddata.year, month:ddata.month, day:ddata.day, hour:ddata.hour, min:ddata.min}), {
							callback: function(success, data) {
								if (!isAllday) {
									updateTip(div_id, data.ev_data.subject, data.ev_data.start + " - " + data.ev_data.end);
									var els = [];
									if (Ext.isIE) {
										var spans = document.getElementsByTagName('span');
										for(var i=0; i<spans.length; i++){
											if(spans.item(i).getAttribute('name') == div_id+'_info'){
										    	els.push(spans.item(i));
											}
										}
									} else els = document.getElementsByName(div_id+'_info');

									if (els.length > 0) {									
										for (i=0; i<els.length; i++) {
											els[i].innerHTML = data.ev_data.start + (cal_actual_view == 'viewweek' ? "" : " - " + data.ev_data.end);												
										}
									}
								}
							}
						});
						break;
					case 'milestone':
						og.openLink(og.getUrl('milestone', 'change_due_date', {id:ddata.id, year:ddata.year, month:ddata.month, day:ddata.day}), {});
						break;
					case 'task':
						var d_to_change = (div_id.indexOf('_end_') != -1 ? 'due' : (div_id.indexOf('_st_') != -1  ? 'start' : 'both'));
						og.openLink(og.getUrl('task', 'change_start_due_date', {id:ddata.id, year:ddata.year, month:ddata.month, day:ddata.day, tochange:d_to_change}), {});
						break;
					default: break;
				}
			}
		});
	}
	
	og.createMonthlyViewDrag = function(div_id, obj_id, type) {
		var obj_div = Ext.get(div_id);
		obj_div.dd = new og.monthViewEventDD(div_id, 'ev_dropzone', {
			dragData: {id: obj_id},
			scope: this,
			isTarget:false,
			fn: function(dd, ddata) {
				switch (type) {
					case 'event':
						og.openLink(og.getUrl('event', 'move_event', {id:ddata.id, year:ddata.year, month:ddata.month, day:ddata.day, hour:-1, min:-1}), {});
						break;
					case 'milestone':
						og.openLink(og.getUrl('milestone', 'change_due_date', {id:ddata.id, year:ddata.year, month:ddata.month, day:ddata.day, hour:-1, min:-1}), {});
						break;
					case 'task':
						var d_to_change = (div_id.indexOf('_end_') != -1  ? 'due' : (div_id.indexOf('_st_') != -1  ? 'start' : 'both'));
						og.openLink(og.getUrl('task', 'change_start_due_date', {id:ddata.id, year:ddata.year, month:ddata.month, day:ddata.day, hour:-1, min:-1, tochange:d_to_change}), {});
						break;
					default: break;
				}
			}
		});
	}
	
	
	og.setResizableEvent = function(div_id, ev_id) {
		var resizer = new Ext.Resizable(div_id, {
		    adjustments: [0,-4],
		    handles: 's',
		    heightIncrement: 21,
		    resizeChild: 'inner_' + div_id,
		    pinned: true
		});
		resizer.on('resize', function(){
			el = resizer.getEl();
			var grid = Ext.get('grid');
			width = 100 * el.getWidth() / grid.getWidth();
			el.applyStyles('width:'+width+'%;');
							
			rows = el.getHeight() / 21;
			dur_h = Math.floor(rows / 2);
			dur_m = rows % 2 == 0 ? 0 : 30;
			og.openLink(og.getUrl('event', 'change_duration', {id:ev_id, hours:dur_h, mins:dur_m}), {
				callback: function(success, data) {
					ev_data = data.ev_data;
					updateTip(div_id, ev_data.subject, ev_data.start + " - " + ev_data.end);
				}
			});
		});
	}
	
	og.reorganizeAllDayGrid = function() {
		var container = Ext.get('allDayGrid');
		var max_height = 0;
		for (i=0; i<6; i++) {
			var parent = Ext.get('alldayeventowner_' + i);
			if (parent != null) {
				var obj = parent.first();
				var top = 5;
				while (obj) {
					obj.applyStyles('top:'+top+'px;');
					top += 21;
					obj = obj.next();
				}
				if (top > max_height) max_height = top;
			}
		}
		if (max_height > 0) {
			max_height += 16;
			container.applyStyles('height:'+max_height+'px;');
			for (i=0; i<6; i++) {
				var parent = Ext.get('alldayeventowner_' + i);
				if (parent != null) 
					parent.applyStyles('height:'+max_height+'px;');
			}
		}
	}

	/*******************************************
		END DRAGGING & RESIZING
	*******************************************/
	
	addTipToArray = function(pos, div_id, title, bdy) {
		tips_array[pos] = new Ext.ToolTip({
			target: div_id,
	        html: bdy,
	        title: title,
	        hideDelay: 1500,
	        closable: true
		});
	}
	
	addTip = function(div_id, title, bdy) {
		addTipToArray(cant_tips++, div_id, title, bdy);
	}
	
	updateTip = function(div_id, title, body) {
		for (i=0; i<cant_tips; i++) {
			tip = tips_array[i];
			if (tip && tip.target.id == div_id) {
				tip.disable();
				addTipToArray(i, div_id, title, body);				
				break;
			}
		}
	}
	
	og.change_link_incws = function(hrefid, checkid) {
		var link = document.getElementById(hrefid).href
		if (document.getElementById(checkid).checked) { 
			document.getElementById(hrefid).href = link.replace('isw=0', 'isw=1');
		} else {
			document.getElementById(hrefid).href = link.replace('isw=1', 'isw=0');
		}
	}
	
	og.overCell = function(cell_id) {
		var ele = Ext.get(cell_id);
		if (!og.selectingCells) og.old_style = ele.getStyles('background-color', 'opacity', 'filter');
		ele.applyStyles({'background-color':'#D3E9FF', 'opacity':'1', 'filter':'alpha(opacity = 100)'});
	}
	
	og.resetCell = function(cell_id) {
		var ele = Ext.get(cell_id);
		ele.applyStyles(og.old_style);
	}
	
	og.minSelectedCell = function() {
		min_val = 99;
		for (i=0; i<og.selectedCells.length; i++) {
			if (og.selectedCells[i] != '') {
				str_temp = og.selectedCells[i].split('_');
				min_val = parseInt(str_temp[1]) < min_val ? parseInt(str_temp[1]) : min_val;
			}
		}
		return min_val;
	}
	
	og.paintSelectedCells = function(cell_id) {
		str_temp = cell_id.split('_');
		cell_id = 'h' + og.paintingDay + '_' + str_temp[1];

		if (og.selectingCells && og.actualSelCell != cell_id) {
			for (i=0; i<og.selectedCells.length; i++) {
				curr_split = og.selectedCells[i].split('_');
				if (parseInt(curr_split[1]) > parseInt(str_temp[1])/*cell_id*/) {
					og.resetCell(og.selectedCells[i]);
					og.selectedCells[i] = '';
				}
			}
		
			i = og.minSelectedCell();
			if (i == 99) i = str_temp[1];
			do {
				temp_cell = 'h' + og.paintingDay + '_' + i;
				og.overCell(temp_cell);
				og.selectedCells[og.selectedCells.length] = temp_cell;
				i++;
			} while (temp_cell != cell_id && i < 48);
			og.actualSelCell = cell_id;
		}
	}
	
	og.clearPaintedCells = function() {
		for (i=0; i<og.selectedCells.length; i++) {
			if (og.selectedCells[i] != '') og.resetCell(og.selectedCells[i]);
		}
		og.selectedCells = [];
		og.selectingCells = false;
		og.actualSelCell = '';
	}
	
	// hour range selection
	var ev_start_day, ev_start_month, ev_start_year, ev_start_hour, ev_start_minute;
	var ev_end_day, ev_end_month, ev_end_year, ev_end_hour, ev_end_minute;
	
	og.selectStartDateTime = function(day, month, year, hour, minute) {
		og.selectingCells = true;
		og.selectDateTime(true, day, month, year, hour, minute);
	}
	
	og.selectEndDateTime = function(day, month, year, hour, minute) {
		og.selectDateTime(false, day, month, year, hour, minute);
	}
	
	og.selectDateTime = function(start, day, month, year, hour, minute) {
		if (start == true) {
			ev_start_day = day;
			ev_start_month = month; 
			ev_start_year = year; 
			ev_start_hour= hour; 
			ev_start_minute = minute; 
		} else {
			ev_end_day = day; 
			ev_end_month = month; 
			ev_end_year = year; 
			ev_end_hour = hour; 
			ev_end_minute = minute; 
		}
		
	}
	
	og.setSelectedStartTime = function() {
		min_val = og.minSelectedCell();
		ev_start_hour = Math.floor(min_val / 2);
		ev_start_minute = (min_val % 2 == 0) ? 0 : 30;
	}
	
	og.getDurationMinutes = function() {
		og.setSelectedStartTime();
		
		var s_val = new Date();
		s_val.setFullYear(ev_start_year);
		s_val.setMonth(ev_start_month);
		s_val.setDate(ev_start_day);
		s_val.setHours(ev_start_hour);
		s_val.setMinutes(ev_start_minute);
		s_val.setSeconds(0);
		s_val.setMilliseconds(0);
		
		var e_val = new Date();
		e_val.setFullYear(ev_start_year);
		e_val.setMonth(ev_start_month);
		e_val.setDate(ev_start_day);
		e_val.setHours(ev_end_hour);
		e_val.setMinutes(ev_end_minute);
		e_val.setSeconds(0);
		e_val.setMilliseconds(0);
		
		if (ev_end_hour == 0) e_val.setDate(e_val.getDate() + 1);
		
		var millis = e_val.getTime() - s_val.getTime();
		
		return ((millis / 1000) / 60); 		
	}
	
	og.showEventPopup = function(day, month, year, hour, minute, use_24hr, st_val) {
		var typeid = 1, hrs = 1, mins = 0;
		if (hour == -1 || minute == -1) {
			hour = 0;
			minute = 0;
			typeid = 2;
			ev_start_hour = ev_start_minute = durationhour = durationmin = 0;
			ev_start_day = day;
			ev_start_month = month;
			ev_start_year = year;
		} else {
			og.selectEndDateTime(day, month, year, hour, minute);
			hrs = 0;
			mins = og.getDurationMinutes();
			while (mins >= 60) {
				mins -= 60;
				hrs +=1;
			}
			if (hrs == 0) {
				hrs = 1;
				mins = 0;
			}
		}
		
		if (use_24hr) {
			st_hour = ev_start_hour;
			ampm = '';
		} else {
			if (ev_start_hour >= 12) {
				st_hour = ev_start_hour - (ev_start_hour > 12 ? 12 : 0);
				ampm = ' PM';
			} else {
				if (ev_start_hour == 0) st_hour = 12;
				else st_hour = ev_start_hour;
				ampm = ' AM';
			}
		}
		st_time = st_hour + ':' + ev_start_minute + (ev_start_minute < 10 ? '0' : '') + ampm;
		
		og.EventPopUp.show(null, {day: ev_start_day,
								month: ev_start_month,
								year: ev_start_year,
								hour: ev_start_hour,
								minute: ev_start_minute,
								durationhour: hrs,
								durationmin: mins,
								start_value: st_val,
								start_time: st_time,
								type_id: typeid,
								view:'week', 
								title: lang('add event'),
								time_format: use_24hr ? 'G:i' : 'g:i A',
								hide_calendar_toolbar: 1
								}, '');
		og.clearPaintedCells();								
	}