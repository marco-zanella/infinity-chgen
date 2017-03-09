<?php
function set_byte($data, $name, $value) {
    $value = intval($value);
    $byte = $value & 0xFF;

    $data->set(offset($name), $byte);
}

function set_byte2($data, $name, $value) {
    $value = intval($value);
    $bytes = $value & 0xFFFF;

    $byte1 = $bytes & 0xFF;
    $byte2 = ($bytes / 0x100) & 0xFF;
    
    $offset = offset($name);
    
    $data->set($offset + 0, $byte1);
    $data->set($offset + 1, $byte2);
}

function set_int($data, $name, $value) {
    $value = intval($value);
    $byte1 = $value & 0xFF;
    $byte2 = intval($value / 0x100) & 0xFF;
    $byte3 = intval($value / 0x10000) & 0xFF;
    $byte4 = intval($value / 0x1000000) & 0xFF;
    
    $offset = offset($name);
    
    $data->set($offset + 0, $byte1);
    $data->set($offset + 1, $byte2);
    $data->set($offset + 2, $byte3);
    $data->set($offset + 3, $byte4);
}

function set_string($data, $name, $value) {
    $data->setString(offset($name), $value);
}