<?php
/**
 * The file containing the Twitter Social Service Class
 */
 
/**
 * Sends and parses Twitter API requests
 *
 * <p>
 * The Twitter Search API currently does not require an API Key, however if user
 * specific timelines need to be searched an API Key will need to be aquired.
 *
 * The documentation also mentions frequency limitations (requests per unit of time)
 * </p>
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage social
 *
 * @link https://dev.twitter.com/docs/api/1/get/search Twitter Search API Documentation
 *
 */
class TwitterService Extends SocialService
{

    /**
     * @var string The service being seached is Twitter
     */
	public $service = "Twitter";
	
	public function getServiceName() {
        return $this->service;
    }
	
    /**
     * Formulates the REST URI request
     *
     * @param string $format The response format [json/xml]
     * @param array $paramaters The paramaters to be made part of the URI
     *
     * @return url
     */
	protected function getSearchUrl ($format, $paramaters ) {
    	return "http://search.twitter.com/search.". $format ."?". http_build_query($paramaters, "&");
	}//END function getSearchUrl

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
	protected function retrieveMessages( $search, $since, $until, $limit ) {
        
		$url =  $this->getSearchUrl(
			"json", //specify json as the return type
			array (
				"q" => $search ."+since:+".date('Y-m-d', $since)."until:".date('Y-m-d', $until),
				"result_type" => "mixed", //this is so that we receive a retweet count
				"lang" => "en" //specify the natural language that is expected
			)
		);
		
		return file_get_contents( $url );
	}//END function retrieveMessages()

    /**
     * Converts the JSON provided by retrieveMessages() to a PHP Object
     *
     * @param JSONString $serviceData
     *
     * @return object The object to be stored
     */
	public function parseData( $serviceData ) {
        
		$serviceData = json_decode( $serviceData );
		return $serviceData->results;
        
	}//ENd function parseData()
    
    /**
     * Gets the actual message from the raw data 
     *
     * @param object $data An element of the array retrieved by getData
     *
     * @return string The message
     */
    public function getMessage( $data ) {
        return $data->text;
    }//END function getMessage

}//END class TwitterService

?>
