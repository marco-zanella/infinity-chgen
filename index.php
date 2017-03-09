<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Infinity Engine Character Generator</title>

		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		
		
	</head>

	<body>
		<header class="container">
			<div class="page-header">
				<h1>Infinity Engine Character Generator</h1>
			</div>
			<p>
				This is a <em>character creator</em> for the <em>Infinity Engine</em>. You can set your character's attributes (such as abilities, skills and alike) and press the "Generate Character File" button to get your file ready to be imported in your game.
			</p>
			<p>
				Note this tool allows creation of non-legit characters, such as evil paladins or fighter/mage/thief halflings.
			</p>
			<p>
				If you want to contribute, check out <a href="https://github.com/marco-zanella/infinity-chgen">Infinity Engine Character Generator repository on GitHub</a>.
			</p>
		</header>



		<div class="container">
			<form action="character-generator.php" method="POST" class="form-horizontal">
				<div class="col-xs-6">
					<?php include "form/general.php"; ?>
				</div>


				<div class="col-xs-6">
					<?php include "form/abilities.php"; ?>
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<?php include "form/miscellaneous.php"; ?>
				</div>

				
				<div class="col-xs-6">
					<?php include "form/resistance.php"; ?>
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<?php include "form/armor-class.php"; ?>
				</div>

				
				<div class="col-xs-6">
					<?php include "form/save-throws.php"; ?>
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<?php include "form/preview.php"; ?>
				</div>


				<div class="col-xs-6">
					<?php include "form/appearance.php"; ?>
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<?php include "form/skills.php"; ?>
				</div>


				<div class="col-xs-6">
					<?php include "form/proficiency.php"; ?>
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<h3>Priest Known Spells</h3>
					Priest known spells are not supported yet.
				</div>


				<div class="col-xs-6">
					<h3>Priest Memorized Spells</h3>
					Priest memorized spells are not supported yet.
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<h3>Wizard Known Spells</h3>
					Wizard known spells are not supported yet.
				</div>


				<div class="col-xs-6">
					<h3>Wizard Memorized Spells</h3>
					Wizard memorized spells are not supported yet.
				</div>


				<div class="clearfix"></div>


				<div class="col-xs-6">
					<h3>Special Spells</h3>
					Special spells are not supported yet.
				</div>


				<button type="submit" class="btn btn-primary btn-block">Generate Character File</button>
			</form>
		</div>
		
		
		
		<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script>
			function change_portrait_large() {
				$('#img_portrait_large').attr('src', "portraits/" + $('#portrait-large').val() + ".png");
			}
			
			function change_portrait_small() {
				$('#img_portrait_small').attr('src', "portraits/" + $('#portrait-small').val() + ".png");
			}
			
			function change_body_model() {
				var sex     = $('#body-sex').val();
				var race    = $('#body-race').val();
				var clothes = $('#body-clothes').val();
				var model   = sex + "_" + race + "_" + clothes;
				$('#img_body_model').attr('src', "body-models/" + model + ".png");
			}

			$(function() {
				$('#portrait-large').change(change_portrait_large);
				$('#portrait-small').change(change_portrait_small);
				$('#body-sex').change(change_body_model);
				$('#body-race').change(change_body_model);
				$('#body-clothes').change(change_body_model);
				
				change_body_model();
				change_portrait_large();
				change_portrait_small();

				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
	</body>
</html>
