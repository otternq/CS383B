<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

require_once "./stockHelper.php";

$date = null;

if(!empty($_GET['date']))
{
    $date = $_GET['date'];
}

$json = json_encode(StockHelper::getStockHistoryGen($date));

//print the output for retrival
echo isset($_GET['callback'])
    ? "{$_GET['callback']}($json)"
    : $json;
    


?>
