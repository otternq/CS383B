<?php
/**
 * Passes Stock Codes to a FinancialService objects and saves the data to MongoDB
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage deamon
 *
 * @todo report when unable to retrieve data for a stock code
 *
 */
 

require_once "../config.php";
require_once "../autoload.php";

/*require_once ("../service/service.php");

require_once ("../financial/financialService.php");
require_once ("../financial/stocklyticsService.php");

require_once ("../financial/financialServiceUtility.php");*/

//authenticate to the MongoDB server
$m = new Mongo(
    "mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock"
);

//select the MongoDB datbase
$db = $m->selectDB('socialstock');

//select the MongoDB collection to work with
$collection = new MongoCollection($db, 'stockHistory');

$serviceUtil = new FinancialServiceUtility($collection);

$service = FinancialService::getObject( "yahoo" );

foreach ($stockCodes as $stockCode) {
    
    $serviceUtil->saveHistory($service->getServiceName(), $stockCode, $service->getHistory($stockCode) );
    
    //print_r($service->getHistory($stockCode));
}