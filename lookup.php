<?php

function lookup($table, $name) {
    if (!array_key_exists($name, $table)) {
        trigger_error("'$name' is not a valid identifier", E_USER_ERROR);
    }
    
    return $table[$name];
}


function gender_lookup($name) {
    $sex = [
        'male'   => 1,
        'female' => 2
    ];
    return lookup($sex, $name);
}


function race_lookup($name) {
    $race = [
        'human'    => 1,
        'elf'      => 2,
        'half-elf' => 3,
        'gnome'    => 6,
        'halfling' => 5,
        'dwarf'    => 4
    ];
    return lookup($race, $name);
}


function class_lookup($name) { // Not fully working
    $class = [
        'fighter' => 2,
        'ranger'  => 12, // Not working
        'paladin' => 6,
        'cleric'  => 3,
        'druid'   => 11,
        'mage'    => 1,
        'thief'   => 4,
        'bard'    => 5,
        'fighter-thief'  => 9,
        'fighter-cleric' => 8,
        'fighter-mage'   => 7,
        'mage-thief'     => 13,
        'cleric-mage'    => 14,
        'cleric-thief'   => 15,
        'fighter-druid'  => 16,
        'cleric-ranger'  => 18,
        'fighter-mage-thief'  => 10,
        'fighter-mage-cleric' => 17
    ];
    return lookup($class, $name);
}


function magic_lookup($name) {
    $magic_school = [
        'none'                  => 0x4000,
        'alteration'            => 0x2000,
        'abjuration'            => 0x0040,
        'conjuration-summoning' => 0x0800,
        'divination'            => 0x0100,
        'enchantment-charm'     => 0x0200,
        'evocation-invocation'  => 0x0080,
        'illusion-phantasm'     => 0x0400,
        'necromancy'            => 0x1000
    ];
    return lookup($magic_school, $name);
}


function alignment_lookup($name) {
    $alignment = [
        'lawful-good'     => 0x11,
        'lawful-neutral'  => 0x12,
        'lawful-evil'     => 0x13,
        'neutral-good'    => 0x21,
        'true-neutral'    => 0x22,
        'neutral-evil'    => 0x23,
        'chaotic-good'    => 0x31,
        'chaotic-neutral' => 0x32,
        'chaotic-evil'    => 0x33
    ];
    return lookup($alignment, $name);
}



function body_race_lookup($name) {
    $body_race = [
        'male_human'      => 0x0,
        'female_human'    => 0x10,
        'male_elf'        => 0x1,
        'female_elf'      => 0x11,
        'male_half-elf'   => 0x1,
        'female_half-elf' => 0x11,
        'male_halfling'   => 0x3,
        'female_halfling' => 0x13,
        'male_gnome'      => 0x2,
        'female_gnome'    => 0x12,
        'male_dwarf'      => 0x2,
        'female_dwarf'    => 0x12,
    ];
    return lookup($body_race, $name);
}


function clothes_lookup($name) {
    $clothes = [
        'fighter' => 0x61,
        'cleric'  => 0x60,
        'thief'   => 0x63,
        'mage'    => 0x62
    ];
    return lookup($clothes, $name);
}