<?php if (!is_array($this->metamagics) || sizeof($this->metamagics) <= 0) {   ?>

	<p>We could not find any metamagics in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>
 
 	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by metamagic</label><input type="text" id="name" name="name" class="w15"></li>
		<li>
			<label for="book">Show<span class="visuallyhidden"> Books</span></label>
			<select id="book" name="book" class="w15">
				<option value="all">All Books</option>
				<?php foreach ($this->books as $book_id => $book) {  ?>
					<option value="<?=  $book_id  ?>"><?=  $book  ?></option>
				<?php }  ?>
			</select>
		</li>
		<li><label for="adept_only" class="checkbox no-colon"><input type="checkbox" id="adept_only" name="adept_only" value="Y"> &ndash; Adept Only</label></li>		
		<li><label for="repeatable" class="checkbox no-colon"><input type="checkbox" id="repeatable" name="repeatable" value="Y"> &ndash; Repeatable</label></li>		
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized no-zebra" id="metamagics">
	<thead>
		<tr class="b">
			<th scope="col">Metamagic</th>
			<th scope="col">Associated Test</th>
			<th scope="col" class="aligncenter icon">Adept Only</th>
			<th scope="col" class="aligncenter icon">Repeatable</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->metamagics as $i => $metamagic) {
			extract($metamagic);  ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $metamagic ?>"
				data-adept_only="<?= $adept_only=="Y" ? 1 : 0 ?>"
				data-repeatable="<?= $repeatable=="Y" ? 1 : 0 ?>"
				data-book_id="<?= $book_id ?>"
			>
				<th scope="row"><a href="#"><?= $metamagic ?></a></th>
				<td><?= $associated_test ?></td>
				<td class="aligncenter"><?= $adept_only ?></td>
				<td class="aligncenter"><?= $repeatable ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $metamagic ?>"
				data-adept_only="<?= $adept_only=="Y" ? 1 : 0 ?>"
				data-repeatable="<?= $repeatable=="Y" ? 1 : 0 ?>"
				data-book_id="<?= $book_id ?>"
			>
				<td colspan="4">
					<div id="<?= strtolower(preg_replace("/[\s\W]+/", "_", $metamagic)) ?>">
						<p><?= nl2br($description) ?></p><p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
			</tr>
		<?php }  ?>
	</tbody>
	</table>

<?php }  ?>