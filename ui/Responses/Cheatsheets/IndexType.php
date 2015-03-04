<?php
$count = 0;
if (is_array($this->sheets) && sizeof($this->sheets) > 0) { ?>
	
	<div class="sheets">
		<ul class="columns">
	
		<?php foreach ($this->sheets as $sheet) {
			list($id, $type, $name) = array_values($sheet);
			$link = strtolower(preg_replace("/\W+/", "-", $name)); ?>
			
			<li><a href="/cheatsheets/<?= $type . "/" . $link ?>"><?= $name ?></a></li>
			
		<?php  } ?>
		
		</ul>
	</div>
	
<?php } else { ?>
	
	<p>No <?= $this->type ?> cheatsheets could be found at this time.  If you think we should have,
	tell Dash.  He'll fix it.  And, if he doesn't, punch him in the nose for me.  He probably deserves 
	it.</p>
	
<?php } ?>