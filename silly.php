<?php

/* Default silly constants */
const SILLYPATH = __DIR__;
const NS = "\\";
const DS = DIRECTORY_SEPARATOR;

if(!defined('FCPATH')) {
	define('FCPATH', getcwd());
}

$funcs = spl_autoload_functions();