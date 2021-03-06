og.reports = {};
og.reports.createPrintWindow = function(title) {
	var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,scrollbars=yes,";
	var printWindow = window.open("","",disp_setting);
	
	printWindow.document.open(); 
	printWindow.document.write('<html><head><title>' + title + '</title>');
	printWindow.document.write('<link href="' + og.hostName + '/public/assets/themes/default/stylesheets/website.css" rel="stylesheet" type="text/css">');
	printWindow.document.write('<link href="' + og.hostName + '/public/assets/themes/default/stylesheets/general/rewrites.css" rel="stylesheet" type="text/css">');
	printWindow.document.write('</head><body onLoad="self.print()" id="body" style="padding:10px;">');
	printWindow.document.write(og.reports.buildReportHeader(title));
	return printWindow;
}

og.reports.buildReportHeader = function(title) {
	var html = '<div class="report-print-header"><div class="title-container"><h1>' + title + '</h1></div>';
	html += '<div class="company-info">';
	if (og.ownerCompany.logo_url) {
		html += '<div class="logo-container"><img src="'+og.ownerCompany.logo_url+'"/></div>';
	} else {
		html += '<div class="comp-name-container">'+ og.ownerCompany.name +'</div><br />';
	}
	if (og.ownerCompany.address) {
		html += '<div class="address-container">'+og.ownerCompany.address+'</div>';
		html += '<br />';
	}
	if (og.ownerCompany.email) {
		html += '<div class="email-container link-ico ico-email">'+og.ownerCompany.email+'</div>';
	}
	if (og.ownerCompany.phone) {
		html += '<div class="phone-container link-ico ico-phone">'+og.ownerCompany.phone+'</div>';
	}
	html += '</div></div>';
	html += '<div class="clear"></div>';

	return html;
}

og.reports.closePrintWindow = function(printWindow) {
	printWindow.document.write('</body></html>');    
	printWindow.document.close();
	printWindow.focus();
}

og.reports.printReport = function(genid, title, report_id) {
	
	var str = $("#post"+genid).val();
	str = str.replace(/'/ig, '"');
	var params = $.parseJSON(str);
	delete params.c;
	delete params.a;
	
	og.openLink(og.getUrl('reporting', 'print_custom_report', params), {
		callback: function(success, data) {
			var printWindow = og.reports.createPrintWindow(title);
			printWindow.document.write(data.html);
			og.reports.closePrintWindow(printWindow);
		}
	});
}

og.reports.printNoPaginatedReport = function(genid, title) {
	var printWindow = og.reports.createPrintWindow(title);

	printWindow.document.write(document.getElementById(genid + 'report_container').innerHTML);
	
	og.reports.closePrintWindow(printWindow);
}


og.reports.go_to_custom_report_page = function(params) {
	var offset = params.offset;
	var limit = params.limit;
	var link = params.link;
	if (!offset) offset = 0;
	if (!limit) limit = 50;
	if (!link) return;

	var report_config_el = $(params.link).closest("form").children("[name='post']");
	if (!report_config_el || report_config_el.length == 0) return;

	var str = $(report_config_el[0]).val();
	str = str.replace(/'/ig, '"');

	// initial parameters
	var report_config = $.parseJSON(str);

	// fixed parameters
	report_config.offset = offset;
	report_config.limit = limit;
	report_config.replace = 1;

	og.openLink(og.getUrl(report_config.c, report_config.a, report_config));
	
}