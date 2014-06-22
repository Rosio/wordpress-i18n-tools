#!/usr/bin/env php
<?php
namespace WordPress\L18N;
error_reporting(E_ALL);
ini_set('display_errors', 1);

$potextmeta = new PotExtMeta;
if (!isset($argv[1]))
	$potextmeta->usage();

$potextmeta->append( $argv[1], isset( $argv[2] ) ? $argv[2] : '-', isset( $argv[3] ) ? $argv[3] : null );