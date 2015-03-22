<?php if (!is_array($this->actions) || sizeof($this->actions) <= 0) {  ?>

	<p>We could not find any combat actions in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else {  ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li>
			<label for="name">Name</label>
			<input type="text" id="name" name="name" value="" class="w15">
		</li>
		<li>
			<label for="action">Show</label>
			<select id="action" name="action">
				<option value="all">All Actions</option>
				<?php foreach($this->action_types as $type) { ?> 
					<option value="<?= $type ?>"><?= ucfirst($type) ?></option> 
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="combat" class="visuallyhidden">Combat</label>
			<select id="combat" name="combat">
				<option value="all">All Types</option>
				<?php foreach($this->combat_types as $combat) {
					if (empty($combat)) continue; ?> 
					<option value="<?= $combat ?>"><?= ucfirst($combat) ?></option> 
				<?php } ?>
			</select>
		</li>
		<li>
			<label for="initiative_modifier" class="checkbox no-colon">
				<input type="checkbox" id="initiative_modifier" name="initiative_modifier" value="Y">
				<span><abbr title="Initiative Modifier">I<span>nitiative </span>M<span>odifier</span></abbr></span>
			</label>
		</li>		
		<li>
			<label for="martial_art" class="checkbox no-colon">
				<input type="checkbox" id="martial_art" name="martial_art" value="Y">
				<span><abbr title="Requires Marial Arts"><span>Requires </span>M<span>artial </span>A<span>rts</span></abbr></span>
			</label>
		</li>		
		<li>
			<label for="active_defense" class="checkbox no-colon">
				<input type="checkbox" id="active_defense" name="active_defense" value="Y">
				<span><abbr title="Active Defense">A<span>ctive </span>D<span>efene</span></abbr></span>
			</label>
		</li>		
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized">
	<thead>
		<tr class="b">
			<th scope="col" id="action">Action</th>
			<th scope="col" id="action_type" class="w10 aligncenter"><abbr title="Action">A<span>ction </span>T<span>ype</span></abbr></th>
			<th scope="col" id="combat_type" class="w10 aligncenter"><abbr title="Combat Type">C<span>ombat </span>T<span>ype</span></abbr></th>
			<th scope="col" id="initiative_mod" class="w5 aligncenter"><abbr title="Initiative Modifier">I<span>nitiative </span>M<span>odifier</span></abbr></th>
			<th scope="col" id="martial_arts"   class="w5 aligncenter"><abbr title="Requires Marial Arts"><span>Requires </span>M<span>artial </span>A<span>rts</span></abbr></th>
			<th scope="col" id="active_defense" class="w5 aligncenter"><abbr title="Active Defense">A<span>ctive </span>D<span>efene</span></abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->actions as $i => $action) {
			$row = uniqid("action_");
			extract($action); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $action ?>"
				data-combat="<?= $combat_type ?>"
				data-action="<?= $action_type ?>"
				data-martial_art="<?= $martial_art=="Y" ? 1 : 0 ?>"
				data-active_defense="<?= $active_defense=="Y" ? 1 : 0 ?>"
				data-initiative_modifier="<?= is_numeric($initiative_modifier) && $initiative_modifier > 0 ? 1 : 0 ?>"
			>
				<th scope="row" id="<?= $row ?>" headers="action"><a href="#"><?= $action ?></a></th>
				<td headers="<?= $row ?> action_type" class="aligncenter"><?= ucfirst($action_type) ?></td>
				<td headers="<?= $row ?> combat_type" class="aligncenter"><?= ucfirst($combat_type) ?></td>
				<td headers="<?= $row ?> initiative_mod" class="aligncenter"><?=!is_numeric($initiative_modifier) ? 0 : $initiative_modifier ?></td>
				<td headers="<?= $row ?> martial_arts"   class="aligncenter"><?= $martial_art ?></td>
				<td headers="<?= $row ?> active_defense" class="aligncenter"><?= $active_defense ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $action ?>"
				data-combat="<?= $combat_type ?>"
				data-action="<?= $action_type ?>"
				data-martial_art="<?= $martial_art=="Y" ? 1 : 0 ?>"
				data-active_defense="<?= $active_defense=="Y" ? 1 : 0 ?>"
				data-initiative_modifier="<?= is_numeric($initiative_modifier) && $initiative_modifier > 0 ? 1 : 0 ?>"
			>
				<td colspan="6">
					<p><?=nl2br($description)?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>

<?php }
