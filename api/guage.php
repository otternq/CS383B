<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");


/* Where to go, which database, and which collection */
$m = new Mongo("mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock");
$db = $m->selectDB('socialstock');
$collection = new MongoCollection($db, 'results');

/* Create an array for the sentiment */
$sentArr = array();

for($algorithm = 1; $algorithm <=3; $algorithm++){

  /* Process the information into an array */
  foreach($collection->find(array("algorithm" => $algorithm)) as $message){
    /* Make the indexes variables */
    $firstIndex = date("Y-m-d", $message['date']);

    /* load the result into the array */
    if ( !isset($sentArr[$algorithm][$firstIndex]) )
      $sentArr[$algorithm][$firstIndex] = $message['result'];
    else
      $sentArr[$algorithm][$firstIndex] += $message['result'];

  }
}

			/* Alphabetize the entries */
for($algorithm = 1; $algorithm <=3; $algorithm++){

  foreach( array_keys($sentArr[$algorithm]) as $arrKey)  {

    ksort($sentArr[$algorithm][$arrKey]);

  }
}

$a1 = number_format(array_pop($sentArr[1]),5);
$a2 = number_format(array_pop($sentArr[2]),5);
$a3 = number_format(array_pop($sentArr[3]),5);


$json = json_encode(array("a1"=> $a1, "a2" => $a2, "a3" => $a3));

echo isset($_GET['callback'])
    ? "{$_GET['callback']}($json)"
    : $json;
