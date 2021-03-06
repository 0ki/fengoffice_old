
// DatePicker Menu
var calToolbarDateMenu = new Ext.menu.DateMenu({
    handler : function(dp, date){
    	dp.setValue(date);
    	changeView(cal_actual_view, date.format('d'), date.format('n'), date.format('Y'), actual_user_filter, actual_state_filter);
    }
});

Ext.apply(calToolbarDateMenu.picker, { 
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

// Actual view
var cal_actual_view = 'viewweek';
// Actual user filter
var actual_user_filter = '0'; // 0=logged user, -1=all users
// Actual state filter
var actual_state_filter = '-1'; // -1=all states

function changeView(action, day, month, year, u_filter, s_filter) {
	var url = og.getUrl('event', action, {
		day: day,
		month: month,
		year: year,
		user_filter: u_filter,
		state_filter: s_filter
	});
	og.openLink(url, null);
}

// Filter by Invitation State
viewActionsState = {
	all: new Ext.Action({
		text: lang('view all'),
		handler: function() {
			actual_state_filter = -1;
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	pending: new Ext.Action({
		iconCls: 'ico-mail-mark-unread',
        text: lang('view pending response'),
		handler: function() {
			actual_state_filter = 0;
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	yes: new Ext.Action({
		iconCls: 'ico-complete',
        text: lang('view will attend'),
		handler: function() {
			actual_state_filter = 1;
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	no: new Ext.Action({
		iconCls: 'ico-delete',
        text: lang('view will not attend'),
		handler: function() {
			actual_state_filter = 2;
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	maybe: new Ext.Action({
		iconCls: 'ico-help',
        text: lang('view maybe attend'),
		handler: function() {
			actual_state_filter = 3;
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	})
};

// Toolbar
og.CalendarToolbarItems = [ 
	new Ext.Action({
		text: lang('add event'),
        tooltip: lang('add new event'),
        iconCls: 'ico-new',
        handler: function() {
        	var date = calToolbarDateMenu.picker.getValue();
			changeView('add', date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	'-',
	new Ext.Action({
		text: lang('month'),
        tooltip: lang('month view'),
        iconCls: 'ico-calendar-month',
        handler: function() {
        	cal_actual_view = 'index';
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	new Ext.Action({
		text: lang('week'),
        tooltip: lang('week view'),
        iconCls: 'ico-calendar-week',
        handler: function() {
			cal_actual_view = 'viewweek';
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	new Ext.Action({
		text: lang('day'),
        tooltip: lang('day view'),
        iconCls: 'ico-today',
        handler: function() {
			cal_actual_view = 'viewdate';
			var date = calToolbarDateMenu.picker.getValue();
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	'-',
	new Ext.Action({
		tooltip: lang('prev'),
        iconCls: 'ico-prevmonth',
        handler: function() {
        	var date = calToolbarDateMenu.picker.getValue();
        	if (cal_actual_view == 'index') date = date.add(Date.MONTH, -1);
        	if (cal_actual_view == 'viewweek') date = date.add(Date.DAY, -7);
        	if (cal_actual_view == 'viewdate') date = date.add(Date.DAY, -1);
        	calToolbarDateMenu.picker.setValue(date);
			
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	new Ext.Action({
		tooltip: lang('next'),
        iconCls: 'ico-nextmonth',
        handler: function() {
        	var date = calToolbarDateMenu.picker.getValue();
        	if (cal_actual_view == 'index') date = date.add(Date.MONTH, 1);
        	if (cal_actual_view == 'viewweek') date = date.add(Date.DAY, 7);
        	if (cal_actual_view == 'viewdate') date = date.add(Date.DAY, 1);
        	calToolbarDateMenu.picker.setValue(date);
			
			changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
		}
	}),
	'-',
	new Ext.Action({
		text: lang('pick a date'),
        tooltip: lang('pick a date'),
        menu: calToolbarDateMenu
	}),
	'-',
	new Ext.Action({
		text: lang('view'),
        iconCls: 'op-ico-view',
        menu: {items: [
        	new Ext.Action({
				text: lang('my calendar'),
		        iconCls: 'ico-calendar',
		        handler: function() {
					actual_user_filter = 0;
					var date = calToolbarDateMenu.picker.getValue();
					changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
				}
			}),
			'-',
        	new Ext.Action({
	        	iconCls: 'op-ico-details',
				text: lang('by state'),
				menu: {items: [
					viewActionsState.pending,
					viewActionsState.yes,
					viewActionsState.no,
					viewActionsState.maybe,
					'-',
					viewActionsState.all
				]}
			}),
			new Ext.Action({
				text: lang('by user'),
	            iconCls: 'ico-user',
				menu: new og.UserMenu({
					listeners: {
						'userselect': {
							fn: function(userid) {
								actual_user_filter = userid;
								var date = calToolbarDateMenu.picker.getValue();
								changeView(cal_actual_view, date.getDate(), date.getMonth() + 1, date.getFullYear(), actual_user_filter, actual_state_filter);
							},
							scope: this
						}
					}
				})
			})
		]}
	})
	
];

