
<div id="<?php echo $genid; ?>Search" class="search-container">
	<div class="search-summary" >
		<p class="results-for"><?php echo lang("search results for") ?>: <em>'<?php echo $search_string?>'</em> </p>
		<?php if ($extra):?>
		<p>Search speed: <?php echo $extra->time ?>s</p>
		<p>PHP Fitered: <?php echo $extra->filteredResults ?> results</p>
		<?php endif ;?>
	</div>

	<div class="search-results">
		<?php 
			foreach ($search_results AS $result){ 
				tpl_assign("result", $result);
				$this->includeTemplate(get_template_path('result_item', 'search'));

			}
		?>
	</div>
	<div class="search-footer">
		<div class="pagination">
			<?php $this->includeTemplate(get_template_path('pagination', 'search'));?>

		</div>
	</div>
</div>