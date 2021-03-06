<?php
	if (!isset($genid))
		$genid = gen_id();
		
	if (!isset($activeProjects))
		$activeProjects = logged_user()->getActiveProjects();
		
	$workspacesToJson = array();

	$wsset = array();
	if($activeProjects){
		foreach ($activeProjects as $w) {
			$wsset[$w->getId()] = true;
		}
		foreach ($activeProjects as $w){
			$tempParent = $w->getParentId();
			$x = $w;
			while ($x instanceof Project && !isset($wsset[$tempParent])) {
				$tempParent = $x->getParentId();
				$x = $x->getParentWorkspace();
			}
			if (!$x instanceof Project) {
				$tempParent = 0;
			}
			
			$workspacesToJson[] = array(
				"id" => $w->getId(),
				"n" => $w->getName(),
				"p" => $tempParent,
				"rp" => $w->getParentId(),
				"d" => $w->getDepth(),
				"c" => $w->getColor(),
				);
		}
	}
	
?>
<script type="text/javascript">
var wsTree = new og.WorkspaceChooserTree({genid: '<?php echo $genid ?>', workspaces: '<?php echo str_replace("'","\'", json_encode($workspacesToJson)); ?>'});
wsTree.render();
</script>
<div id="<?php echo $genid ?>-wsTree"></div>

