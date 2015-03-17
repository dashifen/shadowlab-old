<?php if (!is_array($this->mentors) || sizeof($this->mentors) <= 0) {  ?>

	<p>We could not find any mentor spirits in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else {  ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by mentor spirit:</label><input type="text" id="name" name="name" value=""></li>
		<li>
			<label for="book">Show<span class="visuallyhidden"> Books</span></label>
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
	
	<table class="w100 t l r searchable summarized no-zebra" id="mentor_spirits">
	<thead>
		<tr class="b">
			<th colspan="4">Mentor Spirits</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->mentors as $i => $mentor) {
			extract($mentor); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $mentor_spirit ?>"
				data-book="<?= $book_id ?>"
			>
				<th colspan="4"><a href="#"><?= $mentor_spirit ?></a></th>			
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $mentor_spirit ?>"
				data-book="<?= $book_id ?>"
			>
				<td colspan="4" class="padb">
					<p><?= nl2br($description) ?></p>
					
					<?php if (is_array($alternatives) && sizeof($alternatives) > 0) { ?>
						<p>Alternatives: <?= join(", ", $alternatives) ?>.</p>
					<?php } ?>
					
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $mentor_spirit ?>"
				data-book="<?= $book_id ?>"
			>
				<th class="w20">Advantage</th>
				<th class="w20">Mage Adv.</th>
				<th class="w20">Adept Adv.</th>
				<th>Disadvantage</th>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $mentor_spirit ?>"
				data-book="<?= $book_id ?>"
			>
				<td><?= $adv_all ?></td>
				<td><?= $adv_magician ?></td>
				<td><?= $adv_adept ?></td>
				<td><?= $disadvantages ?></td>
			</tr>
		<?php }  ?>
	</tbody>
	</table>

<?php }  ?>