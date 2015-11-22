<?php if (!is_array($this->vehicles) || sizeof($this->vehicles) <= 0) { ?>

	<p>We could not find any vehicles in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<p>Handling and speed ratings listed as X/Y refer to the rating on- and off-road respectively.</p>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by vehicle</label><input type="text" id="name" name="name" class="w15"></li>
		<li>
			<label for="category">Show<span class="visuallyhidden"> Categories</span></label>
			<select id="category" name="category">
				<option value="all">All Categories</option>
				<?php foreach($this->categories as $parent => $children) { ?>
					<optgroup label="<?= $parent ?>">
						<?php foreach($children as $child) { ?>
							<option value="<?= $child ?>"><?= $child ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="book" class="visuallyhidden">Show Book</label>
			<select id="book" name="book" class="w25">
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
		
	<table class="w100 t l r searchable summarized no-zebra" id="adept_vehicles">
	<thead>
		<tr class="b">
			<th scope="col" id="vehicle">Vehicle/Drone</th>
			<th scope="col" id="category">Vehicle Type</th>
			
			<?php foreach($this->vehicles[0]["attributes"] as $attribute) { ?>
				<th scope="col" id="<?= $attribute["attribute"] ?>" class="w5 aligncenter">
					<abbr title="<?= ucfirst($attribute["attribute"]) ?>"><?= $attribute["abbr"] ?></abbr>
				</th>
			<?php } ?>
			
			<th scope="col" id="availability" class="w10 alignright">Avail.</th>
			<th scope="col" id="cost" class="w10 alignright">Cost</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->vehicles as $i => $vehicle) {
			$row = uniqid("vehicle_");
			extract($vehicle); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $gear ?>"
				data-category="<?= $category ?>"
				data-parent="<?= $parent ?>"
				data-book="<?= $book_id ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="vehicle"><a href="#"><?= $gear ?></a></th>
				<td headers="<?= $row ?> category"><?= $category ?></td>
				
				<?php foreach ($attributes as $attribute) { ?>
					<td headers="<?= $row . " " . $attribute["attribute"] ?>" class="aligncenter"><?= $attribute["rating"] ?></td>
				<?php } ?>
				
				<td headers="<?= $row ?> availability" class="alignright"><?= $availability . $legality ?></td>
				<td headers="<?= $row ?> cost" class="alignright"><?= number_format($cost, 0) ?></td>
			</tr> 
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" 
				data-name="<?= $gear ?>"
				data-category="<?= $category ?>"
				data-parent="<?= $parent ?>"
				data-book="<?= $book_id ?>"
			>
				<td colspan="12" class="padb">
					<p><?= nl2br($description) ?></p><p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
		<? } ?>
	</tbody>
	</table>

<?php } ?>