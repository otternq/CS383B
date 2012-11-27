<?php
/**
 * The file containing the facebook service class
 */

/**
 * Sends and Parses Facebook Graph API for Public posts
 
 * <p>
 * Searches the Google Graph API for public posts, there are other 
 * types of data that could be searched for, see Forum Link
 * </p>
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage social
 *
 * @link http://stackoverflow.com/questions/2263287/does-facebook-have-a-public-search-api-yet Fourm post with example to search facebook
 *
 */
class FacebookService extends SocialService 
{
    /**
     * @var string The service being seached is Facebook
     */
    public $service = "Facebook";
    
    public function getServiceName() {
        return $this->service;
    }
    
    /**
     * Retrieves messages from the Twitter Search API
     *
     * <p>
     * Tells getSearchUrl() the desired response format
     * and language as well as specifying the search phrase
     * </p>
     *
     * @param string $search The keywords/phrase to be searched for
     *
     * @return JSONString
     */
    protected function retrieveMessages( $search, $since, $until, $limit ) 
    {
        
      $url =  "https://graph.facebook.com/search?q=".urlencode($search)."&type=post&since=".urlencode($since)."&until=".urlencode($until)."&limit=".urlencode($limit)."&locale=en_US";
		
        return file_get_contents( $url );
        
    }//END function retrieveMessages()

    /**
     * Converts the JSON provided by retrieveMessages() to a PHP Object
     *
     * @param JSONString $serviceData
     *
     * @return object The object to be stored
     */
    public function parseData( $serviceData ) 
    {
        
        $serviceData = json_decode( $serviceData );
        return $serviceData->data;
        
    }//ENd function parseData()
    
    /**
     * Gets the actual message from the raw data 
     *
     * @param object $data An element of the array retrieved by getData
     *
     * @return string The message
     */
    public function getMessage( $data ) 
    {
        return $data->message;
    }//END function getMessage
    
}//END class FacebookService
