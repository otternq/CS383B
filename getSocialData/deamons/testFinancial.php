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

$service = FinancialService::getObject( "stocklytics" );

print_r ( $service->getHistory( "AAPL" ) );