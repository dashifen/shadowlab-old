<?php if(!is_array($this->spirits) || sizeof($this->spirits) <= 0) { ?>

	<p>We could not find any spirits in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any of them, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>
	
	<div style="overflow: hidden">

		<?php foreach ($this->spirits as $i => $spirit) {
			extract($spirit);
			
			$attr_row_one = array_slice($attributes, 0, 8, true);
			$attr_row_two = array_slice($attributes, 8, NULL, true); ?>
		
			<div class="spirit w50 relative">
				<h3 class="no-form"><?= $critter ?></h3>

				<form>
					<label for="level_<?=$critter_id?>">Level:</label>
					<select id="level_<?=$critter_id?>">
						<option value="0"></option>
						<?php for($i=1; $i<=12; $i++) { ?>
							<option value="<?=$i?>"><?=$i?></option>
						<? } ?>
					</select>
				</form>
				
				
				<table class="w100 t l r no-highlight" style="table-layout: fixed">
				<tbody class="with-color">
					<tr class="b headers">
						<?php foreach (array_keys($attr_row_one) as $attribute) { ?>
							<th colspan="5" class="aligncenter" style="width: 56px;"><abbr title="<?=ucfirst($attribute)?>"><?=strtoupper(substr($attribute,0,1))?></abbr></th>
						<? } ?>
					</tr>
					<tr class="b">
						<?php foreach ($attr_row_one as $attribute => $rating) {
							$rating = $rating > 0 ? "F+$rating" : ($rating < 0 ? "F$rating" : "F"); ?>
							<td colspan="5" class="aligncenter" data-original="<?= $rating ?>"><?= $rating ?></td>
						<?php } ?>
					</tr>
					<tr class="b">
						<?php foreach(array_keys($attr_row_two) as $attribute) { ?>
							<th colspan="5" class="aligncenter">
								<abbr title="<?=ucfirst($attribute)?>">
									<?=strtoupper(substr($attribute, 0, ($attribute != "magic" ? 2 : 1)))?>
								</abbr>
							</th>
						<? } ?>
						
						<th colspan="12" class="aligncenter"><abbr title="Astral Initiative">A<span>stral </span>Init<span>iative</span></abbr></th>
						<th colspan="13" class="aligncenter"><abbr title="Physical Initiative">P<span>hysical </span>Init<span>iative</span></abbr></th>
					</tr>
					<tr class="b">
						<?php foreach ($attr_row_two as $attribute => $rating) {
							$rating = $rating > 0 ? "F+$rating" : ($rating < 0 ? "F$rating" : "F"); ?>
							<td colspan="5" class="aligncenter" data-original="<?= $rating ?>"><?= $rating ?></td>
						<? }
						
						$physical_init = $physical_init != 0
							? ($physical_init > 0 ? "((Fx2)+$physical_init)+2d6" : "((Fx2)$physical_init)+2d6")
							: "(Fx2)+2d6";
							
						$astral_init = $astral_init != 0
							? ($astral_init > 0 ? "((Fx2)+$astral_init)+3d6" : "((Fx2)$astral_init)+3d6")
							: "(Fx2)+3d6"; ?>
						
						<td colspan="12" class="aligncenter" data-original="<?= $astral_init ?>"><?= $astral_init ?></td>
						<td colspan="13" class="aligncenter" data-original="<?= $physical_init ?>"><?= $physical_init ?></td>
					</tr>
					<tr class="b headers">
						<th colspan="13" scope="row" class="r">Description:</th>
						<td colspan="27">
							<?= !empty($description)
								? sprintf("%s (p. %d, %s)", $description, $page, $abbr)
								: sprintf("p. %d, %s", $page, $abbr); ?>
						</td>
					</tr>
					
					<?php if (!empty($weaknesses)) { ?>
						<tr class="b headers">
							<th colspan="13" scope="row" class="r">Weaknesses:</th>
							<td colspan="27"><?= $weaknesses ?></td>
						</tr>
					<?php } ?>
											
					<tr class="b headers">
						<th colspan="13" scope="row" class="r">Skills:</th>
						<td colspan="27"><?= $skills ?></td>
					</tr>
					<tr class="b headers">
						<th colspan="13" scope="row" class="r">Powers:</th>
						<td colspan="27" class="commas">
							<?php foreach ($powers as $power) {
								$name = strtolower(preg_replace("/[\s\W]+/", "_", $power)); ?>
								<span><a href="/cheatsheets/magic/spirit-powers?name=<?= $name ?>&title=<?= $power ?>" class="dialog"><?= $power ?></a></span>
							<?php } ?>
						</td>
					</tr>
					<tr class="b headers">
						<th colspan="13" scope="row" class="r">Optional Powers:</th>

						<?php $list = "";
						$format = '<span><a href="/cheatsheets/magic/spirit-powers?name=%s&title=%s" class="dialog">%s</a></span>';
						
						foreach ($opt_powers as $power) {
							$name  = strtolower(preg_replace("/[\s\W]+/", "_", $power));
							$list .= sprintf($format, $name, $power, $power);
						} ?>

						<td colspan="27">
							<span class="commas optional-powers"><?= $list ?></span>
							<span class="commas hidden"><?= $list ?></span>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
	
		<?php } ?>
		
	</div>
	
	<style type="text/css">
		div.spirit form {
			position: absolute;
			right: 1rem;
			top: 24px;
		}
		
		h3.no-form + form { visibility: hidden; }
		
		div.spirit { float: left; }
		div.spirit:nth-child(odd)    { padding-right: 1rem; }
		div.spirit:nth-child(even)   { padding-left:  1rem; }		
		div.spirit:nth-of-type(n+3)  { margin-top: 2rem;    }		
		div.spirit:nth-of-type(2n+1) { clear: left;         }
		
		.commas span:not(:last-child):after { content: ", "; }
	</style>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("h3").css("cursor", "pointer").click(function() {
				var header = $(this);
				
				$(".spirit.hidden").removeClass("hidden").find("h3").addClass("no-form");
				
				if (header.is(".no-form")) {
					header.removeClass("no-form").parents(".spirit").siblings().addClass("hidden");
				} else {
					header.addClass("no-form")
						.parents(".spirit").find("[data-original]").each(function() { $(this).text($(this).data("original")); })
						.parents(".spirit").find("select").prop("selectedIndex", 0);
						
					var optional_powers = header.parents(".spirit").find(".optional-powers");
					optional_powers.html(optional_powers.next("span").html());
				}
			});
			
			$(".spirit form select").change(function() {
				var dropdown = $(this);
				var value = dropdown.val();
				var cells = dropdown.parents(".spirit").find("[data-original]");
				
				cells.each(function() {
					var cell = $(this);
					var text = cell.data("original");
					
					if (value == 0) cell.text(text);
					else {
						text = text.replace("F", value);
						
						if (text.indexOf("d6") != -1) {
							var matches = text.match(/(\d+)d6/);
							var pool = matches[1];
							
							var sum = 0;
							for (var i=0; i<pool; i++) {
								sum += Math.floor(Math.random() * 6) + 1;
							}
							
							text = text.replace("F", value);
							text = text.replace(pool+"d6", sum);
							text = text.replace("x", "*");
						}
						
						var text = eval(text);
						if(text <= 0) text = 1;
						cell.text(text);
					}
				});
				
				if (value > 0) {
					var chosen = "";
					var power_count = Math.floor(value/3);
					if (power_count > 0) {
						var powers = $.makeArray(dropdown.parents(".spirit").find(".optional-powers span"));
						for (var i=0; i < power_count; ++i) {
							powers  = shuffle(powers);
							chosen += powers.pop().outerHTML;
						}
					}
					
					dropdown.parents(".spirit").find(".optional-powers").html(chosen);
				} else {
					var powers = dropdown.parents(".spirit").find(".optional-powers");
					powers.html(powers.next("span").html());
				}
					
				$("a.dialog").click($.proxy(Globals.loadDialog, Globals));
			});
		});
		
		function shuffle(array) {
			// source: http://stackoverflow.com/a/2450976
			
			var currentIndex = array.length, temporaryValue, randomIndex ;
			
			// While there remain elements to shuffle...
			while (0 !== currentIndex) {
				
				// Pick a remaining element...
				randomIndex   = Math.floor(Math.random() * currentIndex);
				currentIndex -= 1;
				
				// And swap it with the current element.
				temporaryValue = array[currentIndex];
				array[currentIndex] = array[randomIndex];
				array[randomIndex] = temporaryValue;
			}
			
			return array;
		}
	</script>
	
<?php } ?>