<?php

/**
 * Returns byte corresponding to given entity.
 */
function offset($name) {
    $bytes = [
        8 => 'NAME',
        
        124 => 'EXPERIENCE',
        128 => 'GOLD',
        136 => 'HP',
        138 => 'HP_MAX',
        140 => 'BODY_RACE',
        141 => 'BODY_CLOTHES',
        144 => 'COLOR_METAL',
        145 => 'COLOR_MINOR',
        146 => 'COLOR_MAJOR',
        147 => 'COLOR_SKIN',
        148 => 'COLOR_LEATHER',
        149 => 'COLOR_ARMOR',
        150 => 'COLOR_HAIR',
        152 => 'PORTRAIT_SMALL',
        160 => 'PORTRAIT_LARGE',
        168 => 'REPUTATION',
        170 => 'AC',
        172 => 'AC_EFFECTIVE',
        174 => 'AC_CRUSHING',
        176 => 'AC_MISSILE',
        178 => 'AC_PIERCING',
        180 => 'AC_SLASHING',
        182 => 'THAC0',
        183 => 'ATTACKS',
        184 => 'SAVE_DEATH',
        185 => 'SAVE_WAND',
        186 => 'SAVE_POLYMORPH',
        187 => 'SAVE_BREATH',
        188 => 'SAVE_SPELL',
        189 => 'RESISTANCE_FIRE',
        190 => 'RESISTANCE_COLD',
        191 => 'RESISTANCE_ELECTRICITY',
        192 => 'RESISTANCE_ACID',
        193 => 'RESISTANCE_MAGIC',
        194 => 'RESISTANCE_MAGIC_FIRE',
        195 => 'RESISTANCE_MAGIC_COLD',
        196 => 'RESISTANCE_SLASHING',
        197 => 'RESISTANCE_CRUSHING',
        198 => 'RESISTANCE_PIERCING',
        199 => 'RESISTANCE_MISSILE',
        200 => 'DETECT_ILLUSION',
        202 => 'LORE',
        203 => 'OPEN_LOCKS',
        204 => 'HIDE_IN_SHADOWS',
        205 => 'FIND_TRAPS',
        206 => 'PICK_POCKETS',
        207 => 'FATIGUE',
        208 => 'INTOXICATION',
        209 => 'LUCK',
        210 => 'LARGE_SWORD',
        211 => 'SMALL_SWORD',
        212 => 'BOW',
        213 => 'SPEAR',
        214 => 'BLUNT',
        215 => 'SPIKED',
        216 => 'AXE',
        217 => 'MISSILE',
        
        230 => 'TURN_UNDEAD',
        
        664 => 'CLASS1_LV',
        665 => 'CLASS2_LV',
        666 => 'CLASS3_LV',
        668 => 'STRENGTH',
        669 => 'STRENGTH_MULTIPLIER',
        670 => 'INTELLIGENCE',
        671 => 'WISDOM',
        672 => 'DEXTERITY',
        673 => 'CONSTITUTION',
        674 => 'CHARISMA',
        675 => 'MORALE',
        676 => 'MORALE_BREAK',
        677 => 'RACIAL_ENEMY',
        678 => 'MORALE_RECOVERY',
        
        682 => 'MAGIC_SCHOOL',
        
        724 => 'ALLEGIANCE',
        725 => 'GENERAL',
        726 => 'RACE',
        727 => 'CLASS',
        728 => 'SPECIFIC',
        729 => 'SEX',
        
        735 => 'ALIGNMENT',
    ];
    
    $key = array_search($name, $bytes);
    
    if ($key === false) {
        trigger_error("'$name' is not a valid byte identifier", E_USER_ERROR);
    }
    
    return $key;
}