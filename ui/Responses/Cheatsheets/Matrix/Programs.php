<?php if(!is_array($this->programs) || sizeof($this->programs) <= 0) { ?>

	<p>We could not find any programs in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any programs, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by program</label><input type="text" id="name" name="name" value=""></li>
		<li class="marl">
			<label for="type">Show</label>
			<select id="type" name="type">
				<option value="all">All Types</option>
				<?php foreach ($this->program_types as $type) { ?>
					<option value="<?=$type?>"><?=ucfirst($type)?></option>
				<?php } ?>
			</select>
		</li>
		<li class="fright"><input type="reset" class="awesome" value="Reset"></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized" id="programs">
	<thead>
		<tr class="b">
			<th scope="col" id="program">Program</th>
			<th scope="col" id="type" class="w15">Type</th>
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($this->programs as $i => $program) {
			$row = uniqid("programs_");
			extract($program); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>" data-name="<?= $program ?>" data-type="<?= $program_type ?>">
				<th scope="row" id="<?= $row ?>" headers="program"><a href="#"><?= $program ?></a></th>
				<td headers="<?= $row ?> type"><?= ucfirst($program_type) ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?= $program ?>" data-type="<?= $program_type ?>">
				<td colspan="2" class="padb">
					<p><?= nl2br($description) ?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?>)</td></p>
				</td>
			</tr>
		<?php } ?>
		
	</tbody>
	</table>
	
<?php } ?>