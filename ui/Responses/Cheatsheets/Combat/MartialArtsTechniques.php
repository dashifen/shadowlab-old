<?php if (!is_array($this->techniques) || sizeof($this->techniques) <= 0) { ?>

	<p>We could not find any martial arts techniques in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by technique</label><input type="text" id="name" name="name" value="" size="15"></li>		
		<li>
			<label for="type">Styles</label>
			<select id="styles" name="styles">
				<option value="all">All Styles</option>
				<?php foreach ($this->styles as $style_id => $style) { ?> 
					<option value="<?= $style_id ?>"><?= $style ?></option> 
				<?php } ?>
			</select>
		</li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized">
	<thead>
		<tr class="b">
			<th scope="col" id="techniques" class="w50">Techniques</th>
			<th scope="col" id="styles">Styles</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->techniques as $i => $technique) {
			$row = uniqid("technique_");
			extract($technique); ?>
			
			<tr class="b summary <?=$i%2==0?"odd":"even"?>"
				data-styles-list="<?= join(" ", array_keys($styles)) ?>"
				data-name="<?= $technique ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="techniques" colspan="2"><a href="#"><?=$technique?></a></th>
			</tr>
			<tr class="b description hidden <?=$i%2==0?"odd":"even"?>" 
				data-styles-list="<?= join(" ", array_keys($styles)) ?>"
				data-name="<?= $technique ?>"
			>
				<td headers="<?= $row ?> techniques">
					<?php $name = strtolower(preg_replace("/[\s\W]+/", "_", $technique)) ?>
					<div id="<?= $name ?>">
						<p><?= nl2br($description) ?></p>
						<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
				<td headers="<?= $row ?> styles">
					<?php if(sizeof($styles) > 0) { ?>
						<ul>
							<?php foreach($styles as $style) {
								$name = strtolower(preg_replace("/[\s\W]+/", "_", $style)) ?>
								<li>
									<a href="/cheatsheets/combat/martial-arts-styles?name=<?= $name ?>&title=<?= $style?>" class="dialog">
									<?= $style ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>

<?php }
