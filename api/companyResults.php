<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
	
//	date & sentiment of search terms
	
	
	/* Get the data for the table */
	$table = array();
	$table = array_merge($table,SentSearchToString());
	echo json_encode($table);
	
	
	/* Get the array for the table */
	function SentSearchToString()
	{
		$sent = getSentBySearch();
		$jsData = array();
		
		foreach ($sent as $date => $searches)
		{
			/* Create and fill the second part of the array */
			$searchValues = array();
			$searchValues[] = $date;
			
			/* Average the results for each search */
			foreach ($searches as $search)
			{
				$searchValues[] = $search['sentimentSum'] / $search['count'];
			}
			
//			$searchValues[] = StockHelper::getStockHistoryGen($date);
			
			/* Combine the strings */
			$jsData[] = $searchValues;
			
			
			/* Clear the values and release them */
			unset($string);
			unset($searchValues);
		}
		
		return $jsData;
	}
	
	
	function getSentBySearch()
	{
        
        $query = array();
        
        if (!empty($_GET['company'])) {
            $query = array("searchString" => $_GET['company']);
        }
        
		/* An array of the fields of information desired */
		$fields = array(
			"searchString" => 1,
			"service" => 1,
			"sentiment.response.docSentiment" => 1,
			"date" => 1
		);
		
		/* Where to go, which database, and which collection */
		$m = new Mongo("mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock");
		$db = $m->selectDB('socialstock');
		$collection = new MongoCollection($db, 'messages');
		
		/* Create an array for the sentiment */
		$resultArray = array();
		
		/* Process the information into an array */
		foreach($collection->find($query, $fields) as $message)
		{
			/* Make the indexes variables */
			$firstIndex = date("Y-m-d", $message['date']);
			$secondIndex = $message['searchString'];
			
			/* Find the sum of results and the number of entries */
			if( !isset($resultArray[$firstIndex][$secondIndex]['sentimentSum']) )
			{
				// Initialize the values
				$resultArray[$firstIndex][$secondIndex]['sentimentSum'] = sent($message);
				$resultArray[$firstIndex][$secondIndex]['count'] = 1;
			}
			else
			{
				// Increment the values
				$resultArray[$firstIndex][$secondIndex]['sentimentSum'] += sent($message);
				$resultArray[$firstIndex][$secondIndex]['count']++;
			}
			
		}
		
		/* Alphabetize the entries */
		foreach( array_keys($resultArray) as $arrKey)
		{
			ksort($resultArray[$arrKey]);
		}
		return $resultArray;
	}
	
	/* Returns the sentiment as a numeric value */
	function sent( $message )
	{
		/* Return 0 instead of neutral */
		if ($message['sentiment']['response']['docSentiment']['type'] == 'neutral')
		{
			return 0;
		}
		return $message['sentiment']['response']['docSentiment']['score'];
	}
?>