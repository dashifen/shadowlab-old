<?php if (!is_array($this->ways) || sizeof($this->ways) <= 0) { ?>

	<p>We could not find any adept ways in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<form class="searchbar">
	<fieldset>
	<ol>
		<li><label for="name">Search by way</label><input type="text" id="name" name="name" value=""></li>
		<li><button type="reset"><i class="fa fa-fw fa-undo"></i> Reset</button></li>
	</ol>
	</fieldset>
	</form>
	
	<table class="w100 t l r searchable summarized">
	<thead>
		<tr class="b">
			<th id="way" scope="col" class="w50">Adept Way</th>
			<th id="powers" scope="col">Powers</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->ways as $i => $way) {
			$row = uniqid("way_");
			extract($way); ?>
			
			<tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?=$adept_way?>" 
				data-book="<?=$book_id?>"
			>
				<th scope="row" id="<?= $row ?>" headers="way"><a href="#"><?= $adept_way ?></a></th>
				<td headers="<?= $row ?> powers">&nbsp;</td>
			</tr>
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>" 
				data-name="<?=$adept_way?>" 
				data-book="<?=$book_id?>"
			>
				<?php if (sizeof($powers) > 0) { ?>
					<td headers="<?= $row ?> way">
						<p><?= nl2br($description) ?></p>
						<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</td>
					<td headers="<?= $row ?> powers">
						<ul>
							<?php foreach ($powers as $power) {
								$name = strtolower(preg_replace("/[\s\W]+/", "_", $power)); ?>
								<li><a class="dialog" href="/cheatsheets/magic/adept-powers?name=<?= $name ?>"><?= $power ?></a></li>
							<?php } ?>
						</ul>
					</td>
				<?php } else { ?>
					<td colspan="2" headers="<?= $row ?>">
						<p><?= nl2br($description) ?></p>
						<p>(p. <?= $page ?>, <?= $abbr ?>)</p>
					</td>
				<?php } ?>
				
				</td>				
			</tr>
		<? } ?>
	</tbody>
	</table>

<?php } ?>