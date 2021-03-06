<div class=" dashboard-container view-container">
	<div class="section-top">
		<?php DashboardTools::renderSection('top'); ?>	
	</div> 
	<div class="layout-container" >
		
		<div class="left-column-wrapper">
			<div class="left-column section-left">
				<?php DashboardTools::renderSection('left'); ?>		
            </div>
		</div>
		
		<div class="right-column section-right">
			<?php DashboardTools::renderSection('right'); ?>		
		</div>
	</div>
	<div class="x-clear" ></div>
</div>
<script>
$(function(){
	var div = document.getElementById('breadcrumbs');
	if (div && div.innerHTML == '') {
		og.Breadcrumbs.init('<?php echo lang("viewing all information") ?>');
	}
})
</script>
