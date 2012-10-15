<?php

class YahooService {

    function getURL($company) {
        $url = 'http://ichart.finance.yahoo.com/table.csv?s='.$company.'&d=5&e=16&f=2012&g=d&a=3&b=12&c=1996&ignore=.csv';

        return $url;
    }
    
    function parseCSV( $url ) {
        $rawDataList = explode("\n", file_get_contents($url));
        
        $dataList = array();
        
        foreach($rawDataList as $rawData) {
            $data = explode(",", $rawData);
            $dataList[] = $data;
        }
        
        return $dataList;
    }
    
    function getHistory($company, $startDate = null, $endDate = null) {
        
        $url = $this->getURL($company);
        
        $dataList = $this->parseCSV($url);
        
        for($i = 0; $i < count($dataList); $i++) {
        
            $tempStock = new StockEntry();
            
            $tempStock->date = $dataList[$i][0];
            $tempStock->open = $dataList[$i][1];
            $tempStock->high = $dataList[$i][2];
            $tempStock->low = $dataList[$i][3];
            $tempStock->close = $dataList[$i][4];
            $tempStock->volume = $dataList[$i][5];
            
            $dataList[$i] = &$tempStock;
        }
        
        return $dataList;
        
    }  

}

$service = new YahooService();
$service->getHistory("AAPL");

?>