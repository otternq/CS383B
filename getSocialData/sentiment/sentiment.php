<?php
/**
 * File that contains the abstract sentiment service
 */
 
/**
 * Describes the expected function of a sentiment class
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage sentiment
 *
 * @link http://php.net/abstract documentation for an abstract class
 * @link http://php.net/static documentation for an static method
 */
abstract class SentimentService extends Service {
    
    /**
     * Access a Sentiment Analysis for the provided text
     *
     * @param $text The text to be processed
     *
     * @return object The object returned from Alchemy's Sentiment API
     */
    public abstract function getSentiment( $text );
    
    /**
     * Create and return an object based on the service requested
     *
     * @param string $service The service to process the text
     *
     * @return object The object created
     */
    public static function getObject( $service ) {
        $serviceClass = ucwords( $service ) .'Service';
    	
        //returns an object of the class specified by the $serviceClass string
    	return new $serviceClass();
    }//END function getObject
    
}



?>