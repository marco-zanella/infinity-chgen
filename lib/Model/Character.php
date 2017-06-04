<?php
namespace Model;

class Character {
    private $fields;

    public function __construct() {
        $this->fields = [];
    }
    
    
    


    public function __get($name) {
        return array_key_exists($name, $this->fields) ? $this->fields[$name] : 0;
    }

    public function __set($name, $value) {
        $this->fields[$name] = $value;
        return $value;
    }
    
    
    public function blank() {
        $this->name = "Alpha";
        $this->quick_weapon_1_index = 0xFFFF;
        $this->quick_weapon_2_index = 0xFFFF;
        $this->quick_weapon_3_index = 0xFFFF;
        $this->quick_weapon_4_index = 0xFFFF;


        $this->quick_weapon_1_show = 0xFFFF;
        $this->quick_weapon_2_show = 0xFFFF;
        $this->quick_weapon_3_show = 0xFFFF;
        $this->quick_weapon_4_show = 0xFFFF;

        $this->quick_spell_1 = '';
        $this->quick_spell_2 = '';
        $this->quick_spell_3 = '';


        $this->quick_item_1_index = 0xFFFF;
        $this->quick_item_2_index = 0xFFFF;
        $this->quick_item_3_index = 0xFFFF;

        $this->quick_item_1_show = 0xFFFF;
        $this->quick_item_2_show = 0xFFFF;
        $this->quick_item_3_show = 0xFFFF;

        $this->long_name = null;
        $this->short_name = null;

        $this->creature_flags = 2048;
        $this->xp_value = 0;
        $this->xp = 0;
        $this->gold = 1000000;
        $this->permanent_status_flag = 0;
        $this->current_hp = 256;
        $this->max_hp = 8;

        $this->animation = 25089;
        $this->color_metal = 30;
        $this->color_minor = 30;
        $this->color_major = 30;
        $this->color_skin = 30;
        $this->color_leather = 30;
        $this->color_armor = 30;
        $this->color_hair = 30;

        $this->eff_structure = 0;

        $this->small_portrait = "DIDIMO_S";
        $this->large_portrait = "DIDIMO_L";

        $this->reputation = 110;

        $this->hide_in_shadows = 1;

        $this->armor_class_natural = -10;
        $this->armor_class_effective = -10;
        $this->armor_class_crushing = 0;
        $this->armor_class_missile = 0;
        $this->armor_class_piercing = 0;
        $this->armor_class_slashing = 0;

        $this->thac0 = -10;
        $this->number_of_attacks = 10;

        $this->save_throw_death = 0;
        $this->save_throw_wands = 0;
        $this->save_throw_polymorph = 0;
        $this->save_throw_breath = 0;
        $this->save_throw_spell = 0;

        $this->resist_fire = 0;
        $this->resist_cold = 0;
        $this->resist_electricity = 0;
        $this->resist_acid = 0;
        $this->resist_magic = 0;
        $this->resist_magic_fire = 0;
        $this->resist_magic_cold = 0;
        $this->resist_slashing = 0;
        $this->resist_crushing = 0;
        $this->resist_piercing = 0;
        $this->resist_missile = 0;

        $this->detect_illusion = 0;
        $this->set_traps = 0;
        $this->lore = 50;
        $this->lockpicking = 0;
        $this->stealth = 0;
        $this->find_traps = 0;
        $this->pick_pockets = 0;
        $this->fatigue = 0;
        $this->intoxication = 0;
        $this->luck = 0;

        $this->large_sword_proficiency = 5;
        $this->small_sword_proficiency = 5;
        $this->blunt_proficiency = 5;
        $this->spiked_proficiency = 5;
        $this->bow_proficiency = 5;
        $this->axe_proficiency = 5;
        $this->missile_proficiency = 5;
        $this->piercing_proficiency = 5;

        $this->unused_1 = "";
        $this->turn_undead = 1;
        $this->tracking = 0;
        $this->tracking_target = "";
        $this->unused_2 = "";
        $this->first_class_level = 9;
        $this->second_class_level = 11;
        $this->third_class_level = 0;

        $this->sex = 1;
        $this->strength = 21;
        $this->strength_bonus = 0;
        $this->intelligence = 21;
        $this->wisdom = 24;
        $this->dexterity = 21;
        $this->constitution = 20;
        $this->charisma = 12;

        $this->morale = 10;
        $this->morale_break = 0;

        $this->racial_enemy = 0;
        $this->morale_recovery = 1;

        $this->kit = 1073741824;

        $this->script_override = "DPLAYER3";
        $this->script_class = "None";
        $this->script_race = "None";
        $this->script_general = "None";
        $this->script_default = "DPLAYER3";

        $this->is_ally = 2;
        $this->general = 1;
        $this->race = 3;
        $this->class = 14;
        $this->specific = 0;
        $this->gender = 1;
        $this->references = "";
        $this->alignment = 33;
        $this->global_enumeration_value = 32;
        $this->local_enumeration_value = 31;
        $this->death_variable = "none";
        $this->dialog_file = "MULTIG";
        $this->known_spells = [];
        $this->memorizable_spells = [
            'priest' => [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
            ],
            'wizard' => [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0
            ]
        ];
        $this->memorized_spells = [];

        $this->items = [
            'helmet' => null,
            'armor' => null,
            'shield' => null,
            'gloves' => null,
            'left_ring' => null,
            'right_ring' => null,
            'amulet' => null,
            'belt' => null,
            'boots' => null,
            'weapon1' => null,
            'weapon2' => null,
            'weapon3' => null,
            'weapon4' => null,
            'quiver1' => null,
            'quiver2' => null,
            'quiver3' => null,
            'quiver4' => null,
            'cloack' => null,
            'quickitem1' => null,
            'quickitem2' => null,
            'quickitem3' => null,
            'inventory1' => null,
            'inventory2' => null,
            'inventory3' => null,
            'inventory4' => null,
            'inventory5' => null,
            'inventory6' => null,
            'inventory7' => null,
            'inventory8' => null,
            'inventory9' => null,
            'inventory10' => null,
            'inventory11' => null,
            'inventory12' => null,
            'inventory13' => null,
            'inventory14' => null,
            'inventory15' => null,
            'inventory16' => null,
            'magic_weapon' => null,
            'selected_weapong' => null,
            'selected_weapon_ability' => null
        ];
        
        return $this;
    }
}
