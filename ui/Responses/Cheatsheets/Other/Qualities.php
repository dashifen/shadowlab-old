<?php if(!is_array($this->qualities) || sizeof($this->qualities) <= 0) { ?>

    <p>We could not find any qualities in the database at this time.  Frankly, this is probably just a bug.
	Unless Dash deleted his own databases.  Either way, try going back a page and then returning to this one using
	the same link or button as last time.  If we still couldn't find any qualities, then contact Dash and he'll get
	to the bottom of it.</p>

<?php } else { ?>

    <form class="searchbar">
        <fieldset>
            <ol>
				<li><label for="name">Quality</label><input type="text" id="name" name="name" class="w15"></li>
				<li><label class="no-colon"><input type="checkbox" id="freakish"  name="freakish"  value="Y"> Freakish</label></li>					
				<li><label class="no-colon"><input type="checkbox" id="adept_way" name="adept_way" value="Y"> Adept Way</label></li>					
				<li><input type="reset" class="awesome" value="Reset"></li>
			</ol>
			<ol>
                <li>
                    <label for="sign">Show<span class="visuallyhidden"> Type</span></label>
                    <select id="sign" name="sign">
                        <option value="all">All Qualities</option>
                        <option value="positive">Positive Qualities</option>
						<option value="negative">Negative Qualities</option>
                    </select>
                </li>
				<li>
					<label for="metagenetic" class="visuallyhidden">Show Metagenetics</label>
					<select id="metagenetic" name="metagenetic">
						<option value="all">Metagenetic and Non-Metagenetic Qualities</option>
						<option value="N">Only Non-Metagenetic Qualities</option>
						<option value="Y">Only Metagenetic Qualities</option>
					</select>				
				</li>
				<li>
					<label for="book" class="visuallyhidden">Show Book</label>
					<select id="book" name="book">
						<option value="all">All Books</option>
						<?php foreach($this->books as $book_id => $book) { ?>
							<option value="<?= $book_id ?>"><?= $book ?></option>
						<?php } ?>
					</select>
				</li>
			</ol>
        </fieldset>
    </form>

    <table class="w100 t l r searchable summarized">
        <thead>
			<tr class="b">
				<th scope="col" id="quality">Quality</th>
				<th scope="col" id="metagenetic" class="icon aligncenter"><abbr title="Metagenetic">M<span>etagenetic</span></abbr></th>
				<th scope="col" id="freakish" class="icon aligncenter"><abbr title="Freakish">F<span>reakish</span></abbr></th>
				<th scope="col" id="max" class="w10  aligncenter">Max</th>
				<th scope="col" id="cost" class="w15  aligncenter">Cost</th>
			</tr>
        </thead>
        <tbody>

        <?php foreach($this->qualities as $i => $quality) {
			$row = uniqid("quality_");
			extract($quality);
			
			$cost = !empty($rated_cost) ? $rated_cost : $specific_cost;
			$sign = substr($cost, 0, 1) == "-" ? "negative" : "positive"; ?>

            <tr class="b summary <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $quality ?>" 
				data-book="<?= $book_id ?>"
				data-adept_way="<?= $is_way ?>"
				data-metagenetic="<?= $metagenetic ?>"
				data-freakish="<?= $freakish=="Y" ? 1 : 0 ?>"
				data-sign="<?= $sign ?>"
			>
                <th scope="row" id="<?= $row ?>" headers="quality"><a href="#"><?= $quality ?></a></th>
                <td headers="<?= $row ?> metagenetic" class="aligncenter"><?= $metagenetic=="Y" ? "Y" : "&nbsp;" ?></td>
                <td headers="<?= $row ?> freakish" class="aligncenter"><?= $freakish=="Y" ? "Y" : "&nbsp;" ?></td>
                <td headers="<?= $row ?> max" class="aligncenter"><?= $max_rating != 1 ? $max_rating : "&nbsp;" ?></td>
				<td headers="<?= $row ?> cost" class="aligncenter"><?= $cost ?></td>
            </tr>
            
			<tr class="b description hidden <?= $i%2==0?"odd":"even" ?>"
				data-name="<?= $quality ?>" 
				data-book="<?= $book_id ?>"
				data-adept_way="<?= $is_way ?>"
				data-metagenetic="<?= $metagenetic=="Y" ? 1 : 0 ?>"
				data-freakish="<?= $freakish=="Y" ? 1 : 0 ?>"
				data-sign="<?= $sign ?>"
			>
                <td colspan="5" class="padb">
                    <p><?= nl2br($description) ?></p>
					
					<?php if ($freakish == "Y") { ?>
						<p>People consider those with this quality to be freakish.  This means you face a -1 
						dice pool modifier for all Social tests.  For every	three "freakish" qualities that you 
						take, your Social Limit is reduced by 1.  For more information, see p. 123, RF.</p>
					<?php }
					
					if (!$is_way && is_array($subqualities)) { ?>
						<ul>
							<?php foreach($subqualities as $subquality) {
								extract($subquality); ?>
								
								<li>
									<strong><?= $quality ?></strong> (<?= $cost ?> Karma)<br>
									<?php if (!empty($description)) {
										echo nl2br($description);
									} ?>
								</li>
							<?php } ?>
						</ul>
					<?php }
					
					elseif ($is_way && is_array($powers) && sizeof($powers) > 0) { ?>
						<p>For every 2 points in an adept's Magic Rating, that adept may reduce the cost of 
						one level of one power from the following list by half.  This cost reduction cannot 
						be used multiple times if the power has multiple levels; the reduction applies to 
						one level, but can be used for different aspects of the same power, such as a different 
						Increased Attribute.   If an adept follows  a  Way  and  increases  his  Magic Rating  
						through Initiation, he may use this discount every time he adds two points to his Magic 
						Rating.</p>
						
						<ul>
							<?php foreach($powers as $power) {
								$name = strtolower(preg_replace("/[\s\W]+/", "_", $power)); ?>
								<li><a class="dialog" href="/cheatsheets/magic/adept-powers?name=<?= $name ?>"><?= $power ?></a></li>
							<?php } ?>
						</ul>
						
					<?php } ?>
					
					
                    <p>(p. <?= $page ?>, <?= $abbr ?>)</td></p>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

<?php } ?>