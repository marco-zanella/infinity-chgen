<?php
spl_autoload_register(function ($class_name) {
    include_once implode('/', explode('\\', $class_name)) . '.php';
});
