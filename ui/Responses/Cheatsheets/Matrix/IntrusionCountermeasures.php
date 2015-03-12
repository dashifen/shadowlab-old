<?php if (!is_array($this->countermeasures) || sizeof($this->countermeasures) <= 0) { ?>

	<p>We could not find any intrusion countermeasures in the database at this time.  Frankly, this is probably 
	just a bug.  Unless Dash deleted his own databases.  Either way, try going back a page and then returning to 
	this one using the same link or button as last time.  If we still couldn't find any IC, then contact Dash 
	and he'll get to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by name</label><input type="text" id="name" name="name" value=""></li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>

	<table class="w100 t l r searchable summarized no-zebra" id="ic">
	<thead>
		<tr class="b">
			<th scope="col" id="ic" class="w15">IC</th>
			<th scope="col" id="test">Test</th>
			<th scope="col" id="purpose">Purpose</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($this->countermeasures as $i => $countermeasure) {
			$row = uniqid("intrusion_countermeasure_");
			extract($countermeasure); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>" data-name="<?= $ic ?>">
				<th scope="row" id="<?= $row ?>" headers="ic"><a href="#"><?=$ic?></a></th>
				<td headers="<?= $row ?> test"><?=$associated_test?></td>
				<td headers="<?= $row ?> purpose"><?=$purpose?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?=$ic?>">
				<td colspan="3">
					<p><?= nl2br($description) ?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
			
		<?php } ?>
	</tbody>
	</table>
<?php } ?>

