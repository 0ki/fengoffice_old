
og.editMembers = {};
og.editMembers.showHideOptions = function(id, mem_id, show) {
	var el = Ext.get(id);
	if (el) {
		el.dom.style.visibility = show ? 'visible' : 'hidden';
		var container = Ext.get("abm-members-item-container-"+mem_id);
		if (container) {
			container.dom.style.fontWeight = show ? 'bold' : 'normal';
			if (show) container.addClass('dashAltRow');
			else container.removeClass('dashAltRow');
		}
	}
}

og.editMembers.expandCollapseDim = function(id, expand) {
	var el = Ext.get(id);
	if (el) {
		if (expand) el.slideIn('t', {useDisplay:true});
		else el.slideOut('t', {useDisplay:true});

		var exp = Ext.get(id.replace('dimension', 'expander'));
		if (exp) {
			if (expand) exp.replaceClass('toggle_collapsed', 'toggle_expanded');
			else exp.replaceClass('toggle_expanded', 'toggle_collapsed');
			exp.dom.onclick = function() {og.editMembers.expandCollapseDim(id, !expand)};
		}
	}
}


