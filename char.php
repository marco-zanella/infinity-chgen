<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'lib/autoloader.php';

// Reads base character
$mapper = new \DataMapper\CharacterMapper();
$char = $mapper->read('CHAR.CHR');


// Modifies character with given infos
foreach ($_POST as $attribute => $value) {
    if (is_array($value)) {
        continue;
    }
    $char->$attribute = $value;
}
$char->armor_class_effective = $char->armor_class_natural;


// Modifies memorizable spells
$char->memorizable_spells = $_POST['memorizable_spells'];


// Modifies known spells
$char->known_spells = isset($_POST['known_spells']) ? $_POST['known_spells'] : [];


// Modifies memorized spells
// TODO!!!


// Modifies innate spells
$innate_spells = [];
foreach ($_POST['innate_spells'] as $spell => $quantity) {
	for ($i = 0; $i < $quantity; ++$i) {
		$innate_spells[] = $spell;
	}
}
$known_spells = $char->known_spells;
$known_spells['innate'] = $innate_spells;
$char->known_spells = $known_spells;

$memorized_spells = $char->memorized_spells;
$memorized_spells['innate'] = $innate_spells;
$char->memorized_spells = $memorized_spells;


// Modifies items
$items = $char->items;
foreach ($_POST['items'] as $slot => $data) {
	if (empty($data['name'])) {
		$items[$slot] = null;
		continue;
	}
	$item = new \Model\Section();
	foreach ($data as $field => $value) {
		$item->$field = $value;
	}
	$items[$slot] = $item;
}
$char->items = $items;
//echo "<pre>"; var_dump($char); echo "</pre>";


// Creates a temporary CHR file
$filename = tempnam(sys_get_temp_dir(), 'chr_');
$mapper->create($char, $filename);


// Sends CHR file to client and deletes temporary file
header('Content-Disposition: attachment; filename="CHAR.CHR"');
echo file_get_contents($filename);
unlink($filename);