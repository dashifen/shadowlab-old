<?php if (!is_array($this->spells) || sizeof($this->spells) <= 0) { ?>

	<p>We could not find any spells in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any spells, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li>
			<label for="name">Search by spell</label>
			<input type="text" id="name" name="name" value="" class="w15">
		</li>
		<li>
			<label for="category" class="marl">Show<span class="visuallyhidden"> Categories</span></label>
			<select id="category" name="category" class="w15">
				<option value="all">All categories</option>
				<?php foreach($this->categories as $id => $category) { ?>
					<option value="<?= $id?>"><?= $category?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="tags" class="visuallyhidden">Show Tags</label>
			<select id="tags" name="tags" class="w15">
				<option value="all">All tags</option>
				<?php foreach($this->tags as $id => $tag) {
					if (strlen($tag[1]) > 0) { ?>
						<option value="<?= $id?>" data-category="<?= $tag[0] ?>"><?= $tag[1] ?></option>
					<?php }
				} ?>
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
			<th scope="col" id="spell">Spell</th>
			<th scope="col" id="category" class="w15">Category</th>
			<th scope="col" id="tags"     class="w33">Tags</th>
			<th scope="col" id="type"     class="w5 aligncenter"><abbr title="Type">T<span>ype</span></abbr></th>
			<th scope="col" id="range"    class="w5 aligncenter"><abbr title="Range">R<span>ange</span></abbr></th>
			<th scope="col" id="damage"   class="w5 aligncenter"><abbr title="Damage">Da<span>mage</span></abbr></th>
			<th scope="col" id="duration" class="w5 aligncenter"><abbr title="Duration">Du<span>ration</span></abbr></th>
			<th scope="col" id="drain"    class="w5 aligncenter"><abbr title="Drain">Dr<span>ain</span></abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->spells as $i => $spell) {
			$row = uniqid("spell_");
			extract($spell);
			
			// because multiple categories of spells have an Area tag, we've named them Area (Illusion), Area (Detaction),
			// and Area (Manipulation) in the database.  in our table, leaving those qualifications on-screen would be 
			// redundant so we're going to remove anything from our spells_tags string that is between parenthesis.  then
			// we space it out a bit for a more attractive look.
			
			$spell_tags_ids = str_replace(",", " ", $spell_tags_ids);
			$spell_tags = preg_replace("/\(\w+\)/", "", $spell_tags);
			$spell_tags = str_replace(",", ", ", $spell_tags); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $spell ?>"
				data-category="<?= $spell_category_id ?>"
				data-tags-list="<?= $spell_tags_ids ?>"
				data-book="<?= $book_id ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="spell"><a href="#"><?= $spell?></a></th>
				<td headers="<?= $row ?> category"><?= $spell_category?></td>
				<td headers="<?= $row ?> tags"><?= str_replace(",", ", ", $spell_tags)?></td>
				<td headers="<?= $row ?> type"     class="aligncenter"><?= $type?></td>
				<td headers="<?= $row ?> range"    class="aligncenter"><?= $range?></td>
				<td headers="<?= $row ?> damage"   class="aligncenter"><?= !empty($damage) ? $damage : "&nbsp;"?></td>
				<td headers="<?= $row ?> duration" class="aligncenter"><?= $duration?></td>
				<td headers="<?= $row ?> drain"    class="aligncenter"><?= $drain?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even"?>"
				data-name="<?= $spell ?>"
				data-category="<?= $spell_category_id ?>"
				data-tags-list="<?= $spell_tags_ids ?>"
				data-book="<?= $book_id ?>"
			>
				<td colspan="8">
					<p><?= nl2br($description) ?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?></p>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>
	
	<script type="text/javascript">
		// source: http://stackoverflow.com/a/878331/360838
	
		$(document).ready(function() {
			var tags = $("#tags");
			
			// first, we want to make an object that details the values, text, and categories for our
			// tags.  we can do this by finding our options, and then creating simple objects with those
			// data and pushing them into the options array we're about to create.
			
			var options = [];
			$("#tags").find("option").each(function() {
				options.push({
					"value":    $(this).val(),
					"text":     $(this).text(),
					"category": $(this).data("category")
				});
			});
			
			// now, we'll store that within the data for our tags.
			
			tags.data("options", options);
		});
			
		$(".searchbar").on("searchbar:after", function() {
			var category = $("#category").val();
			var tags = $("#tags");
			
			// first, we record the value of the selected option within tags.  Then, empty our tags and then grab the 
			// object we prepared above.  with that object, we can then loop over all of our options -- the ones we just 
			// emptied out of the select element -- and add the ones we care about at this time back into the DOM.
			
			var element = tags.get(0);
			var value = element.options[element.selectedIndex].value;
			var options  = tags.empty().data("options");
			var selected = false;
	
			$.each(options, function(i) {
				var option = options[i];
				var newopt = $("<option>").text(option.text).val(option.value);
				
				// if our category is all (i.e. show all categories) or the value for the option we're looking
				// at is all (i.e. it's the show-all tags option) then we want to add it to the tags element. 
				// we also add those options which have a category that matches the currently selected categroy.
				// the following conditional wraps all that up nicely and then the use of append() in the if-
				// block will create an <option> and load it up as we need to for the screen.  
				
				if(category=="all" || option.value=="all" || option.category == category) {
					if(option.value == value) newopt.prop("selected", (selected = true));
					tags.append(newopt);
				}
			});
			
			// if we didn't select something within our loop, then we just mark the first option in the element.
			// this often happens when we change the cateogry element.  notice we triger a re-do on our search to
			// ensure that we show all tags.

			if(!selected) {
				tags.find("option:first").prop("selected", true);
				tags.trigger("change");
			}
		});
	</script>

<?php } ?>