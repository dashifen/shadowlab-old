<?php
$count = 0;
if (is_array($this->sheets) && sizeof($this->sheets) > 0) { ?>
	
	<div class="sheets">
	
		<?php foreach ($this->sheets as $sheet) {
			list($id, $type, $name) = array_values($sheet);
			
			if (!isset($current_type) || $current_type != $type) {
				if (isset($div_open)) {
					echo "</ul></div>";
				} ?>
				
				<div>
					<h3><?= ucfirst($type) ?></h3>
					<ul>
	
				<?php $current_type = $type;
				$div_open = true;
			}
			
			$link = strtolower(preg_replace("/\W+/", "-", $name)); ?>
			
			<li><a href="/cheatsheets/<?= $type . "/" . $link ?>"><?= $name ?></a></li>
			
		<?php  } ?>
		
		</ul>
		</div>
	</div>
	
<?php } else { ?>
	
	<p>No cheatsheets could be found at this time.  If you think we should have,
	tell Dash.  He'll fix it.  And, if he doesn't, punch him in the nose for me.  He probably deserves 
	it.</p>
	
<?php } ?>