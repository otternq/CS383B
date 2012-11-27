<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$date = null;

if(!empty($_GET['date']))
{
    $date = $_GET['date'];
}

$json = json_encode(getStockHistoryGen($date));

//print the output for retrival
echo isset($_GET['callback'])
    ? "{$_GET['callback']}($json)"
    : $json;
    
function getStockHistory($date = null)
{
    $data = array();
	
    $query = array();

    if ($date != null)
    {

        /* An array representing the query to run */
        $query = array(
            "data.date" => $date
        );

    }

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

function getStockHistoryGen($date = null)
{
    $total = 0;
    $data = getStockHistory($date);
    

    for ($i = 0; $i < count($data); $i++) {
        print_r($data[$i]);
	$total += $data[$i]['data']['close'] - $data[$i]['data']['open'];
    }

    return $total;

}

?>
