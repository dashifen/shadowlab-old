<form class="searchbar">
<?php if (sizeof($this->actions) <= 0) { ?>

	<p>We could not find any matrix actions in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any actions, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by matrix action</label><input type="text" id="name" name="name" value=""></li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized no-zebra" id="matrix_actions">
	<thead>
		<tr class="b">
			<th scope="col" id="action" class="w25">Matrix Action</th>
			<th scope="col" id="type" class="w10">Type</th>
			<th scope="col" id="test">Test</th>
			<th scope="col" id="marks" class="w10 aligncenter">Marks</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->actions as $i => $action) {
			$row = uniqid("matrix_action_");
			extract($action); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>" data-name="<?=$matrix_action ?>">
				<th scope="row" id="<?= $row ?>" headers="action"><a href="#"><?= $matrix_action ?></a></th>
				<td headers="<?= $row ?> type"><?= ucfirst($matrix_action_type) ?></td>
				<td headers="<?= $row ?> test">
					<?php if (!empty($offensive_test)) {
						echo !empty($defensive_test) ? "$offensive_test vs. $defensive_test" : $offensive_test;
					} else {
						echo "&nbsp;";
					} ?>
				</td>
				<td headers="<?= $row ?> marks" class="aligncenter">
					<?php if (is_numeric($marks_required)) {
						echo $marks_required == 4 ? "Owner" : $marks_required;
					} else {
						echo "?";
					} ?>
				</td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?= $matrix_action ?>">
				<td colspan="4" class="padb">
					<p><?= nl2br($description) ?></p>
					<p>(<?= $reference ?>)</p>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>
<?php } ?>