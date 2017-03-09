<fieldset id="general">
	<legend>General</legend>
		
	<!-- Name -->
	<div class="form-group">
		<label for="name" class="col-sm-3 control-label">Name</label>
		<div class="col-sm-9">
			<input type="text" name="name" id="name" class="form-control" placeholder="Name" required="required" />
		</div>
	</div>
	
	<!-- Sex -->
	<div class="form-group">
		<label for="sex" class="col-sm-3 control-label">Sex</label>
		<div class="col-sm-9">
			<select name="sex" id="sex" class="form-control">
				<option value="male">male</option>
				<option value="female">female</option>
			</select>
		</div>
	</div>
	
	<!-- Race -->
	<div class="form-group">
		<label for="race" class="col-sm-3 control-label">Race</label>
		<div class="col-sm-9">
			<select name="race" id="race" class="form-control">
				<option value="human">human</option>
				<option value="elf">elf</option>
				<option value="half-elf">half-elf</option>
				<option value="gnome">gnome</option>
				<option value="halfling">halfling</option>
				<option value="dwarf">dwarf</option>
			</select>
		</div>
	</div>
	
	<!-- Class -->
	<div class="form-group">
		<label for="class" class="col-sm-3 control-label">Class</label>
		<div class="col-sm-9">
			<select name="class" id="class" class="form-control">
				<option value="fighter">fighter</option>
				<option value="ranger">ranger</option>
				<option value="paladin">paladin</option>
				<option value="cleric">cleric</option>
				<option value="druid">druid</option>
				<option value="mage">mage</option>

				<option value="thief">thief</option>
				<option value="bard">bard</option>


				<option value="fighter-thief">fighter/thief</option>
				<option value="fighter-cleric">fighter/cleric</option>
				<option value="fighter-mage">fighter/mage</option>

				<option value="mage-thief">mage/thief</option>

				<option value="cleric-mage">cleric/mage</option>
				<option value="cleric-thief">cleric/thief</option>

				<option value="fighter-druid">fighther/druid</option>

				<option value="cleric-ranger">cleric/ranger</option>

				<option value="fighter-mage-thief">fighter/mage/thief</option>
				<option value="fighter-mage-cleric">fighter/mage/cleric</option>
			</select>
		</div>
	</div>
	
	<!-- Magic school -->
	<div class="form-group">
		<label for="magic-school" class="col-sm-3 control-label">School of Magic</label>
		<div class="col-sm-9">
			<select name="magic-school" id="magic-school" class="form-control">
				<option value="none">none</option>
				<option value="alteration">alteration</option>
				<option value="abjuration">abjuration</option>
				<option value="conjuration-summoning">conjuration/summoning</option>
				<option value="divination">divination</option>
				<option value="enchantment-charm">enchantment/charm</option>
				<option value="evocation-invocation">evocation/invocation</option>
				<option value="illusion-phantasm">illusion/phantasm</option>
				<option value="necromancy">necromancy</option>
			</select>
		</div>
	</div>
	
	<!-- Alignment -->
	<div class="form-group">
		<label for="alignment" class="col-sm-3 control-label">Alignment</label>
		<div class="col-sm-9">
			<select name="alignment" id="alignment" class="form-control">
				<option value="lawful-good">lawful good</option>
				<option value="neutral-good">neutral good</option>
				<option value="chaotic-good">chaotic good</option>

				<option value="lawful-neutral">lawful neutral</option>
				<option value="true-neutral">true neutral</option>
				<option value="chaotic-neutral">chaotic neutral</option>

				<option value="lawful-evil">lawful evil</option>
				<option value="neutral-evil">neutral evil</option>
				<option value="chaotic-evil">chaotic evil</option>
			</select>
		</div>
	</div>
</fieldset>