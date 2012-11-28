<?php

/**
 * Passed keyword searches to SocialService objects and saves the messages to MongoDB
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage deamon
 *
 * @todo report when sentiment analysis is not able to work on a piece of data
 *
 */
 

require_once "../config.php";
require_once "../autoload.php";

require_once "/opt/AlchemyAPI_PHP5-0.8/module/AlchemyAPI.php";


$sentimentObj = SentimentService::getObject("Alchemy");


$searches = array(
	  "NASDAQ",
    "AAPL",
    "GOOG",
    "AMZN",
    "FB",
    "MSFT"

);

$service = "Facebook";
$now = mktime();
$day = 0;
$maxday = 30;
$daysec = 60*60*24;
$limit = 5;

//search each keyword through each available service
while ($day < $maxday) {
    
	//get the next service to be searched
	$service = SocialService::getObject( "Facebook" );
	
    //foreach string we want to search
	foreach ( $searches as $searchString ) {


        $start = $now - (($day+1) * $daysec);
        $end = $now - ($day * $daysec);

        echo "Time Range - Start: ".$start." End ".$end."\n"; 
    	//retrieve a dataset based on a search
    	$dataSet = $service->getData( $searchString, $start, $end, $limit );	
    	
        echo "DataSet: ". print_r($dataSet, true) ."\n";

        //foreach item in the dataset
    	foreach ( $dataSet as $data ) {
            
            try {
                //put through sentiment analysis
          /*      $sentiment = new StdClass();
                $sentiment->service = $sentimentObj->getServiceName();
                $sentiment->response = $sentimentObj->getSentiment(
                    $service->getMessage( $data ) 
                );
           */    
        		//print the entry to the screen
        		print_r($data);
        		
        		//save the entry
        		SocialService::save( $service->getServiceName(), $searchString, $data, $sentiment );
               echo "Worked\n";
            } catch (Exception $e) {
                echo "START:";
                echo "\tUnable to parse and save:\n";
                echo "\t" . print_r($data, true);
                echo "END;\n\n";
            }
            
    	}//END foreach data set
        
  }//END foreach searches

  $day = $day + 1;
    
}//END while day

?>

