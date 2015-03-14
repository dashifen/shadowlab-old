<?php if(!is_array($this->powers) || sizeof($this->powers) <= 0) { ?>

	<p>We could not find any sprite powers in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any powers, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by power</label><input type="text" id="name" name="name" value=""></li>
		<li class="fright"><input type="reset" class="awesome" value="Reset"></li>
	</ol>
	</fieldset>
	</form>

	<table class="w100 t l r searchable summarized">
	<thead>
		<tr class="b">
			<th scope="col" id="power" class="w20">Sprite Power</th>
			<th scope="col" id="test">Test</th>
			<th scope="col" id="action"   class="w10 aligncenter"><abbr title="Action">A<span>ction</span></abbr></th>
			<th scope="col" id="duration" class="w5  aligncenter"><abbr title="Duration">D<span>uration</span></abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->powers as $i => $power) {
			$row = uniqid("sprite_power_");
			extract($power); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>" data-name="<?= $critter_power ?>">
				<th scope="row" id="<?= $row ?>" headers="power"><a href="#"><?=$critter_power?></a></th>
				<td headers="<?=$row ?> test"><?=$associated_test?></td>
				<td headers="<?=$row ?> action"   class="aligncenter"><?=ucfirst($action)?></td>
				<td headers="<?=$row ?> duration" class="aligncenter"><?=ucfirst($duration)?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?= $critter_power ?>">
				<td colspan="4" class="padb">
					<div id="<?= strtolower(preg_replace("/[\s\W]+/", "_", $critter_power)); ?>">
						<p><?=nl2br($description)?></p>
						<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>

<?php } ?>