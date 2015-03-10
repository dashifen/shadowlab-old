<?php if( !is_array($this->forms) || sizeof($this->forms) == 0) {  ?>

    <p>We could not find any complex forms in the database at this time.  Frankly, this is probably
    just a bug.  Unless Dash deleted his own databases.  Either way, try going back a page and then returning to
    this one using the same link or button as last time.  If we still couldn't find any of them, then contact Dash
    and he'll get to the bottom of it.</p>

<?php } else {  ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by complex form</label><input type="text" id="name" name="name" value=""></li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>

	<table class="w100 t l r searchable summarized no-zebra" id="complex_forms">
	<thead>
		<tr class="b">
			<th scope="col" id="form">Complex Form</th>
			<th scope="col" id="target"   class="w10 aligncenter"><abbr title="Target">T<span>arget</span></abbr></th>
			<th scope="col" id="duration" class="w5 aligncenter"><abbr title="Duration">D<span>uration</span></abbr></th>
			<th scope="col" id="fading"   class="w5 aligncenter"><abbr title="Fading">F<span>ading</span></abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->forms as $i => $form) {
			$row = uniqid("complex_form_");
			extract($form);  ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>" data-name="<?= $complex_form ?>">
				<th scope="row" id="<?= $row ?>" headers="form"><a href="#"><?= $complex_form ?></a></th>
				<td headers="<?= $row ?> target"   class="aligncenter"><?= ucfirst($target) ?></td>
				<td headers="<?= $row ?> duration" class="aligncenter"><?= ucfirst($duration) ?></td>
				<td headers="<?= $row ?> fading"   class="aligncenter"><?= $fading ?></td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" data-name="<?= $complex_form ?>">
				<td colspan="4">
					<p><?= nl2br($description) ?></p>
					<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
				</td>
			</tr>
		<?php }  ?>
	</tbody>
	</table>

<?php }  ?>
