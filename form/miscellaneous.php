<fieldset>
	<legend>Miscellaneous</legend>
	
	<!-- Experience -->
	<div class="form-group">
		<label for="experience" class="col-sm-3 control-label">Experience</label>
		<div class="col-sm-9">
			<input type="number" min="0" max="1000000000" name="experience" value="0" id="experience" class="form-control" placeholder="0" required="required" />
		</div>
	</div>
	
	<!-- Level -->
	<div class="form-group">
		<label for="class1-lv" class="col-sm-3 control-label">Level</label>
		<div class="col-sm-3">
			<input type="number" min="1" max="50" name="class1-lv" value="1" id="class1-lv" class="form-control" placeholder="1" required="required" />
		</div>
		<div class="col-sm-3">
			<input type="number" min="1" max="50" name="class2-lv" value="1" id="class2-lv" class="form-control" placeholder="1" required="required" />
		</div>
		<div class="col-sm-3">
			<input type="number" min="1" max="50" name="class3-lv" value="1" id="class3-lv" class="form-control" placeholder="1" required="required" />
		</div>
	</div>
	
	<!-- Gold -->
	<div class="form-group">
		<label for="gold" class="col-sm-3 control-label">Gold</label>
		<div class="col-sm-9">
			<input type="number" min="0" max="1000000000" name="gold" value="150" id="gold" class="form-control" placeholder="150" required="required" />
		</div>
	</div>
	
	<!-- HP and HP Max -->
	<div class="form-group">
		<label for="hp" class="col-sm-3 control-label">HP / HP Max</label>
		<div class="col-sm-4">
			<input type="number" min="1" max="16383" name="hp" value="1" id="hp" class="form-control" placeholder="1" required="required" />
		</div>
		<div class="col-sm-5">
			<input type="number" min="1" max="16383" name="hp-max" value="1" id="hp-max" class="form-control" placeholder="1" required="required" />
		</div>
	</div>
	
	<!-- Reputation -->
	<div class="form-group">
		<label for="reputation" class="col-sm-3 control-label">Reputation</label>
		<div class="col-sm-9">
			<input type="number" min="0" max="20" name="reputation" value="12" id="reputation" class="form-control" placeholder="12" required="required" />
		</div>
	</div>
	
	<!-- THAC0 -->
	<div class="form-group">
		<label for="THAC0" class="col-sm-3 control-label">THAC0</label>
		<div class="col-sm-9">
			<input type="number" min="-9" max="20" name="THAC0" value="0" id="THAC0" class="form-control" placeholder="0" required="required" />
		</div>
	</div>
	
	<!-- Attacks -->
	<div class="form-group">
		<label for="attacks" class="col-sm-3 control-label">Attacks</label>
		<div class="col-sm-9">
			<input type="number" min="1" max="20" name="attacks" value="1" id="attacks" class="form-control" placeholder="1" required="required" />
		</div>
	</div>
	
	<!-- Lore -->
	<div class="form-group">
		<label for="lore" class="col-sm-3 control-label">Lore</label>
		<div class="col-sm-9">
			<input type="number" min="1" max="100" name="lore" value="1" id="lore" class="form-control" placeholder="1" required="required" />
		</div>
	</div>
	
	<!-- Turn undead -->
	<div class="form-group">
		<label for="turn-undead" class="col-sm-3 control-label">Turn Undead</label>
		<div class="col-sm-9">
			<input type="number" min="0" max="100" name="turn-undead" value="1" id="turn-undead" class="form-control" placeholder="1" required="required" />
		</div>
	</div>
	
	<!-- Racial enemy -->
	<div class="form-group">
		<label for="racial-enemy" class="col-sm-3 control-label">Racial Enemy</label>
		<div class="col-sm-9">
			<select name="racial-enemy" id="racial-enemy" class="form-control" />
				<option value="">To do...</option>
			</select>
		</div>
	</div>
	
	<!-- Morale, morale break, morale recovery -->
	<div class="form-group">
		<label for="morale" class="col-sm-3 control-label">Morale / Break / Recovery</label>
		<div class="col-sm-3">
			<input type="number" min="1" max="100" name="morale" value="1" id="morale" class="form-control" placeholder="1" required="required" />
		</div>
		<div class="col-sm-3">
			<input type="number" min="1" max="100" name="morale-break" value="1" id="morale-break" class="form-control" placeholder="1" required="required" />
		</div>
		<div class="col-sm-3">
			<input type="number" min="1" max="100" name="morale-recovery" value="1" id="morale-recovery" class="form-control" placeholder="1" required="required" />
		</div>
	</div>
</fieldset>