<?php if (!is_array($this->shots) || sizeof($this->shots) <= 0) {  ?>

	<p>We could not find any called shots in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else {  ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by shot</label><input type="text" id="name" name="name" value="" size="15"></li>		
		<li>
			<label for="book">Show <span class="visuallyhidden">Book</span></label>
			<select id="book" name="book" class="w25">
				<option value="all">All books</option>
				<?php foreach ($this->books as $book_id => $book) { ?>
					<option value="<?= $book_id ?>"><?= $book ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="requires_training" class="checkbox no-colon">
				<input type="checkbox" id="requires_training" name="requires_training" value="Y"> &ndash;
				<span>Requires Training</span>
			</label>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized no-zebra" id="matrix_actions">
	<thead>
		<tr class="b">
			<th scope="col" id="called_shot">Called Shot</th>
			<th scope="col" id="limitation">Limitation</th>
			<th scope="col" id="req_training" class="w5 aligncenter"><abbr title="Requires Training">R<span>equires </span>T<span>raining</span></abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->shots as $i => $shot) {
			$row = uniqid("called_shot_");
			extract($shot);  ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-requires_training="<?= $requires_training=="Y" ? 1 : 0 ?>"
				data-name="<?= $called_shot ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="called_shot"><a href="#"><?= $called_shot ?></a></th>
				<td headers="<?= $row ?> limitation"><?= $limitation ?></td>
				<td headers="<?= $row ?> req_training" class="aligncenter"><?= $requires_training ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-requires_training="<?= $requires_training=="Y" ? 1 : 0 ?>"
				data-name="<?= $called_shot ?>"
			>
				<td colspan="3" class="padb">
					<?php $name = strtolower(preg_replace("/[\s\W]+/", "_", $called_shot)) ?>
					<div id="<?= $name ?>">
						<p><?= nl2br($description) ?></p>
						<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
			</tr>
		<?php }  ?>
	</tbody>
	</table>

<?php }