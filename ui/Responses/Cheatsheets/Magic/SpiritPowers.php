<?php if (!is_array($this->powers) || sizeof($this->powers) <= 0) { ?>

	<p>We could not find any spirit powers in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by name:</label><input type="text" id="name" name="name" value=""></li>
		<li>
			<select id="book" name="book">
				<option value="all">All Books</option>
				<?php foreach ($this->books as $book_id => $book) { ?>
					<option value="<?= $book_id ?>"><?= $book ?></option>
				<?php } ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized no-zebra" id="spirit_powers">
	<thead>
		<tr class="b">
			<th scope="col" id="power" class="w20">Power</th>
			<th scope="col" id="test">Test</th>
			<th scope="col" id="type" class="w5 aligncenter"><abbr title="Type">T<span>ype</span></abbr></th>
			<th scope="col" id="action" class="w5 aligncenter"><abbr title="Action">A<span>ction</span></abbr></th>
			<th scope="col" id="range" class="w5 aligncenter"><abbr title="Range">R<span>ange</span></abbr></th>
			<th scope="col" id="duration" class="w5 aligncenter"><abbr title="Duration">D<span>uration</span></abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->powers as $i => $power) {
			$row = uniqid("power_");
			extract($power); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $critter_power ?>"
				data-book="<?= $book_id ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="power"><a href="#"><?= $critter_power ?></a></th>
				<td headers="<?= $row ?> test"><?= $associated_test ?></td>
				<td headers="<?= $row ?> type" class="aligncenter"><?= ucfirst($type) ?></td>
				<td headers="<?= $row ?> action" class="aligncenter"><?= ucfirst($action) ?></td>
				<td headers="<?= $row ?> range" class="aligncenter"><?= ucfirst($range) ?></td>
				<td headers="<?= $row ?> duration" class="aligncenter"><?= ucfirst($duration) ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $critter_power ?>"
				data-book="<?= $book_id ?>"
			>
				<td colspan="6" class="padb">
					<p><?= nl2br($description) ?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>

<?php } ?>