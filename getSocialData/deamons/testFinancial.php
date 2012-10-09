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
 
require_once (BASE_DIR ."/service/service.php");

require_once (BASE_DIR ."/financial/financialService.php");
require_once (BASE_DIR ."/financial/stocklyticsService.php");

require_once (BASE_DIR ."/financial/financialServiceUtility.php");

//authenticate to the MongoDB server
$m = new Mongo(
    "mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock"
);

//select the MongoDB datbase
$db = $m->selectDB('socialstock');

//select the MongoDB collection to work with
$collection = new MongoCollection($db, 'stockHistory');

$serviceUtil = new FinancialServiceUtility($collection);

$service = FinancialService::getObject( "stocklytics" );

print_r($service->getServiceName());
//$serviceUtil->saveHistory($service->getServiceName(), "APPL", $service->getHistory( "AAPL") );