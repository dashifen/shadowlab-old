<?php if (!is_array($this->schools) || sizeof($this->schools) <= 0) {   ?>

	<p>We could not find any schools/ways in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else {   ?>

	<p>Metamagics, rituals, etc. listed in italics within the table below are considered the typical first thing
	learned within a given school.  After learning that ritual (or any of them, if there are no such guidelines) a
	magician can learn other rituals or enchantments within the same school at teh cost of their first initiation
	into it.  Additional metamagic techniques require additional intiations, however, and adept powers can only
	be developled via adept power points.</p>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by school/way</label><input type="text" id="name" name="name" class="w15"></li>
		<li>
			<label for="type">Show<span class="visuallyhidden"> Types</span></label>
			<select id="type" name="type">
				<option value="all">All Types</option>
				<?php foreach ($this->types as $type) { ?>
					<option value="<?= $type ?>"><?= $type ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="book" class="visuallyhidden">Show Books</label>
			<select id="book" name="book">
				<option value="all">All Books</option>
				<?php foreach ($this->books as $book_id => $book) {  ?>
					<option value="<?=  $book_id  ?>"><?=  $book  ?></option>
				<?php }  ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized no-zebra" id="schools">
	<thead>
		<tr class="b">
			<th scope="col">School/Way</th>
			<th scope="col">Art</th>
		</tr>
	</thead>
	<tbody>
		<?php $lists = ["enchantments", "metamagics", "powers", "rituals"];
		$format = '<a href="/cheatsheets/magic/%s?name=%s&title=%s" class="dialog">%s</a>';
		foreach($this->schools as $i => $school) {
			extract($school);
			
			foreach ($lists as $list) {
				if (is_array($$list) && sizeof($$list) > 0) {
					array_walk($$list, function(&$item) use ($format, $list) {
						if (is_array($item)) {
							$primary = $item["primary"];
							unset($item["primary"]);
							$item = array_shift($item);
						} else {
							$primary = "N";
						}
						
						$item = sprintf($format, $list, strtolower(preg_replace("/[\s\W]+/", "_", $item)), $item, $item);
						if ($primary == "Y") $item = "<em>" . $item . "</em>";
					});
				}
			} ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $school_name ?>"
				data-type="<?= $school_type ?>"
				data-book_id="<?= $book_id ?>"
			>
				<th scope="row"><a href="#"><?= $school_name ?></a></th>
				<td><?= $school_type ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $school_name ?>"
				data-type="<?= $school_type ?>"
				data-book_id="<?= $book_id ?>"
			>
				<td colspan="2">
					<p><?= nl2br($description) ?></p>
				
					<table class="w100">
					<tbody>
						<?php foreach ($lists as $list) {
							if (is_array($$list) && sizeof($$list) > 0) { ?>
								<tr>
									<th scope="row" class="w15 alignright"><?= ucfirst($list) ?>:</th>
									<td><ul class="oxford count-<?= sizeof($$list) ?>"><li><?= join("</li><li>", $$list) ?></li></ul></td>
								</tr>
							<?php }
						} ?>
					</tbody>
					</table>
					
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
		<?php }  ?>
	</tbody>
	</table>

<?php }  ?>