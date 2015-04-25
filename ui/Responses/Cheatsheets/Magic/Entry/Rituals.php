<?php if(sizeof($this->errors) == 0) {
	if (isset($this->ritual_id) && is_numeric($this->ritual_id)) { ?>
			
		<p>The <strong><?=$this->ritual?></strong> ritual has been added to the database.  Click the following button to move onto the next one or wait 3 seconds 
		and we'll automatically reload the ritual form for you.</p>
		
		<form method="get" action="/cheatsheets/magic/rituals/entry">
		<input type="hidden" name="page" value="<?= $this->page ?>">
		<input type="hidden" name="book_id" value="<?= $this->book_id ?>">
		<button id="next"><i class="fa fa-fw fa-angle-double-right"></i> Next Ritual</button>
		</form>
		
		<script type="text/javascript">
			$(document).ready(function() { window.setTimeout(function() { $("#next").click(); }, 3000); });
		</script>
	
	<?php } elseif (isset($this->ritual) && !empty($this->ritual)) { ?>
	
		<p>The most recent ritual added to the database was <strong><?= $this->ritual ?></strong>.</p>
		
	<?php } elseif (isset($this->message) && !empty($this->message)) { ?>
		
		<p><?= $this->message ?></p>
		
	<?php } else { ?>

		Use the form below to enter a spellcasting ritual into the database.

	<?php }
} else { ?>
	<p>We were unable to save this ritual in the databse.  We've placed your entries in the fields below along with error messages
	to help you fix this problem.  Make the necessary changes and then click the button to try and save it again.  If these problems
	persist, contact Dash and he'll figure out what's going on.</p>
<?php }

if (!isset($this->ritual_id) || !is_numeric($this->ritual_id)) { ?>

	<form method="post">
	<fieldset id="enter_ritual_details">
	<legend><label>Enter Ritual Details</label></legend>
	<p>Required fields are marked <i class="fa fa=fw fa-star"><span>required</span></i>.</p>
	<ol>
		<li>
			<?= $this->printLabel("ritual", self::REQUIRED) ?>
			<input type="text" id="ritual" name="ritual" value="<?= $this->getValue("ritual") ?>" class="w33">
		</li>
		<li>
			<fieldset id="ritual_tags">
			<legend><?= $this->printLabel("tags", self::OPTIONAL) ?></legend>
			<ol class="columns four_columns w75">
				<?php $current = $this->getValue("tags", array());
				foreach ($this->ritual_tags as $ritual_tag_id => $ritual_tag) { ?>
					<li>
						<label>
							<input type="checkbox" name="ritual_tags[]" value="<?= $ritual_tag_id ?>">
							&ndash; <?= $ritual_tag ?>
						</label>
					</li>
				<?php } ?>
			</ol>
			</fieldset>
		</li>
		<li>
			<?= $this->printLabel("description", self::REQUIRED) ?>
			<textarea id="description" name="description" class="w100 large"><?= $this->getValue("description") ?></textarea>
		</li>
		<li class="dib fleft marr">
			<?= $this->printLabel("length", self::REQUIRED) ?>
			<div class="select">
			<select id="length" name="length">
				<option value=""></option>
				<?php $current = $this->getValue("length");
				foreach ($this->ritual_lengths as $length) { ?>
					<option value="<?= $length ?>" <?= $length==$current ? "selected" : "" ?>><?= ucfirst($length) ?></option>
				<?php } ?>
			</select>
			</div>
		</li>
		<li class="fleft dib marr">
			<?= $this->printLabel("prerequisite_metamagic_id", self::OPTIONAL, "Prerequisite Metamagic") ?>
			<select id="prerequisite_metamagic_id" name="prerequisite_metamagic_id">
				<option value=""></option>
				<?php $current = $this->getValue("prerequisite_metamagic_id", 0);
				foreach ($this->metamagics as $metamagic_id => $metamagic) { ?>
					<option value="<?= $metamagic_id ?>" <?= $metamagic_id==$current ? "selected" : "" ?>><?= $metamagic ?></option>
				<?php } ?>
			</select>
		</li>
		<li class="fleft dib">
			<?= $this->printLabel("prerequisite_metamagic_school_id", self::OPTIONAL, "Prerequisite Metamagic School") ?>
			<select id="prerequisite_metamagic_school_id" name="prerequisite_metamagic_school_id">
				<option value=""></option>
				<?php $current = $this->getValue("prerequisite_metamagic_school_id", -1);
				foreach ($this->schools as $school_id => $school) { ?>
					<option value="<?= $school_id ?>" <?= $school_id==$current ? "selected" : "" ?>><?= $school ?></option>
				<?php } ?>
			</select>
		</li>
		<li class="fleft dib">
			<?= $this->printLabel("prerequisite_ritual_id", self::OPTIONAL, "Prerequisite Ritual") ?>
			<select id="prerequisite_ritual_id" name="prerequisite_ritual_id">
				<option value=""></option>
				<?php $current = $this->getValue("prerequisite_ritual_id", -1);
				foreach ($this->rituals as $ritual_id => $ritual) { ?>
					<option value="<?= $ritual_id ?>" <?= $ritual_id==$current ? "selected" : "" ?>><?= $ritual ?></option>
				<?php } ?>
			</select>
		</li>
		<li class="cleft fleft dib marr">
			<?= $this->printLabel("book_id", self::REQUIRED, "Book"); ?>
			<div class="select xxl">
				<select id="book_id" name="book_id">
					<option value=""></option>
					<?php $current = $this->getValue("book_id", -1);
					foreach ($this->books as $book_id => $book) { ?>
						<option value="<?= $book_id ?>" <?= $book_id==$current ? "selected" : "" ?>><?= $book ?></option>
					<?php } ?>
				</select>
			</div>
		</li>
		<li class="fleft dib">
			<?= $this->printLabel("page", self::REQUIRED); ?>
			<input type="text" id="page" name="page" value="<?= $this->getValue("page") ?>" class="w50">
		</li>
		<li class="cleft">
			<button type="submit"><i class="fa fa-fw fa-save"></i> Save Ritual Details</button>
		</li>
	</ol>
	</fieldset>
	</form>
	
	<script type="text/javascript">
		$(document).ready(function() { $("#ritual").focus(); });
	</script>
<?php }
