<?php
/**
 * The file containing the SocialService class
 */
 
/**
 * Describe the expected functions of a Social Class
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage social
 *
 * @link http://php.net/abstract documentation for an abstract class
 * @link http://php.net/static documentation for an static method
 * @link http://php.net/mongo documentation for the PHP MongoDB Library
 *
 */
abstract class SocialService implements Service 
{

    /**
     * Asks the service for messages to be parsed
     *
     * @param string $search The keywords to be searched
     * @param int $since The start time of the search (unix timestamp). Default: Start of the day
     * @param int $until The end time of the search (unix timestamp). Default: End of the day
     * @param int $limit The max number of results. Default: 10
     * @return mixed
     */
    protected abstract function retrieveMessages( $search, $since, $until, $limit );
    
    /**
     * Parses the data provided by the service so that it can be stored
     *
     * @param mixed $serviceData The data provided by retrieveMessages()
     *
     * @return object
     */
    protected abstract function parseData($serviceData);

    /**
     * Performas multiple searches
     *
     * @param array $searches An array of strings to be searched
     *
     * @return array An array of objects to be saved
     */
    public function batchGetData( $searches ) 
    {
        $result = array();

        foreach ($searches as $search) {
            $result[$search] = $this->getData( $search );
        }

        return $result;
        
    }//END function batchGetData
    
    /**
     * Gets the services data, then parses it into what should be saved
     *
     * @param string $search The string that the service should search for
     * @param int $since The start time of the search (unix timestamp). Default: Start of the day
     * @param int $until The end time of the search (unix timestamp). Default: End of the day
     * @param int $limit The max number of results. Default: 10
     *
     *
     * @return array [ obj1, obj2]
     */
     public function getData( $search, $since = null, $until = null, $limit = 10 ) 
     {
        if ($since == null) {
            $since = mktime(0,0,0);
        }
        
        if ($until == null) {
            $until = mktime(23,59,59);
        }

        $serviceData = $this->retrieveMessages( $search, $since, $until, $limit );
        return $this->parseData($serviceData);

    }//END function getData
    
    /**
     * Gets the actual message from the raw data 
     *
     * @param object $data An element of the array retrieved by getData
     *
     * @return string The message
     */
    public abstract function getMessage( $data );
    
    /**
     * Returns an object specific to the service requested
     *
     * @param string $service The service you want to work with
     *
     * @return object
     */
    public static function getObject( $service ) 
    {
        $serviceClass = ucwords( $service ) .'Service';
    	
        //returns an object of the class specified by the $serviceClass string
        return new $serviceClass();
    	
    }//END function getObject
    
    /**
     * What social networks are available for search
     *
     * @return array
     */
    public static function availableServices() 
    {
        return array (
            "Twitter",
            "GooglePlus",
            "Facebook",
            "Reddit"
        );
        
    }//END function availableServices
    
    /**
     * Saves the data retrieved by the service objects
     *
     * @param string $service The service that this data came from
     * @param string $searchString The search that produced the data
     * @param object $data The data to be saved
     * @param object $sentiment The object given by the sentiment analysis
     *
     * @return bool Return success or failure
     */
    public static function save ( $service, $searchString, $data, $sentiment, $end = null ) 
    {
        if ($end == null) {
            $end = mktime();
        }
    
        //authenticate to the MongoDB server
    	$m = new Mongo(
            "mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock"
        );
        
        //select the MongoDB datbase
    	$db = $m->selectDB('socialstock');
        
        //select the MongoDB collection to work with
	$collection = new MongoCollection($db, 'messages2');
		
        //save the message to the MongoDB server
		return $collection->insert( 
			array (
                "date" => $end, //save the current UNIX TIMESTAMP
				"service" => $service,
				"searchString" => $searchString,
				"data" => $data,
                "sentiment" => $sentiment
			)
		);
    
    }//END function save

}//END class SocialService

?>
