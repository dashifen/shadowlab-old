<?php if (!is_array($this->shots) || sizeof($this->shots) <= 0) {   ?>

	<p>We could not find any enhancements to called shots in the database at this time.  Frankly, this is probably 
	just a bug. Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this 
	one using the same link or button as last time.  If we still couldn't find any of them, then contact Dash and 
	he'll get to the bottom of it.</p>

<?php } else {   ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by shot</label><input type="text" id="name" name="name" value="" class="w20"></li>		
		<li>
			<label for="type">Ammo</label>
			<select id="ammo" name="ammo">
				<option value="all">All Types</option>
				<?php foreach ($this->ammo as $type) { ?>
					<option value="<?= str_replace(" ", "-", $type) ?>"><?= $type ?></option> 
				<?php } ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>

	<table class="w100 t l r searchable summarized no-zebra" id="matrix_actions">
	<thead>
		<tr class="b">
			<th scope="col" id="enhancement">Enhancement</th>
			<th scope="col" id="called_shot">Called Shot</th>
			<th scope="col" id="ammo_type">Ammo Type</th>
			<th scope="col" id="modifier" class="aligncenter">Modifier</th>
			<th scope="col" id="max_dv" class="aligncenter">Max DV</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->shots as $i => $shot) {
			$row = uniqid("enhancement_");
			extract($shot);
			
			$ammo_list = str_replace(" ", "-", $ammo_type);
			$ammo_list = str_replace(",-", " ", $ammo_list);  ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $enhancement ?>" 
				data-ammo-list="<?= $ammo_list ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="enhancement"><a href="#"><?= $enhancement ?></a></th>
				<td headers="<?= $row ?> called_shot">
					<?php if(!empty($called_shot)) {
						$name = strtolower(preg_replace("/[\s\W]+/", "_", $called_shot)); ?>
						<a href="/cheatsheets/combat/called-shots?name=<?= $name ?>&title=<?= $called_shot ?>" class="dialog"><?= $called_shot ?></a>
					<?php } else echo "&nbsp;";  ?>
				</td>
				<td headers="<?= $row ?> ammo_type"><?= $ammo_type ?></td>
				<td headers="<?= $row ?> modifier" class="aligncenter"><?= $modifier ?></td>
				<td headers="<?= $row ?> max_dv" class="aligncenter"><?= $max_dv==255 ? "&infin;" : $max_dv ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?= $enhancement ?>" data-ammo-list="<?= $ammo_list ?>">
				<td colspan="5">
					<?php
					if(!empty($description)) echo "<p>" . nl2br($description) . "</p>";
					
					if(!empty($effect)) echo "<p>" . nl2br($effect) . "</p>";
					else { ?>
						<ul>
							<?php foreach($effects as $effect) { ?>
								<li><strong><?= $effect["effect"] ?>:</strong> <?= $effect["description"] ?></li>
							<?php } ?>
						</ul>
					<?php } ?>		
				
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
		<?php }  ?>
	</tbody>
	</table>

<?php }