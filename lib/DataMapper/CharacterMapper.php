<?php
namespace DataMapper;

use \Model\Section;
use \Model\Character;

class CharacterMapper {
    private $schema, $chr_mapper, $cre_mapper,
            $known_spell_mapper, $spell_info_mapper, $memorized_spell_mapper,
            $item_slots_mapper, $item_mapper;


    public function __construct() {
        $schema = parse_ini_file('schema.ini', true);

        $this->schema = $schema;
        $this->chr_mapper = new SectionMapper($schema['CHR']);
        $this->cre_mapper = new SectionMapper($schema['CRE']);
        $this->known_spell_mapper = new SectionMapper($schema['known_spells']);
        $this->spell_info_mapper = new SectionMapper($schema['spell_memorization']);
        $this->memorized_spell_mapper = new SectionMapper($schema['memorized_spells']);
        $this->item_slots_mapper = new SectionMapper($schema['item_slots']);
        $this->item_mapper = new SectionMapper($schema['items_table']);
    }
    
    
    
    private function spellTypeToId($type) {
        switch ($type) {
            case 'priest': return 0;
            case 'wizard': return 1;
            case 'innate': return 2;
            default: return 3;
        }
    }
    
    
    
    private function spellIdToType($id) {
        switch ($id) {
            case 0: return 'priest';
            case 1: return 'wizard';
            case 2: return 'innate';
            default: return 'invalid';
        }
    }
    
    
    
    public function create($character, $filename) {
        $schema = $this->schema;
        $data = [];
        
        
        
        // Creates known spells section
        $known_spells = [];
        foreach ($character->known_spells as $type => $levels) {
            $type_id = $this->spellTypeToId($type);
            
            if ($type == 'priest' || $type == 'wizard') {
                foreach ($levels as $level => $spells) {
                    foreach ($spells as $name) {
                        $spell = new Section();
                        $spell->type = $type_id;
                        $spell->level = $level - 1;
                        $spell->name = $name;
                        $known_spells[] = $spell;
                    }
                }
            }
            
            elseif ($type == 'innate') {
                foreach ($levels as $name) {
                    $spell = new Section();
                    $spell->type = $type_id;
                    $spell->level = 0;
                    $spell->name = $name;
                    $known_spells[] = $spell;
                }
            }
        }
        
        $known_spells_count = count($known_spells);
        $known_spells_data = [];
        foreach ($known_spells as $spell) {
            $known_spells_data = array_merge($known_spells_data, $this->known_spell_mapper->create($spell));
        }
        
        
        
        
        
        
        
        // Creates spell memorization info and memorized spells sections
        $idx = 0;
        $memorized_spells = [];
        $infos = [];
        $memorized_spells_lookup = [];
        
        
        foreach ($character->memorized_spells as $type => $levels) {
            $type_id = $this->spellTypeToId($type);
            
            if ($type == 'priest' || $type == 'wizard') {
                foreach ($levels as $level => $spells) {
                    $memorized_spells_lookup[$type][$level] = $idx;
                    foreach ($spells as $name) {
                        $spell = new Section();
                        $spell->name = $name;
                        $spell->memorized = 1;
                        $memorized_spells[$idx] = $spell;
                        
                        $idx++;
                    }
                }
            }
            elseif ($type == 'innate') {
                $memorized_spells_lookup['innate'] = $idx;

                foreach ($levels as $name) {
                    $spell = new Section();
                    $spell->name = $name;
                    $spell->memorized = 1;
                    $memorized_spells[$idx] = $spell;
                    $idx++;
                }
            }
        }
        
        
        
        // Priest and wizard spells
        foreach ($character->memorizable_spells as $type => $levels) {
            foreach ($levels as $level => $memorizable_spells) {
                $info = new Section();
                $info->level = $level - 1;
                $info->memorizable_spells = $memorizable_spells;
                $info->memorizable_spells_effect = $memorizable_spells;
                $info->type = $this->spellTypeToId($type);
                $info->index = isset($memorized_spells_lookup[$type][$level]) ? $memorized_spells_lookup[$type][$level] : $idx;
                $info->count = isset($character->memorized_spells[$type][$level]) ? count($character->memorized_spells[$type][$level]) : 0;
                $infos[] = $info;
            }
        }
        
        // Innate spells
        $info = new Section();
        $info->level = 0;
        $info->memorizable_spells = 0;
        $info->memorizable_spells_effect = 0;
        $info->type = $this->spellTypeToId('innate');
        $info->index = isset($memorized_spells_lookup['innate']) ? $memorized_spells_lookup['innate'] : $idx;
        $info->count = isset($character->memorized_spells['innate']) ? count($character->memorized_spells['innate']) : 0;
        $infos[] = $info;
        
        
        
        $memorized_spells_count = count($memorized_spells);
        $memorized_spells_data = [];
        foreach ($memorized_spells as $spell) {
            $memorized_spells_data = array_merge($memorized_spells_data, $this->memorized_spell_mapper->create($spell));
        }
        
        $info_count = count($infos);
        $info_data = [];
        foreach ($infos as $info) {
            $info_data = array_merge($info_data, $this->spell_info_mapper->create($info));
        }
        
        
        
        
        
        
        
        
        
        // Items
        $items = [];
        $idx = 0;
        $item_slots = new Section();
        foreach ($character->items as $slot => $item) {
            if (in_array($slot, ['magic_weapon', 'selected_weapon', 'selected_weapon_ability'])) {
                $item_slots->$slot = $item;
                continue;
            }
            $item_slots->$slot = (!is_null($item) && $item->name != 'null') ? $idx : 0xFFFF;
            
            if (!is_null($item) && $item->name != 'null') {
                $items[] = $item;
                $idx++;
            }
        }
        
        $items_count = count($items);
        $items_data = [];
        foreach ($items as $item) {
            $items_data = array_merge($items_data, $this->item_mapper->create($item));
        }
        $slots_data = $this->item_slots_mapper->create($item_slots);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        // Creates CHR section
        $chr = new Section();
        $chr->signature = 'CHR ';
        $chr->version = 'V1.0';
        $chr->cre_offset = $this->chr_mapper->getSize();
        $chr->cre_length = 0;
        
        foreach ($schema['CHR'] as $attribute => $type) {
            if (in_array($attribute, ['signature', 'version', 'cre_offset', 'cre_length'])) {
                continue;
            }
            $chr->$attribute = $character->$attribute;
        }
        
        
        
        // Cretes CRE section
        $cre = new Section();
        $cre->signature = 'CRE ';
        $cre->version = 'V1.0';
        
        $cre->known_spells_offset = $this->cre_mapper->getSize();
        $cre->known_spells_count = $known_spells_count;
        $cre->spell_memorization_info_offset = $cre->known_spells_offset
                                             + $known_spells_count * $this->known_spell_mapper->getSize();
        $cre->spell_memorization_info_count = $info_count;
        $cre->memorized_spells_offset = $cre->spell_memorization_info_offset
                                      + $info_count * $this->spell_info_mapper->getSize();
        $cre->memorized_spells_count = $memorized_spells_count;
        $cre->item_slots_offset = $cre->memorized_spells_offset
                                + $memorized_spells_count * $this->memorized_spell_mapper->getSize();
        $cre->items_offset = $cre->item_slots_offset + $this->item_slots_mapper->getSize();
        $cre->items_count = $items_count;
        $cre->effects_offset = 0;
        $cre->effects_count = 0;
        
        $chr->cre_length = $cre->items_offset + $items_count * $this->item_mapper->getSize();
        
        foreach ($schema['CRE'] as $attribute => $type) {
            if (in_array($attribute, [
                'signature', 'version',
                'known_spells_offset', 'known_spells_count',
                'spell_memorization_info_offset', 'spell_memorization_info_count',
                'memorized_spells_offset', 'memorized_spells_count',
                'item_slots_offset', 'items_offset', 'items_count',
                'effects_offset', 'effects_count'
            ])) {
                continue;
            }
            $cre->$attribute = $character->$attribute;
        }
        
        
        
        $data = array_merge($data, $this->chr_mapper->create($chr));
        $data = array_merge($data, $this->cre_mapper->create($cre));
        $data = array_merge($data, $known_spells_data);
        $data = array_merge($data, $info_data);
        $data = array_merge($data, $memorized_spells_data);
        $data = array_merge($data, $slots_data);
        $data = array_merge($data, $items_data);
        
        
        
        // Writes CHR file
        $bin = function ($carry, $item) { return $carry . pack("C", $item); };
        $fh = fopen($filename, 'wb');
        $binary_data = array_reduce($data, $bin);
        fwrite($fh, $binary_data);
        fclose($fh);
        
        return $this;
    }



    public function read($filename) {
        $character = new Character();

        // Reads CHR file
        $fh = fopen($filename, 'rb');
        $size = filesize($filename);
        $content = fread($fh, $size);
        $data = unpack("C*", $content);
        fclose($fh);



        // Parses raw data
        $chr = $this->chr_mapper->read($data);

        $cre = $this->cre_mapper->read($data, $chr->cre_offset);

        $known_spells = $this->known_spell_mapper->readList(
            $data,
            $chr->cre_offset + $cre->known_spells_offset,
            $cre->known_spells_count
        );

        $spell_infos = $this->spell_info_mapper->readList(
            $data,
            $chr->cre_offset + $cre->spell_memorization_info_offset,
            $cre->spell_memorization_info_count
        );

        $memorized_spells = $this->memorized_spell_mapper->readList(
            $data,
            $chr->cre_offset + $cre->memorized_spells_offset,
            $cre->memorized_spells_count
        );

        $item_slots = $this->item_slots_mapper->read($data, $chr->cre_offset + $cre->item_slots_offset);

        $items = $this->item_mapper->readList(
            $data,
            $chr->cre_offset + $cre->items_offset,
            $cre->items_count
        );



        // Sets character's attributes (CHR info)
        foreach ($chr->getAttributes() as $attribute) {
            if (in_array($attribute, ['signature', 'version', 'cre_offset', 'cre_length'])) {
                continue;
            }
            $character->$attribute = $chr->$attribute;
        }
        
        
        // Sets character's attributes (CRE info)
        foreach ($cre->getAttributes() as $attribute) {
            if (in_array($attribute, [
                'signature', 'version',
                'known_spells_offset', 'known_spells_count',
                'spell_memorization_info_offset', 'spell_memorization_info_count',
                'memorized_spells_offset', 'memorized_spells_count',
                'item_slots_offset', 'items_offset', 'items_count',
                'effects_offset', 'effects_count'
            ])) {
                continue;
            }
            $character->$attribute = $cre->$attribute;
        }



        // Sets known spells
        $spells = [];
        foreach ($known_spells as $spell) {
            if ($spell->type == 0) {
                $spells['priest'][$spell->level + 1][] = $spell->name;
            }
            elseif ($spell->type == 1) {
                $spells['wizard'][$spell->level + 1][] = $spell->name;
            }
            else {
                $spells['innate'][] = $spell->name;
            }
        }
        $character->known_spells = $spells;



        // Sets memorizable spells count and memorized spells
        $infos = [];
        $spells = [];
        foreach ($spell_infos as $info) {
            if ($info->type == 0) {
                $infos['priest'][$info->level + 1] = $info->memorizable_spells;
                for ($i = $info->index; $i < $info->index + $info->count; ++$i) {
                    $spells['priest'][$info->level + 1][] = $memorized_spells[$i]->name;
                }
            }
            elseif ($info->type == 1) {
                $infos['wizard'][$info->level + 1] = $info->memorizable_spells;
                for ($i = $info->index; $i < $info->index + $info->count; ++$i) {
                    $spells['wizard'][$info->level + 1][] = $memorized_spells[$i]->name;
                }
            }
            elseif ($info->type == 2) {
                for ($i = $info->index; $i < $info->index + $info->count; ++$i) {
                    $spells['innate'][] = $memorized_spells[$i]->name;
                }
            }
        }
        $character->memorizable_spells = $infos;
        $character->memorized_spells = $spells;



        // Sets item slots info
        $slots = [];
        foreach ($item_slots->getAttributes() as $slot) {
            $index = $item_slots->$slot;

            if (in_array($slot, ['magic_weapon', 'selected_weapon', 'selected_weapon_ability'])) {
                $slots[$slot] = $index;
                continue;
            }

            $slots[$slot] = ($index < count($items)) ? $items[$index] : null;
        }
        $character->items = $slots;



        return $character;
    }
}
