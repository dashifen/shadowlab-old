<?php if(!is_array($this->sprites) || sizeof($this->sprites) <= 0) { ?>

	<p>We could not find any sprites in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any sprites, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

	<div style="overflow: hidden">

		<?php foreach ($this->sprites as $i => $sprite) {
			extract($sprite); ?>
		
			<div class="sprite w50 relative">
				<h3 class="no-form"><?= $critter ?></h3>

				<form>
					<label for="level_<?=$critter_id?>">Level:</label>
					<select id="level_<?=$critter_id?>">
						<option value="0"></option>
						<? for($i=1; $i<=12; $i++) { ?>
							<option value="<?=$i?>"><?=$i?></option>
						<? } ?>
					</select>
				</form>
				
				
				<table class="w100 t l r no-highlight">
				<tbody class="with-color">
					<tr class="b headers">
						<?php foreach (array_keys($attributes) as $attribute) { ?>
							<th style="width: 50px;"><div class="aligncenter"><abbr title="<?=ucfirst($attribute)?>"><?=strtoupper(substr($attribute,0,1))?></abbr></div></th>
						<? } ?>
						
						<th><div class="aligncenter"><abbr title="Matrix Initiative">M<span>atrix </span>Init<span>iative</span></abbr></div></th>
					</tr>
					<tr class="b">
						<?php foreach ($attributes as $attribute => $rating) {
							$rating = $rating > 0 ? "L+$rating" : ($rating < 0 ? "L$rating" : "L"); ?>
							<td class="aligncenter" data-original="<?= $rating ?>"><?= $rating ?></td>
						<? }
						
						$matrix_init = $matrix_init != 0
							? ($matrix_init > 0 ? "((Lx2)+$matrix_init)+2d6" : "((Lx2)$matrix_init)+2d6")
							: "(Lx2)+2d6"; ?>
						
						<td class="aligncenter" data-original="<?= $matrix_init ?>"><?= $matrix_init ?></td>
					</tr>
					
					<tr class="b headers">
						<th colspan="2" scope="row" class="r">Description:</th>
						<td colspan="4"><?= $description ?> (p. <?= $page ?>, <?= $abbr ?>)</td>
					</tr>
					<tr class="b headers">
						<th colspan="2" scope="row" class="r">Skills:</th>
						<td colspan="4"><?= $skills ?></td>
					</tr>
					<tr class="b headers">
						<th colspan="2" scope="row" class="r">Powers:</th>
						<td colspan="4" class="commas">
							<?php foreach ($powers as $power) { ?>
								<span><a href="/cheatsheets/matrix/sprite-powers?name=<?= $power ?>" class="dialog"><?= $power ?></a></span>
							<?php } ?>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
	
		<?php } ?>
		
	</div>
	
	<style type="text/css">
		div.sprite form {
			position: absolute;
			right: 1rem;
			top: 24px;
		}
		
		h3.no-form + form { visibility: hidden; }
		
		div.sprite { float: left; }
		div.sprite:nth-child(odd)    { padding-right: 1rem; }
		div.sprite:nth-child(even)   { padding-left:  1rem; }		
		div.sprite:nth-of-type(n+3)  { margin-top: 2rem;    }		
		div.sprite:nth-of-type(2n+1) { clear: left;         }
		
		td.commas span:not(:last-child):after { content: ", "; }
	</style>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("h3").css("cursor", "pointer").click(function() {
				var header = $(this);
				
				$(".sprite.hidden").removeClass("hidden").find("h3").addClass("no-form");
				
				if (header.is(".no-form")) {
					header.removeClass("no-form").parents(".sprite").siblings().addClass("hidden");
				} else {
					header.addClass("no-form").parents(".sprite").find("[data-original]").each(function() {
						$(this).text($(this).data("original"));
					});
				}
			});
			
			$(".sprite form select").change(function() {
				var dropdown = $(this);
				var value = dropdown.val();
				var cells = dropdown.parents(".sprite").find("[data-original]");
				
				cells.each(function() {
					var cell = $(this);
					var text = cell.data("original");
					
					if(value == 0) cell.text(text);
					else {
						text = text.replace("L", value);
						
						if (text.indexOf("d6") != -1) {
							var matches = text.match(/(\d+)d6/);
							var pool = matches[1];
							
							var sum = 0;
							for (var i=0; i<pool; i++) {
								sum += Math.floor(Math.random() * 6) + 1;
							}
							
							text = text.replace("L", value);
							text = text.replace(pool+"d6", sum);
							text = text.replace("x", "*");
						}
						
						cell.text(eval(text));
					}
				});
				
				
			});
	
		});
	</script>
	
<?php } ?>