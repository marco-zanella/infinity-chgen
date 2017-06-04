<?php
namespace DataMapper;

use \Model\Section;
use \Model\Character;

class SectionMapper {
    private $schema, $size;

    public function __construct($schema) {
        $this->schema = $schema;

        $this->size = 0;
        foreach ($schema as $type) {
            $this->size += $this->size($type);
        }
    }


    private function size($type) {
        if (is_numeric($type)) {
            return $type;
        }

        switch ($type) {
            case 'byte':
            case 'signed_byte':
                return 1;

            case 'word':
            case 'signed_word':
                return 2;

            case 'dword':
            case 'strref':
            case 'char_array':
                return 4;

            case 'resref':
                return 8;

            case 'string':
                return 32;

            default:
                return 0;
        }
    }


    private function parseText($data) {
        $str = "";
        foreach ($data as $c) {
            if ($c >= 32 && $c <= 126) {
                $str .= sprintf("%c", $c);
            }
        }
        return $str;


        $ascii = function ($c) {
            return ($c >= 32 && $c <= 126) ? sprintf("%c", $c) : "\0";
            return sprintf("%c", $c);
        };
        return implode("", array_map($ascii, $data));
    }
    
    private function writeText($string, $length = null) {
        if (is_null($length)) {
            $length = strlen($string);
        }

        $result = [];
        for ($i = 0; $i < $length; ++$i) {
            $result[$i] = isset($string[$i]) ? ord($string[$i]) : 0;
        }

        return $result;
    }



    private function parseNumber($data, $signed = false) {
        $data = array_reverse($data);
        $is_negative = false;

        if ($signed) {
            $size = count($data);
            $is_negative = $data[0] & 0x80;
            $data[0] = $data[0] & 0x7F;
        }

        $parse = function ($carry, $item) { return $carry * 0x100 + $item; };
        $result = array_reduce($data, $parse);

        if ($is_negative) {
            $result = -(0x80 << (($size - 1) * 8)) + $result;
        }

        return $result;
    }
    
    private function writeNumber($number, $size, $signed = false) {
        $result = [];

        for ($i = 0; $i < $size; ++$i) {
            $result[$i] = $number & 0xFF;
            $number = $number >> 8;
        }

        return $result;
    }



    private function parse($data, $type = 'byte') {
        switch ($type) {
            case 'byte':
            case 'word':
            case 'dword':
                return $this->parseNumber($data);

            case 'signed_byte':
            case 'signed_word':
                return $this->parseNumber($data, true);

            default:
                return $this->parseText($data);
        }
    }
    
    private function write($data, $type = 'byte') {
        switch ($type) {
            case 'byte':
            case 'word':
            case 'dword':
                return $this->writeNumber($data, $this->size($type));

            case 'signed_byte':
            case 'signed_word':
                return $this->writeNumber($data, $this->size($type), true);

            default:
                return $this->writeText($data, $this->size($type));
        }
    }

    public function getSize() {
        return $this->size;
    }



    public function create($section) {
        $result = [];

        foreach ($this->schema as $name => $type) {
            $result = array_merge($result, $this->write($section->$name, $type));
        }

        return $result;
    }



    public function read($data, $offset = 0) {
        $section = new Section();

        $i = 0;
        foreach ($this->schema as $name => $type) {
            $size = $this->size($type);
            $raw_value = array_slice($data, $offset + $i, $size);
            $section->$name = $this->parse($raw_value, $type);
            $i += $size;
        }

        return $section;
    }

    public function readList($data, $offset = 0, $count = 1) {
        $list = [];
        for ($i = 0; $i < $count; ++$i) {
            $list[] = $this->read($data, $offset + $i * $this->getSize());
        }
        return $list;
    }
}