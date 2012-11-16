<?php
	/* Put in the starting data */
	$table = array();
	$table[0] = "['Date', 'Algorithm 1', 'Algorithm 2', 'Algorithm 3']";
	
	/* Get the data for the table */
	$table = array_merge($table, SentServiceToString());
	echo "[";
	echo implode(",\n", $table);
	echo "]";
	
	
	/* Get the array for the table */
	function SentServiceToString()
	{
		$sent = getSentByService();
		$jsData = array();
		
		foreach ($sent as $date => $services)
		{
			/* Format the time portion */
			$date = explode("-", $date);
			$string = "['". $date[0]  .' '. $date[1]  .', '. $date[2] ."'";
			
			/* Create and fill the second part of the array */
			$servicesValues = array();
			foreach ($services as $service)
			{
				if(0 < ($service['totalRes'] / $service['count']))
				{
					$servicesValues[] = "'+'";
				}
				else if(0 > ($service['totalRes'] / $service['count']))
				{
					$servicesValues[] = "'-'";
				}
				else
				{
					$servicesValues[] = "'0'";
				}
			}
			
			/* Combine the strings */
			$string .= ', '. implode(",", $servicesValues) .']';
			$jsData[] = $string;
			
			/* Clear the values and release them */
			unset($string);
			unset($servicesValues);
		}
		
		return $jsData;
	}
	
	
	function getSentByService()
	{
		/* Where to go, which database, and which collection */
		$m = new Mongo("mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock");
		$db = $m->selectDB('socialstock');
		$collection = new MongoCollection($db, 'results');
		
		/* Create an array for the sentiment */
		$resultArray = array();
		
		/* Process the information into an array */
		foreach($collection->find(array()) as $message)
		{
			/* Make the indexes variables */
			$firstIndex = date("F-d-Y", $message['date']);
			$secondIndex = $message['algorithm'];
			
			/* Find the sum of results and the number of entries */
			if( !isset($resultArray[$firstIndex][$secondIndex]['totalRes'])  )
			{
				// Initialize the values
				$resultArray[$firstIndex][$secondIndex]['totalRes'] = $message['result'];
				$resultArray[$firstIndex][$secondIndex]['count'] = 1;
			}
			else
			{
				// Increment the values
				$resultArray[$firstIndex][$secondIndex]['totalRes'] += $message['result'];
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
?>