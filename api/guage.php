<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$json = json_encode(array("a1"=>1, "a2" => 2, "a3" => 3));

echo isset($_GET['callback'])
    ? "{$_GET['callback']}($json)"
    : $json;
