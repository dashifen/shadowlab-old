<?php if (!is_array($this->locations) || sizeof($this->locations) <= 0) {   ?>

	<p>We could not find any called shot locationsin the database at this time.  Frankly, this is probably 
	just a bug. Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this 
	one using the same link or button as last time.  If we still couldn't find any of them, then contact Dash and 
	he'll get to the bottom of it.</p>

<?php } else {   ?>

<form class="searchbar">
<fieldset>
<ol>
	<li><label for="name">Search by location</label><input type="text" id="name" name="name" value="" class="w20"></li>		
	<li>
		<label for="type">Types</label>
		<select id="type" name="type">
			<option value="all">All Types</option>
			<?php foreach ($this->types as $type) { ?>
				<option value="<?= $type ?>"><?= ucfirst($type) ?></option>
			<?php } ?>
		</select>
	</li>
	<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
</ol>
</fieldset>
</form>

<table class="w100 t l r searchable summarized">
<thead>
	<tr class="b">
		<th scope="col" id="location">Location</th>
		<th scope="col" id="type" class="w10">Type</th>
		<th scope="col" id="modifier" class="aligncenter w10">Modifier</th>
		<th scope="col" id="max_dv" class="aligncenter w10">Max DV</th>
	</tr>
</thead>
<tbody>
	<?php foreach ($this->locations as $i => $location) {
		$row = uniqid("location_");
		extract($location); ?>
		
		<tr class="b summary <?= $i%2==0?"odd":"even" ?>" data-name="<?= $location ?>" data-type="<?= $location_type ?>">
			<th scope="row" id="<?=$row?>" headers="location"><a href="#"><?=$location?></a></th>
			<td headers="<?=$row ?> type"><?=ucfirst($location_type)?></td>
			<td headers="<?=$row ?> modifier" class="aligncenter"><?=$modifier?></td>
			<td headers="<?=$row ?> max_dv" class="aligncenter"><?=$max_dv==255 ? "&infin;" : $max_dv?></td>
		</tr>
		<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?= $location ?>" data-type="<?= $location_type ?>">
			<td colspan="4" class="padb">
				<?php
				if (is_array($effect)) {
					if (sizeof($effect) > 0) { ?>
						<ul>
							<?php foreach ($effect as $description) { ?>
								<li><strong><?= $description[0] ?>:</strong> <?= $description[1] ?></li>
							<?php } ?>
						</ul>
					<?php }
				}
				
				elseif (!empty($effect)) { ?>
					<p><?= nl2br($effect) ?></p>
				<?php } ?>
				
				(p. <?= $page ?>, <?= $abbr ?>)
			</td>
		</tr>
	<?php } ?>
</tbody>
</table>

<? }
