<?php

$a = isset($_GET['a']) ? trim($_GET['a']) : '';
$b = isset($_GET['b']) ? trim($_GET['b']) : '';
$c = isset($_GET['c']) ? trim($_GET['c']) : '';

header('Content-Type: application/json');
$resp = array();

if ($a=='' || $b=='' || $c=='') {
	$resp['Result'] = false;
	echo json_encode($resp);
	die();
}

$mod = $a % $b;
$resp['Result'] = $mod==$c;
echo json_encode($resp);
die();

?>