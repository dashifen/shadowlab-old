<?php if (!is_array($this->powers) || sizeof($this->powers) <= 0) { ?>

	<p>We could not find any adept powers in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by adept power</label><input type="text" id="name" name="name"></li>
		<li>
			<label for="book">Show <span class="visuallyhidden">Book</span></label>
			<select id="book" name="book">
				<option value="all">All books</option>
				<?php foreach ($this->books as $book_id => $book) { ?>
					<option value="<?= $book_id ?>"><?= $book ?></option>
				<?php } ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
		
	<table class="w100 t l r searchable summarized no-zebra" id="adept_powers">
	<thead>
		<tr class="b">
			<th scope="col" id="power">Adept Power</th>
			<th scope="col" id="cost" class="w5">Cost</th>
			<th scope="col" id="levels" class="w5 aligncenter"><abbr title="Levels">L<span>evels</span></abbr></th>
			<th scope="col" id="activation" class="w10">Activation</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->powers as $i => $power) {
			$row = uniqid("adept_power_");
			extract($power); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $adept_power ?>" 
				data-book="<?= $book_id ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="power"><a href="#"><?= $adept_power ?></a></th>
				<td headers="<?= $row ?> cost"><?= number_format($cost, 2) ?></td>
				<td headers="<?= $row ?> levels" class="aligncenter"><?= $levels==0 ? "M" : $levels ?></td>
				<td headers="<?= $row ?> activation"><?= ucfirst($activation) ?></td>
			</tr> 
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" 
				data-name="<?= $adept_power ?>" 
				data-book="<?= $book_id ?>"
			>
				<td colspan="4" class="padb">
					<div id="<?= strtolower(preg_replace("/[\s\W]+/", "_", $adept_power)) ?>">
						<p><?= nl2br($description) ?></p><p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
			</tr>
		<? } ?>
	</tbody>
	</table>

<?php } ?>