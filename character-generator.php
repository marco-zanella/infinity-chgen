<?php
require_once 'ByteArray.php';
require_once 'offset.php';
require_once 'lookup.php';
require_once 'binary_data.php';


// Reads sample character file
$data = ByteArray::read("SAMPLE.CHR");


// General
set_string($data, 'NAME', $_POST['name']);
set_byte($data, 'SEX',          gender_lookup($_POST['sex']));
set_byte($data, 'RACE',         race_lookup($_POST['race']));
set_byte($data, 'CLASS',        class_lookup($_POST['class']));
set_byte2($data, 'MAGIC_SCHOOL',  magic_lookup($_POST['magic-school']));
set_byte($data, 'ALIGNMENT',    alignment_lookup($_POST['alignment']));


// Abilities
set_byte($data, 'STRENGTH',     $_POST['strength']);
set_byte($data, 'STRENGTH_MULTIPLIER', $_POST['strength-multiplier']);
set_byte($data, 'DEXTERITY',    $_POST['dexterity']);
set_byte($data, 'CONSTITUTION', $_POST['constitution']);
set_byte($data, 'INTELLIGENCE', $_POST['intelligence']);
set_byte($data, 'WISDOM',       $_POST['wisdom']);
set_byte($data, 'CHARISMA',     $_POST['charisma']);


// Miscellaneous
set_int($data, 'EXPERIENCE', $_POST['experience']);
set_byte($data, 'CLASS1_LV', $_POST['class1-lv']);
set_byte($data, 'CLASS2_LV', $_POST['class2-lv']);
set_byte($data, 'CLASS3_LV', $_POST['class3-lv']);
set_int($data, 'GOLD', $_POST['gold']);
set_byte2($data, 'HP', $_POST['hp']);
set_byte2($data, 'HP_MAX', $_POST['hp-max']);
set_byte($data, 'REPUTATION', $_POST['reputation']);
set_byte($data, 'THAC0', $_POST['THAC0']);
set_byte($data, 'ATTACKS', $_POST['attacks']);
set_byte($data, 'LORE', $_POST['lore']);
set_byte($data, 'TURN_UNDEAD', $_POST['turn-undead']);
set_byte($data, 'RACIAL_ENEMY', 0x68); // Racial enemny: to do!!!
set_byte($data, 'MORALE', $_POST['morale']);
set_byte($data, 'MORALE_BREAK', $_POST['morale-break']);
set_byte($data, 'MORALE_RECOVERY', $_POST['morale-recovery']);


// Resistance
set_byte($data, 'RESISTANCE_FIRE',        $_POST['res-fire']);
set_byte($data, 'RESISTANCE_COLD',        $_POST['res-cold']);
set_byte($data, 'RESISTANCE_ELECTRICITY', $_POST['res-electricity']);
set_byte($data, 'RESISTANCE_ACID',        $_POST['res-acid']);
set_byte($data, 'RESISTANCE_MAGIC',       $_POST['res-magic']);
set_byte($data, 'RESISTANCE_MAGIC_FIRE',  $_POST['res-magic-fire']);
set_byte($data, 'RESISTANCE_MAGIC_COLD',  $_POST['res-magic-cold']);
set_byte($data, 'RESISTANCE_SLASHING',    $_POST['res-slashing']);
set_byte($data, 'RESISTANCE_CRUSHING',    $_POST['res-crushing']);
set_byte($data, 'RESISTANCE_PIERCING',    $_POST['res-piercing']);
set_byte($data, 'RESISTANCE_MISSILE',     $_POST['res-missile']);


// Armor Class
set_byte2($data, 'AC',           $_POST['ac']);
set_byte2($data, 'AC_EFFECTIVE', $_POST['ac-effective']);
set_byte2($data, 'AC_CRUSHING',  $_POST['ac-crushing']);
set_byte2($data, 'AC_MISSILE',   $_POST['ac-missile']);
set_byte2($data, 'AC_PIERCING',  $_POST['ac-piercing']);
set_byte2($data, 'AC_SLASHING',  $_POST['ac-slashing']);


// Save Throws
set_byte($data, 'SAVE_DEATH',     $_POST['st-death']);
set_byte($data, 'SAVE_WAND',      $_POST['st-wand']);
set_byte($data, 'SAVE_POLYMORPH', $_POST['st-polymorph']);
set_byte($data, 'SAVE_BREATH',    $_POST['st-breath']);
set_byte($data, 'SAVE_SPELL',     $_POST['st-spell']);


// Appearance
set_string($data, 'PORTRAIT_SMALL', $_POST['portrait-small'] . "S\0");
set_string($data, 'PORTRAIT_LARGE', $_POST['portrait-large'] . "L\0");
set_byte($data, 'BODY_RACE', body_race_lookup($_POST['body-sex'] . "_" . $_POST['body-race']));

// Warning: mage body model for halfling does not exist in the game, cleric is used
if ($_POST['body-race'] === 'halfling' && $_POST['body-clothes'] === 'mage') {
    set_byte($data, 'BODY_CLOTHES', clothes_lookup('cleric'));
} else {
    set_byte($data, 'BODY_CLOTHES', clothes_lookup($_POST['body-clothes']));
}


// Skills
set_byte($data, 'PICK_POCKETS',    $_POST['pick-pockets']);
set_byte($data, 'OPEN_LOCKS',      $_POST['open-locks']);
set_byte($data, 'FIND_TRAPS',      $_POST['find-traps']);
set_byte($data, 'HIDE_IN_SHADOWS', $_POST['hide-in-shadows']);


// Proficiency
set_byte($data, 'AXE',         $_POST['axe']);
set_byte($data, 'BLUNT',       $_POST['blunt']);
set_byte($data, 'BOW',         $_POST['bow']);
set_byte($data, 'LARGE_SWORD', $_POST['large-sword']);
set_byte($data, 'MISSILE',     $_POST['missile']);
set_byte($data, 'SMALL_SWORD', $_POST['small-sword']);
set_byte($data, 'SPEAR',       $_POST['spear']);
set_byte($data, 'SPIKED',      $_POST['spiked']);


// Outputs generated character file
header('Content-Disposition: attachment; filename="CHAR.CHR"');
echo $data->raw();
