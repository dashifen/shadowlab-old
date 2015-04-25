<?php if (!is_array($this->enchantments) || sizeof($this->enchantments) <= 0) { ?>

	<p>We could not find any adept enchantments in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by enchantment</label><input type="text" id="name" name="name"></li>
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
		
	<table class="w100 t l r searchable summarized no-zebra" id="enchantments">
	<thead>
		<tr class="b">
			<th scope="col" id="enchantment">Enchantment</th>
			<th scope-"col" id="prerequisite" class="w15">Prerequisite</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->enchantments as $i => $enchantment) {
			$row = uniqid("enchantment_");
			extract($enchantment); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $enchantment ?>" 
				data-book="<?= $book_id ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="enchantment"><a href="#"><?= $enchantment ?></a></th>
				<td headers="<?= $row ?> prerequisite">
					<?php $prereqs = [];
					if (!empty($prerequisite_metamagic)) $prereqs[] = $prerequisite_metamagic;
					elseif (!empty($prerequisite_metamagic_school)) $prereqs[] = $prerequisite_metamagic_school;
					echo sizeof($prereqs) > 0 ? join("<br>", $prereqs) : "&nbsp;"; ?>
				</td>
			</tr> 
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" 
				data-name="<?= $enchantment ?>" 
				data-book="<?= $book_id ?>"
			>
				<td colspan="2" class="padb">
					<div id="<?= strtolower(preg_replace("/[\s\W]+/", "_", $enchantment)) ?>">
						<p><?= nl2br($description) ?></p><p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
			</tr>
		<? } ?>
	</tbody>
	</table>

<?php } ?>