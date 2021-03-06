og.pluginManager = {} ;

og.pluginManager.init = function () {

	$(".deactivate-button").click(function(){
		var button = this ;
		var url = og.getUrl('plugin', 'deactivate', {ajax:'true'});
		var id = $(this).parent().parent().parent().parent().attr('id');
		data = {"id": id, "ajax": 'true'};
		$(button).parents("tr").addClass("loading-indicator");

		Ext.Ajax.request({
            method: 'POST',
            params :data,
			url: url,
			callback: function(options, success, response) {
				$(button).parents("tr").removeClass("loading-indicator");

				try {
					var jsonData = Ext.util.JSON.decode(response.responseText);
				} catch (e){
					$(".error").html(response.responseText).fadeIn();
					return ;
				}
				$(button).parent().hide().parent().find(".activate , .uninstall").show();
				
				
				var ct = $(button).parents(".active");
				ct.removeClass("active").addClass("inactive");
				ct.find(".activate , .uninstall").show();
				ct.find(".deactivate").hide();
				
				
				$(".error").html("").hide();
			}
		});
	});
	
	$(".activate-button").click(function(){
		var button = this ;
		$(button).parents("tr").addClass("loading-indicator");

		var url = og.getUrl('plugin', 'activate', {ajax:'true'});
		var id = $(this).parent().parent().parent().parent().attr('id');
		data = {"id": id, "ajax": 'true'};
		Ext.Ajax.request({
			method: 'POST',
			params :data,
			url: url,
			callback: function(options, success, response) {
				$(button).parents("tr").removeClass("loading-indicator");

				try {
					var jsonData = Ext.util.JSON.decode(response.responseText);
				} catch (e){
					$(".error").html(response.responseText).fadeIn();
					return ;
				}
				
				var ct = $(button).parents(".inactive");
				ct.removeClass("inactive").addClass("active");
				ct.find(".activate ,  .uninstall").hide();
				ct.find(".deactivate").show();
				$(".contextualHelp.reload").fadeIn();
				$(".error").html("").hide();
			}
		});
	});
	

	$(".install-button").click(function(){
		var button = this ;
		$(button).parents("tr").addClass("loading-indicator");
		var url = og.getUrl('plugin', 'install', {ajax:'true'});
		var id = $(this).parent().parent().parent().parent().attr('id');
		data = {"id": id, "ajax": 'true'};
		Ext.Ajax.request({
            method: 'POST',
            params :data,
			url: url,
			callback: function(options, success, response) {
				$(button).parents("tr").removeClass("loading-indicator");
				try {
					var jsonData = Ext.util.JSON.decode(response.responseText);
				} catch (e){
					$(".error").html(response.responseText).fadeIn();
					return ;
				}
				$(button).parent().hide().parent().find(".uninstall , .activate").show();
				$(".contextualHelp.reload").fadeIn();
				$(".error").html("").hide();

				
			}
		});
	});
	
	
	$(".uninstall-button").click(function(){
		var button = this ;
		$(button).parents("tr").addClass("loading-indicator");

		var url = og.getUrl('plugin', 'uninstall', {ajax:'true'});
		var id = $(this).parent().parent().parent().parent().attr('id');
		data = {"id": id, "ajax": 'true'};
		Ext.Ajax.request({
			method: 'POST',
			params :data,
			url: url,
			callback: function(options, success, response) {
				$(button).parents("tr").removeClass("loading-indicator");

				try {
					var jsonData = Ext.util.JSON.decode(response.responseText);
				} catch (e){
					$(".error").html(response.responseText).fadeIn();
					return ;
				}
				$(button).parent().hide().parent().find(".install").show().parent().find(".activate").hide();
				$(".contextualHelp.reload").fadeIn();
				$(".error").html("").hide();
				
				
			}
		});
	});

}
