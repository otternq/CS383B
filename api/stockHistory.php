<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$json = json_encode(getStockHistory("2012-06-15"));

//print the output for retrival
echo isset($_GET['callback'])
    ? "{$_GET['callback']}($json)"
    : $json;
    
function getStockHistory($date)
{
    $data = array();

    /* An array representing the query to run */
    $query = array(
        "data.date" = > $date
    );

    /* An array of the fields of information desired */
    $fields = array(
    );
    
    /* Where to go, which database, and which collection */
    $m = new Mongo("mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock");
    $db = $m->selectDB('socialstock');
    $collection = new MongoCollection($db, 'stockHistory');
    
    foreach($collection->find($query, $fields) as $stock) {
        $data[] = $stock;
    }
    
    return $data;

}

?>