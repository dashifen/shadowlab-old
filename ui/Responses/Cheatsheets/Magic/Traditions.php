<?php if (!is_array($this->traditions) || sizeof($this->traditions) <= 0) {  ?>

	<p>We could not find any adept powers in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else {  ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li>
			<label for="name">Search by tradition</label>
			<input type="text" id="name" name="name" class="w15">
		</li>
		<li>
			<label for="drain">Drain</label>
			<select id="drain" name="drain" class="w15">
				<option value="all">Any attribute</option>
				<option value="6">Logic</option>
				<option value="7">Intuition</option>
				<option value="8">Charisma</option>
			</select>
		</li>
		<li>
			<label for="book">Show<span class="visuallyhidden">Book</span></label>
			<select id="book" name="book" class="w20">
				<option value="all">All books</option>
				<?php foreach($this->books as $book_id => $book) { ?>
					<option value="<?= $book_id ?>"><?= $book ?></option>
				<?php }  ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized no-zebra" id="adept_powers">
	<thead>
		<tr class="b">
			<th scope="col" id="tradition">Tradition</th>
			<th scope="col" id="drainattr" class="w15">Drain Attribute</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->traditions as $i => $tradition) {
			$row = uniqid("tradition_");
			extract($tradition);  ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $tradition ?>"
				data-drain="<?= "$drain_attribute_id $alt_drain_attr_id" ?>"
				data-book="<?= $book_id ?>"
				data-drain-list="1"
			>
				<th scope="row" id="<?= $row ?>" headers="tradition"><a href="#"><?= $tradition ?></a></th>
				<td headers="<?= $row ?> drainattr"><?= $drain_attribute . (!empty($alt_attr) ? " or $alt_attr" : "") ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $tradition ?>"
				data-drain="<?= "$drain_attribute_id $alt_drain_attr_id" ?>"
				data-book="<?= $book_id ?>"
				data-drain-list="1"
			>
				<td colspan="2" class="padb">
					<p><?= nl2br($description) ?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
	
					<?php if (is_array($spells) && sizeof($spells) > 0) { ?>
						
						<h3>Preferred Spells</h3>
						<ul class="csl count-<?= sizeof($spells) ?>">
							<?php foreach ($spells as $spell) {
								$name = strtolower(preg_replace("/[\s\W]+/", "_", $spell)); ?>
								<li><a href="/cheatsheets/magic/spells?name=<?= $name ?>&title=<?= $spell ?>" class="dialog"><?= $spell ?></a></li>
							<?php } ?>
						</ul>
					
					<?php }
					
					
					if (is_array($powers) && sizeof($powers) > 0) { ?> 
						
						<h3>Preffered Adept Powers</h3>
						<ul class="csl count-<?= sizeof($powers) ?>">
							<?php foreach ($powers as $power) {
								$name = strtolower(preg_replace("/[\s\W]+/", "_", $power)); ?>
								<li><a href="/cheatsheets/magic/adept-powers?name=<?= $name ?>&title=<?= $power ?>" class="dialog"><?= $power ?></a></li>
							<?php } ?>
						</ul>
						
					<?php }
					
					if (is_array($spirits) && sizeof($spirits) > 0) { ?> 
					
						<h3>Spirits</h3>
						<ul class="table">
							<?php foreach ($spirits as $spell_category => $spirit) { ?>
								
								<li><strong><?= $spell_category ?></strong> <?= $spirit ?></li>
							
							<?php }  ?>
						</ul>
						
					<?php }  ?>
				</td>
			</tr>
			
		<?php }  ?>
	
	</tbody>
	</table>

<?php } ?>