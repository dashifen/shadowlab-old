<?php if (!is_array($this->rituals) || sizeof($this->rituals) <= 0) { ?>

	<p>We could not find any rituals in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any rituals, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li>
			<label for="name">Search by ritual</label>
			<input type="text" id="name" name="name" value="" class="w15">
		</li>
		<li>
			<label for="tags">Show<span  class="visuallyhidden"> Tags</span></label>
			<select id="tags" name="tags" class="w15">
				<option value="all">All tags</option>
				<?php foreach($this->tags as $id => $tag) { ?>
					<option value="<?= $id ?>"><?= $tag ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
						<label for="prereqs" class="visuallyhidden">Show Prerequisites</label>
						<select id="prereqs" name="prereqs" class="w15">
										<option value="all">All Prerequisites</option>
										<?php foreach($this->prereqs as $group => $list) { ?>
														<optgroup label="<?= ucfirst($group) ?>">
																		<?php foreach($list as $prereq) { ?>
																								<option value="<?=str_replace(" ", "_", $prereq)?>"><?=$prereq?></option>
																		<?php } ?>
														</optgroup>
										<?php } ?>
						</select>
		</li>
		<li>
			<label for="book" class="visuallyhidden">Show Books</label>
			<select id="book" name="book" class="w15">
				<option value="all">All books</option>
				<?php foreach($this->books as $id => $book) { ?> 
					<option value="<?= $id?>"><?= $book?></option> 
				<?php } ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>

	<table class="w100 t l r searchable summarized no-zebra">
	<thead>
		<tr class="b">
			<th scope="col" id="ritual">Ritual</th>
			<th scope="col" id="tags" class="w33">Tags</th>
			<th scope="col" id="prereq" class="w25">Prerequisite</th>
			<th scope="col" id="length" class="w10">Length</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->rituals as $i => $ritual) {
			$row = uniqid("ritual_");
			extract($ritual);
			
			$prereqs = [];
			if (!empty($prerequisite_metamagic)) {
							$prereqs[] = $prerequisite_metamagic;
			}
			
			if (!empty($prerequisite_metamagic_school)) {
							$prereqs[] = $prerequisite_metamagic_school;
			}
			
			if (!empty($prerequisite_ritual)) {
							$prereqs[] = $prerequisite_ritual;
			} ?>

				<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
								data-tags-list="<?= join(",", array_keys($ritual_tags)) ?>"
								data-prereqs-list="<?= join(",", array_map(function($x) { return str_replace(" ", "_", $x); }, $prereqs)) ?>"
								data-book="<?= $book_id ?>"
								data-name="<?= $ritual ?>"
				>
								<th scope="row" id="<?= $row ?>" headers="ritual"><a href="#"><?= $ritual ?></a></th>
								<td headers="<?= $row ?> tags"><?= join(", ", $ritual_tags) ?></td>
								<td headers="<?= $row ?> prereq"><?php echo sizeof($prereqs)==0 ? "&nbsp;" : join("<br>", $prereqs); ?></td>
								<td headers="<?= $row ?> length"><?= ucfirst($length) ?></td>
			</tr>
				<tr class="b description hidden <?= $i%2==0?"odd":"even"?>"
								data-tags-list="<?= join(",", array_keys($ritual_tags)) ?>"
								data-prereqs-list="<?= join(",", array_map(function($x) { return str_replace(" ", "_", $x); }, $prereqs)) ?>"
								data-book="<?= $book_id ?>"
								data-name="<?= $ritual ?>"
				>
								<td colspan="8">
												<div id="<?= strtolower(preg_replace("/[\s\W]+/", "_", $ritual)) ?>">
																<p><?= nl2br($description) ?></p><p>(p. <?= $page ?>, <?= $abbr ?>)</p>
												</div>
								</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>

<?php } ?>