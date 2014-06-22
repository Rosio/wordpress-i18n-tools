#!/usr/bin/env php
<?php
namespace WordPress\L18N;
error_reporting(E_ALL);
ini_set('display_errors', 1);

$not_gettexted = new NotGettexted;
$not_gettexted->cli();