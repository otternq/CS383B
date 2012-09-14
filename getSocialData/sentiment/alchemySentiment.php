<?php
/**
 * The file containing the AlchemyService class
 */
 
/**
 * Sends messages to the Alchemy Sentiment API for analysis
 *
 * <p>
 * The Alchemy API provides an SDK to connect to their API, it is stored in /opt/AlchemyAPI_PHP5-0.8/
 * and is a PHP library.
 *
 * Alchemy has not restricted API access to a specific number of requests
 * </p>
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage sentiment
 *
 * @link http://www.alchemyapi.com/api/sentiment/textc.html The Alchemy API Documentation
 */
class AlchemyService extends SentimentService {
    /**
     * @var string The service being used
     */
    public $service = "Alchemy";
    
    /**
     * Access Alchemy's Sentiment API to recieve an analysis of the text
     *
     * @param $text The text to be processed
     *
     * @return object The object returned from Alchemy's Sentiment API
     */
    public function getSentiment( $text ) {
        //Create a connection to the Alchemy API
        $alchemyObj = new AlchemyAPI();


        // Load the API key from disk.
        $alchemyObj->loadAPIKey( ALCHEMY_KEY_FILE );
        
        //return what Alchemy gives us for analysis
        return json_decode( 
            $alchemyObj->TextGetTextSentiment( //Ask Alchemy for an analysis
                $text, //the text to be processed
                AlchemyAPI::JSON_OUTPUT_MODE //the output format
            )
        );
        
    }
    
}

?>