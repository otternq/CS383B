<?php
/**
 * The file containing the Twitter Social Service Class
 */
 
/**
 * Sends and parses Google+ API requests
 *
 * <p>
 * The Google+ API requires an API key, which I (Nick) have provided.
 * Currently (Aug 31, 2012) it is limited to 10,000 request per day
 * but that can be increased to 100,000 if it needs to be
 * </p>
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage social
 *
 * @link https://developers.google.com/+/api/latest/ The Google+ API Documentation
 *
 */
class GooglePlusService extends SocialService 
{

    /**
     * @var string The service being seached is Google+
     */
    public $service = "Google Plus";
    
    /**
     * @ignore
     * @var The API key used to access Google+ API
     */
    protected $apiKey = "AIzaSyD4P43J4OUQZHcDwsrGpod7h1ITO9pyk4g";

    /**
     * Formulates the REST URI request
     *
     * @param string $search The keyboard that will be searched for
     *
     * @return url
     */
    protected function getSearchUrl( $search ) 
    {
	    return "https://www.googleapis.com/plus/v1/activities?query=+".urlencode($search)."&key=". $this->apiKey;
	}//END function getSearchUrl()

    /**
     * Retrieves messages from the Google+ API
     *
     * <p>
     * Tells getSearchUrl() the desired search phrase
     * </p>
     *
     * @param string $search The keywords/phrase to be searched for
     *
     * @return JSONString
     */
    protected function retrieveMessages( $search ) 
    {
        return file_get_contents( $this->getSearchUrl( $search ) );
    }//END function retrieveMessages

    /**
     * Converts the JSON provided by retrieveMessages() to a PHP Object
     *
     * @param JSONString $serviceData
     *
     * @return object The object to be stored
     */
    public function parseData( $serviceData ) 
    {
        $parsedData = array();
        $serviceData = json_decode( $serviceData );
        
        $parsedData = $serviceData->items;
		
		
        unset($serviceData);
        return $parsedData;
	}//END function parseData
    
    /**
     * Gets the actual message from the raw data 
     *
     * @param object $data An element of the array retrieved by getData
     *
     * @return string The message
     */
    public function getMessage( $data ) 
    {
        
        return $data->object->content;
        
    }//END function getMessage
    
}//END class GooglePlusService

?>