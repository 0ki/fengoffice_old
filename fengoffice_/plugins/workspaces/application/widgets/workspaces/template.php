<?php 
$members = implode (',', active_context_members(false));
$ws_dim = Dimensions::findByCode('workspaces');
$row_cls = "";
?>

<div class="ws-widget widget">

	<div class="widget-header" onclick="og.dashExpand('<?php echo $genid?>');">
		<?php echo lang('workspaces')?>
		<div class="dash-expander ico-dash-expanded" id="<?php echo $genid; ?>expander"></div>
	</div>
	
	<div class="widget-body" id="<?php echo $genid; ?>_widget_body" >
	
	<?php if (isset($data_ws) && $data_ws && count($data_ws) > 0) : ?>
		<div class="project-list">
		<?php foreach($data_ws as $ws):?>
			<div class="workspace-row-container <?php echo $row_cls ?>">
				<a class="internalLink" href="javascript:void(0);" onclick="og.workspaces.onWorkspaceClick(<?php echo $ws->getId() ?>);">
					<img class="ico-color<?php echo $ws->getMemberColor() ?>" unselectable="on" src="s.gif"/>
					<?php echo $ws->getName() ?>
				</a>		
			</div>
			<div class="x-clear"></div>
			<?php $row_cls = $row_cls == "" ? "dashAltRow" : ""; ?>
		<?php endforeach;?>
		</div>
		
		<?php if ($total <= count ($workspaces)) : ?>
			<div class="view-all-container">
				<a href="javascript:og.customDashboard('member', 'init', {},true)" ><?php echo lang('view all');?></a>
			</div>
			<div class="clear"></div>
		<?php endif ;?>
		
		<div class="x-clear"></div>
		
	<?php endif; ?>
	
	<?php if (can_manage_dimension_members(logged_user())) : ?>
		<?php if (count($data_ws) > 0) : ?>
			<div class="separator"></div>
		<?php endif; ?>
		<label><?php echo lang('add workspace')?></label>
		<input type="text" class="ws-name" />
		<button class="submit-ws" ><?php echo lang('add')?></button>
		<a class="ws-more-details coViewAction ico-edit" href="#" onclick="return false;" ><?php echo lang("details")?></a>
	
	<?php endif; ?>

	</div>
</div>


<script>
	$(function(){
		$("button.submit-ws").click(function(){
			var container = $(this).closest(".widget-body") ;
			container.closest(".widget-body").addClass("loading");
			
			var name = $(container).find("input.ws-name").val();

			if (name) {
				og.quickAddWs({
					name: name,
					parent: '<?php echo $members?>',
					dim_id: '<?php echo $ws_dim->getId()?>',
					ot_id: '<?php echo Workspaces::instance()->getObjectTypeId()?>'
				},function(){
					og.customDashboard('dashboard', 'main_dashboard',{},true);
				});
				
			}else{
				og.err('<?php echo lang('error add name required', lang('workspace'))?>');
				$(container).find("input.ws-name").focus();
				container.removeClass("loading");
			}	
			
		});


		$(".ws-widget .ws-name").keypress(function(e){
			if(e.keyCode == 13){
				$("button.submit-ws").click();
     		}
		});


		$(".ws-widget a.ws-more-details").click(function(){
			var container = $(this).closest(".widget-body");
			var name = $(container).find("input.ws-name").val();
			
			og.openLink(og.getUrl('member','add'),{
				get: {
					'name': name,
					'dim_id': '<?php echo $ws_dim->getId()?>',
					'parent': '<?php echo $members?>'
				}
			});
		});

	});
</script>
