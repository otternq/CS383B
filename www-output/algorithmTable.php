<?php



$m = new Mongo("mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock");
$db = $m->selectDB('socialstock');
$collection = new MongoCollection($db, 'results');

foreach($collection->find(array()) as $result) {
    print_r($result);
}


