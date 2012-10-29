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
			data.addColumn('number', 'g++');
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
//				['x',	'g++',	'Twitter',	'Reddit', 'FaceBook']
			
			data = [
			
				<?php
				$algorithm = 1;
				echo implode(",\n", SentServiceToString($algorithm));				
				?>
				
			];
			
			drawVisualization(data);
		}
		
		google.setOnLoadCallback(init);
	</script>
	</head>
	
	<body style="font-family: Arial;border: 0 none;">
		<div id="visualization" style="width: 800px; height: 400px;"></div>
		<?php
		
		/* Get the array for the timeline */
		function SentServiceToString($algorithm)
		{
			$sent = getSentByService($algorithm);
			$jsData = array();
			
			foreach ($sent as $date => $services)
			{
				/* Reformat the time for the java portion */
				$date = explode("-", $date);
				$string = '[new Date('. $date[0]  .','. $date[1]  .','. $date[2] .')';
				
				/* Create and fill the second part of the array */
				$servicesValues = array();
				foreach ($services as $service)
				{
					$servicesValues[] = $service;
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
		
		function getSentByService($algorithm)
		{
			/* Where to go, which database, and which collection */
			$m = new Mongo("mongodb://otternq:Swimm3r.@ds037407.mongolab.com:37407/socialstock");
			$db = $m->selectDB('socialstock');
			$collection = new MongoCollection($db, 'results');
			
			/* Create an array for the sentiment */
			$sentArr = array();
			
			/* Process the information into an array */
			foreach($collection->find(array("algorithm" => $algorithm)) as $message)
			{
				/* Make the indexes variables */
				$firstIndex = date("Y-m-d", $message['date']);
				$secondIndex = $message['service'];
				
				/* load the result into the array */
				$sentArr[$firstIndex][$secondIndex] = $message['result'];
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