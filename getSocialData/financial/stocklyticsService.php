<?php
/**
 * The file that contains the Stocklytics Service Class
 */


/**
 * Sends and Parses API requests to Stocklytics' API
 *
 * <p>
 * Stocklytics allows 100 free requests, there are size restrictions
 * </p>
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage financial
 *
 * @link http://php.net/abstract documentation for an abstract class
 * @link http://php.net/static documentation for an static method
 */
class StocklyticsService extends FinancialService {
    
    /**
     * @var string The name of the service being used
     */
    public $service = "Stocklytics";
    
    public function getServiceName() 
    {
        return $this->service;
    }
    
    /**
     * @ignore
     * @var The API key used to access Stocklytics API
     */
    protected $apiKey = "87175fbebf1747bb68eba06aa795a48388f461e8";
    
    /**
     * Finds stock data for the given company and date range
     *
     * @param string $company Stock Code
     * @param int $startDate unix timestamp for the start of the date range
     * @param int $endDate unix timestamp for the end of the date range
     *
     * @return object
     */
    public function getHistory( $company, $startDate = null, $endDate = null ) {
        
        $apiEndPoint = "http://api.stocklytics.com/historicalPrices/1.0/".
        "?api_key=".$this->apiKey."&stock=". $company ."&format=JSON".
        "&order=DESC";
        
        if ( $startDate != null ) {
            $apiEndPoint .= "&start=". date("Y-m-d", $startDate);
        }
        
        if ( $endDate != null ) {
            $apiEndPoint .= "&end=". date("Y-m-d", $endDate);
        }
        
        return json_decode(
            file_get_contents(
                $apiEndPoint
            )
        );
        
    }//END function getHistory
    
    /**
     * Finds information about the company represented by the provided stock code
     *
     * @param string $company Stock Code
     *
     * @return array An array of objects
     */
    public function getCompanyData( $company ) {
        
        $apiEndPoint = "http://api.stocklytics.com/companyData/1.0/" .
        "?api_key=".$this->apiKey."&stock=". $company;
        
        $rawData = json_decode( 
            file_get_contents( 
                $apiEndPoint 
            ) 
        );
        
        $dataSet = array();
        
        foreach($rawData as $key => $value) {
            
            $dataSet[] = (stdClass)array_merge(
                array($key),
                $value
            );
            
        }
        
        return $dataSet;
        
    }//END function getCompanyData
    
}

?>