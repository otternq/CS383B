<?php

$search = "apple";

$url = "http://www.reddit.com/search.json?q=".$search."&syntax=plain";

//print what is given at the specified url
$response = json_decode( file_get_contents($url) );

/*foreach ($response->data->children as $child) {
    print_r ($child);
}
*/

/*foreach ( $response->data->children[0]->data as $key => $value ) {
    echo $key ."\n";
}*/

print_r ($response->data->children[0]->data->selftext);

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
class RedditService extends SocialService {
    
    public $service = "Reddit";
    
    /**
     * Creates the URL that our request will be sent to
     *
     * @param string $search The string that will be searched for
     * @param string $format [json/xml]
     */
    protected function getSearchUrl ($search, $format) {
        return "http://www.reddit.com/search.".$format."?q=".$search."&syntax=plain";
    }
    
    
    
}


?>