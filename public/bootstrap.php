<?php
ini_set("display_errors", 1);
define('MAP', 0);
date_default_timezone_set('America/Sao_Paulo');
require_once dirname(dirname(__FILE__)).'/lib/ini_Class.php';

$start = new ini_Class();
$start->ini();
