<?php
/**
 * Sends text through Sentiment Analysis
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage deamon
 *
 */

// Load the AlchemyAPI module code.
include "/opt/AlchemyAPI_PHP5-0.8/module/AlchemyAPI.php";
include "/var/script/getSocialData/sentiment/sentiment.php";

$sentimentObj = SentimentService::getObject("Alchemy");

print_r ( $sentimentObj->getSentiment("Hi, I am having a great day") );

echo "\n\n";

?>