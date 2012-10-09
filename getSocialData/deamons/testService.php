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
 
/*require_once (BASE_DIR ."/service/service.php");

require_once (BASE_DIR ."/social/socialService.php");
require_once (BASE_DIR ."/social/googlePlusService.php");
require_once (BASE_DIR ."/social/twitterService.php");
require_once (BASE_DIR ."/social/facebookService.php");

require_once (BASE_DIR ."/sentiment/sentiment.php");
require_once (BASE_DIR ."/sentiment/alchemySentiment.php");
require_once (BASE_DIR ."/social/redditService.php");*/


$sentimentObj = SentimentService::getObject("Alchemy");

$searches = array(
	"#apple",
	"NASDAQ",
    "google",
    "SuperValu",
    "Albertsons",
    "android"
);

//search each keyword through each available service
foreach (SocialService::availableServices() as $service) {
    
	//get the next service to be searched
	$service = SocialService::getObject( $service );
	
    //foreach string we want to search
	foreach ( $searches as $searchString ) {
        
    	//retrieve a dataset based on a search
    	$dataSet = $service->getData( $searchString );
    	
    	//foreach item in the dataset
    	foreach ( $dataSet as $data ) {
            
            try {
                //put through sentiment analysis
                $sentiment = new StdClass();
                $sentiment->service = $sentimentObj->getServiceName();
                $sentiment->response = $sentimentObj->getSentiment(
                    $service->getMessage( $data ) 
                );
                
        		//print the entry to the screen
        		//print_r($data);
        		
        		//save the entry
        		SocialService::save( $service->getServiceName(), $searchString, $data, $sentiment );
            
            } catch (Exception $e) {
                echo "Unable to parse and save:\n";
                print_r($data);
                echo "\n\n";
            }
            
    	}//END foreach data set
        
	}//END foreach searches
    
}//END foreach social service

?>

