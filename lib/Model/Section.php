<?php
namespace Model;

class Section {
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


    public function getAttributes() {
        return array_keys($this->fields);
    }
}
