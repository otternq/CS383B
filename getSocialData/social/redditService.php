<?php
/**
 * The file that contains the redditService class
 */

/**
 * Connects to the Reddit API and searches for provided terms
 *
 * @author Nick Otter <otternq@gmail.com>
 * @author Sean Heagerty <heag7943@vandals.uidaho.edu>
 *
 * @package socialStocks
 * @subpackage social
 *
 * @link http://www.reddit.com/dev/api#GET_search documentation for Reddit Search
 *
 */
class RedditService extends SocialService 
{
    
    public $service = "Reddit";
    
    public function getServiceName() {
        return $this->service;
    }
    
    /**
     * Creates the URL that our request will be sent to
     *
     * @param string $search The string that will be searched for
     * @param string $format [json/xml]
     */
    protected function getSearchUrl ($search, $format) {
        return "http://www.reddit.com/search.".$format."?q=".$search."&syntax=plain";
    }//END getSearchUrl
    
    /**
     * Retrieves the messages from Reddit's Search API
     * 
     * @param string $search The keywords/phrase to be searched for
     * 
     * @return JSONString
     */
    protected function retrieveMessages( $search, $since, $until, $limit )
    {
        $url = $this->getSearchUrl( $this->specialStrip($search), "json" );
        
        return file_get_contents( $url );
    }//END retrieveMessages
    
    /**
     * Converts the JSON provided by retrieveMessages() into a PHP object
     * 
     * @param JSONString $serviceData
     * 
     * @return object The object to be stored
     */
    public function parseData( $serviceData )
    {
        $serviceData = json_decode( $serviceData );
        
        return $serviceData->data->children;
    }//END parseData
    
    /**
     * Gets the actual message from the raw data
     * 
     * @param object $data An element of the array retrieved by getData
     * 
     * @return string the message
     */
    public function getMessage( $data ) 
    {
        
        return $data->data->selftext_html;
        
    }//END function getMessage
    
    /**
     * Removes harmful character
     *
     * @param string $haystack
     * @return string The haystack withouth harmful characters
     */
    public function specialStrip( $haystack ) 
    {
        $needles = array (
            "#"
        );
        
        foreach ($needles as $needle) {
            $haystack = str_replace( $needle, "", $haystack);
        }
        
        return $haystack;
    }//END function specialStrip
    
}//END class RedditService
