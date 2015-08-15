<?php

/* Default silly constants */
const SILLYPATH = __DIR__;
const NS = "\\";
const DS = DIRECTORY_SEPARATOR;

if(!defined('FCPATH')) {
	define('FCPATH', getcwd());
}

$f = function($g) {
    return ++$g;
};

$r = new ReflectionFunction($f);



$funcs = spl_autoload_functions();