<?php if (!is_array($this->styles) || sizeof($this->styles) <= 0) { ?>

	<p>We could not find any martial arts styles in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<p>Styles without a specific skill must still be a specialization of a skill; the GM can make the call as to which skills
	work for what styles.  Styles "linked" to the Firearms skill group can be a specialization of any of the skills within that
	group.  Even those styles which are linked to a given skill may be used with another (e.g. The Cowboy Way with Exotic Melee
	Weapon (Whip)) with GM approval.</p>
	
	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by style</label><input type="text" id="name" name="name" value="" class="w15"></li>		
		<li>
			<label for="type">Skills</label>
			<select id="skill" name="skill">
				<option value="all">All Skills</option>
				<?php foreach ($this->skills as $skill) {
					if (empty($skill)) continue; ?>
					<option value="<?= $skill ?>"><?= ucfirst($skill) ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="type">Techniques</label>
			<select id="techniques" name="techniques" class="w20">
				<option value="all">All Techniques</option>
				<?php foreach ($this->techniques as $technique_id => $technique) { ?>
					<option value="<?= $technique_id ?>"><?= $technique ?></option>
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
			<th scope="col" id="style" class="w33">Style</th>
			<th scope="col" id="skill" class="w20">Skill</th>
			<th scope="col" id="techniques">Techniques</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($this->styles as $i => $style) {
			$row = uniqid("style_");
			extract($style); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-techniques-list="<?= join(" ", array_keys($techniques)) ?>"
				data-skill="<?= !empty($skill) ? "$skill" : (!empty($skill_group) ? "$skill_group" : "") ?>"
				data-name="<?= $style ?>" 
			>
				<th scope="row" id="<?= $row ?>" headers="style"><a href="#"><?=$style?></a></th>
				<td headers="<?= $row ?> skill"><?= !empty($skill) ? "$skill" : (!empty($skill_group) ? "$skill_group" : "") ?></td>
				<td headers="<?= $row ?> techniques">&nbsp;</td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-techniques-list="<?= join(" ", array_keys($techniques)) ?>"
				data-skill="<?= !empty($skill) ? "$skill" : (!empty($skill_group) ? "$skill_group" : "") ?>"
				data-name="<?= $style ?>" 
			>
				<td headers="<?= $row ?> style" colspan="2">
					<?php $name = strtolower(preg_replace("/[\s\W]+/", "_", $style)); ?>
					
					<div id="<?= $name ?>">
						<p><?=nl2br($description)?></p>
						<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</div>
				</td>
				<td headers="<?= $row ?> techniques">
					<ul class="columns">
						<? foreach($techniques as $technique) {
							$name = strtolower(preg_replace("/[\s\W]+/", "_", $technique)); ?>
							<li>
								<a href="/cheatsheets/combat/martial-arts-techniques?name=<?= $name ?>&title=<?= $technique ?>" class="dialog">
								<?= $technique ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>

<?php }
