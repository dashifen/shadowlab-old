<?php if(sizeof($this->errors) == 0) {
	if (isset($this->gear_id) && is_numeric($this->gear_id)) { ?>
			
		<p>The <strong><?=$this->vehicle?></strong> vehicle/drone has been added to the database.  Click the following button to move onto the next one or 
		wait <?= ($delay = 3) ?> seconds and we'll automatically reload the form for you.</p>
		
		<form method="get" action="/cheatsheets/gear/vehicles-and-drones/entry">
		<input type="hidden" name="page" value="<?= $this->page ?>">
		<input type="hidden" name="book_id" value="<?= $this->book_id ?>">
		<button id="next"><i class="fa fa-fw fa-angle-double-right"></i> Next Vehicle/Drone</button>
		</form>
		
		<script type="text/javascript">
			$(document).ready(function() { window.setTimeout(function() { $("#next").click(); }, <?= $delay * 1000 ?>); });
		</script>
	
	<?php } elseif (isset($this->vehicle) && !empty($this->vehicle)) { ?>
	
		<p>The most recent vehicle or drone added to the database was <strong><?= $this->vehicle ?></strong>.</p>
		
	<?php } elseif (isset($this->message) && !empty($this->message)) { ?>
		
		<p><?= $this->message ?></p>
		
	<?php } elseif (isset($this->error) && !empty($this->error)) { ?>
	
		<p>We were unable to save this vehicle in the database due to a server error of some kind.  The following is what the database told us:</p>  
		
		<blockquote><?= $this->error ?></blockquote>
		
		<p>Maybe that helps; knowing error messages, it probably doesn't.  We've put your entries in the fields below, so you can try to save this 
		vehicle again.  If this problem persists, contact Dash and he'll figure out what's going on.</p>
		
		<pre> <? print_r($_POST) ?> </pre>
		
	<?php } else { ?>

		Use the form below to enter a vehicle or drone into the database.

	<?php }
} else { ?>
	<p>We were unable to save this vehicle in the databse.  We've placed your entries in the fields below along with error messages
	to help you fix this problem.  Make the necessary changes and then click the button to try and save it again.  If these problems
	persist, contact Dash and he'll figure out what's going on.</p>
<?php }

if (!isset($this->gear_id) || !is_numeric($this->gear_id)) { ?>

	<form method="post">
	<fieldset id="enter_vehicle-or-drone"> 
	<legend><label>Enter Vehicle Details</label></legend>
	<p>Required fields are marked <i class="fa fa=fw fa-star"><span>required</span></i>.</p>
	<ol> 
		<li class="fleft w50">
			<?= $this->printLabel("gear", self::REQUIRED, "Vehicle/Drone") ?>
			<input type="text" id="gear" name="gear" value="<?= $this->getValue("gear") ?>" class="w100">
		</li>
		<li class="fleft w50">
			<?= $this->printLabel("gear_category_id", self::REQUIRED, "Vehicle Type"); ?>
			<select id="gear_category_id" name="gear_category_id">
				<option value="" ></option>
				
				<?php $current = $this->getValue("gear_category_id");
				foreach ($this->categories as $category) {
					list($gear_category_id, $parent_category, $gear_category) = array_values($category);
					if(!isset($current_parent_category) || $current_parent_category != $parent_category) {
						if(isset($parent_optgroup_open) && $parent_optgroup_open) echo "</optgroup>"; ?>
						
						<optgroup label="<?= $parent_category ?>">
						
						<?php $current_parent_category = $parent_category;
						$parent_optgroup_open = true;
					} ?>
					
					<option value="<?= $gear_category_id ?>" <?= $gear_category_id == $current ? "selected" : ""?>><?= $gear_category ?></option>
				<?php } ?>
				
				</optgroup>
			</select>
		</li>
		<li class="cleft">
			<?= $this->printLabel("description") ?>
			<textarea id="description" name="description" class="w100 large"><?= $this->getValue("description") ?></textarea>
		</li>
		<li>
			<?= $this->printLabel("wireless_bonus") ?>
			<textarea id="wireless_bonus" name="wireless_bonus" class="w100 small"><?= $this->getValue("wireless_bonus") ?></textarea>
		</li>
		<li>
			<fieldset id="attributes">
			<legend><label>Attributes</label></legend>
			<ol class="nopad columns four_columns w66">
				<?php $count = sizeof($this->attributes);
				foreach ($this->attributes as $attribute_id => $attribute) {
					$id = "attribute_" . $attribute_id; ?>
					<li>
						<?= $this->printLabel($id, self::REQUIRED, ucfirst($attribute), true) ?>
						<input type="text" id="<?= $id ?>" name="attributes[<?= $attribute_id ?>]" min="0" max="50" value="<?= $this->getValue("attributes", 0, $attribute_id)?>" class="w90">
					</li>
				<?php } ?>
			</ol>
			</fieldset>
		</li>
		<li class="fleft w20">
			<?= $this->printLabel("availability", self::REQUIRED) ?>
			<input type="text" id="availability" name="availability" value="<?= $this->getValue("availability") ?>" class="w100">
		</li>
		<li class="fleft w20">
			<?= $this->printLabel("legality", self::REQUIRED) ?>
			<select id="legality" name="legality" class="w100">
				<?php $current = $this->getValue("legality"); ?>
				<option value="">Legal</option>
				<option value="R" <?= $current=="R" ? "selected" : "" ?>>Restricted</option>
				<option value="F" <?= $current=="F" ? "selected" : "" ?>>Forbidden</option>
			</select>
		</li>
		<li class="fleft w20">
			<?= $this->printLabel("cost", self::REQUIRED) ?>
			<input type="text" id="cost" name="cost" value="<?= $this->getValue("cost") ?>" class="w90">&yen;
		</li>
		<li class="cleft fleft">
			<?= $this->printLabel("book_id", self::REQUIRED, "Book"); ?>
			<select id="book_id" name="book_id">
				<option value=""></option>
				<?php $current = $this->getValue("book_id", -1);
				foreach ($this->books as $book_id => $book) { ?>
					<option value="<?= $book_id ?>" <?= $book_id==$current ? "selected" : "" ?>><?= $book ?></option>
				<?php } ?>
			</select>
		</li>
		<li class="fleft">
			<?= $this->printLabel("page", self::REQUIRED); ?>
			<input type="text" id="page" name="page" value="<?= $this->getValue("page") ?>" class="w50">
		</li>
		<li class="cleft">
			<button type="submit"><i class="fa fa-fw fa-save"></i> Save Vehicle</button>
		</li>
	</ol>
	</fieldset>
	</form>
	
	<script type="text/javascript">
		$(document).ready(function() { $("#gear").focus(); });
	</script>
<?php }
