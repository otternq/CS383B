<?php

echo json_encode(SentServiceToString());	

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
        
        /* Create the second part of the array */
        $servicesValues = array("date"=>$date);
        
        /* Calculate and fill the second part of the array */
        foreach ($services as $service)
        {
            $servicesValues[$service] = $service['totalSent'] / $service['count'];
        }
        
        $jsData[] = $servicesValues;
        
        /* Clear the values and release them */
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
		