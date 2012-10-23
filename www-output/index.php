<!--
Much of the code for this file was borrowed from the annotated time line from the Google Charts API Playground
This can be found here:
http://code.google.com/apis/ajax/playground/?type=visualization#annotated_time_line
-->

<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Google Visualization API Sample</title>
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load('visualization', '1', {packages: ['annotatedtimeline']});
		
		/* Constructing the Annotated Timeline from the information table */
		function drawVisualization(dataItems)
		{
			var data = new google.visualization.DataTable(dataItems);
			
			/* Construction the table for the timeline */
			data.addColumn('date', 'Date');
			data.addColumn('number', 'FaceBook');
			data.addColumn('number', 'Google Plus');
			data.addColumn('number', 'Reddit');
			data.addColumn('number', 'Twitter');
			data.addRows(dataItems);
			
			/* The Actual construction of the timeline */
			var annotatedtimeline = new google.visualization.AnnotatedTimeLine(
				document.getElementById('visualization'));
			annotatedtimeline.draw(data, {'displayAnnotations': true});
		}
		
		/* When there is no data */
		function init()
		{
			/*data = [
//				['x',	'g++',	'Twitter',	'Reddit', 'FaceBook']
				[new Date(2008, 0 ,1),		1,		1,		0.5,	1],
				[new Date(2008, 1 ,2),		2,		0.5,	1,		1],
				[new Date(2008, 2 ,3),		4,		1,		0.5,	1],
				[new Date(2008, 3 ,4),		8,		0.5,	1,		1],
				[new Date(2008, 4 ,5),		7,		1,		0.5,	1],
				[new Date(2008, 5 ,6),		7,		0.5,	1,		1],
				[new Date(2008, 6 ,7),		8,		1,		0.5,	1],
				[new Date(2008, 7 ,8),		4,		10,		1,		1],
				[new Date(2008, 8 ,9),		2,		1,		0.5,	1],
				[new Date(2008, 9 ,10),		3.5,	0.5,	1,		1],
				[new Date(2008, 10 ,11),	3,		1,		0.5,	1],
				[new Date(2008, 11 ,12),	3.5,	0.5,	1,		1],
				[new Date(2009, 0 ,13),		1,		1,		0.5,	1],
				[new Date(2009, 1 ,14),		1,		0.5,	1,		1]
			];*/
			
			data = [
			
				<?php
				
				echo implode(",\n", SentServiceToString());				
				?>
				
				
			];
			
			drawVisualization(data);
			drawGuageVisualization(1);
		}
		
		google.setOnLoadCallback(init);
	</script>
	</head>
	
	<body style="font-family: Arial;border: 0 none;">
	
	    <div id="guage1" style=""></div>
		<div id="visualization" style="width: 800px; height: 400px;"></div>
		<?php
		
		/* Get the sentiment */
		function sent( $message )
		{
			/* Return 0 instead of neutral */
			if ($message['sentiment']['response']['docSentiment']['type'] == 'neutral')
			{
				return 0;
			}
			
			return $message['sentiment']['response']['docSentiment']['score'];
		}
		
		/* Get the array for the timeline */
		function SentServiceToString()
		{
			$sent = getSentByService();
			$jsData = array();
			
			foreach ($sent as $date => $services)
			{
				/* Reformat the time for the java portion */
				$date = explode("-", $date);
				$string = '[new Date('. $date[0]  .','. $date[1]  .','. $date[2] .')';
				
				/* Create the second part of the array */
				$servicesValues = array();
				
				/* Calculate and fill the second part of the array */
				foreach ($services as $service)
				{
					$servicesValues[] = $service['totalSent'] / $service['count'];
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
			$sentArr = array();
			
			/* Process the information into an array */
			foreach($collection->find(array(), $fields) as $message)
			{
				/* Make the indexes variables */
				$firstIndex = date("Y-m-d", $message['date']);
				$secondIndex = $message['service'];
				
				/* Find the sum of total sentiment and the number of entries */
				if( !isset($sentArr[$firstIndex][$secondIndex]['totalSent'])  )
				{
					// Initialize the values
					$sentArr[$firstIndex][$secondIndex]['totalSent'] = sent($message);
					$sentArr[$firstIndex][$secondIndex]['count'] = 1;
				}
				else
				{
					// Increment the values
					$sentArr[$firstIndex][$secondIndex]['totalSent'] += sent($message);
					$sentArr[$firstIndex][$secondIndex]['count']++;
				}
			}
			
			/* Alphabetize the entries */
			foreach( array_keys($sentArr) as $arrKey)
			{
				ksort($sentArr[$arrKey]);
			}
			
			return $sentArr;
		}
		
		?>
	</body>
</html>