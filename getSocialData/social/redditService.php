<?php

$url = "http://www.reddit.com/search.json?q=Apple&syntax=plain";

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




?>