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
			data.addColumn('number', 'g++');
			data.addColumn('number', 'Twitter');
			data.addColumn('number', 'Reddit');
			data.addColumn('number', 'FaceBook');
			data.addRows(dataItems);
			
			/* The Actual construction of the timeline */
			var annotatedtimeline = new google.visualization.AnnotatedTimeLine(
				document.getElementById('visualization'));
			annotatedtimeline.draw(data, {'displayAnnotations': true});
		}
		
		/* When there is no data */
		function init()
		{
			data = [
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
			];
			
			drawVisualization(data);
		}
		
		google.setOnLoadCallback(init);
	</script>
	</head>
	
	<body style="font-family: Arial;border: 0 none;">
		<div id="visualization" style="width: 800px; height: 400px;"></div>
		<?php
		
		$fields = array(
		    "searchString":1,
		    "service":1,
		    "sentiment.response.docSentiment":1
		);
		
		?>
	</body>
</html>