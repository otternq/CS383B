<?php
/**
 * File that contains the abstract financial service
 */
 
/**
 * Describes the expected function of a financial class
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage financial
 *
 * @link http://php.net/abstract documentation for an abstract class
 * @link http://php.net/static documentation for an static method
 */
abstract class FinancialService implements Service {
    
    /**
     * Return stock data for the given company and date range
     *
     * @param string $company Stock Code
     * @param int $startDate unix timestamp for the start of the date range
     * @param int $endDate unix timestamp for the end of the date range
     *
     * @return object
     */
    public abstract function getHistory( $company, $startDate, $endDate );
    
    /**
     * Finds information about the company represented by the provided stock code
     *
     * @param string $company Stock Code
     *
     * @return object
     */
    public abstract function getCompanyData( $company );
    
    /**
     * Create and return an object based on the service requested
     *
     * @param string $service The service to process the text
     *
     * @return object The object created
     */
    public static function getObject( $service ) {
        $serviceClass = ucwords( $service ) .'Service';
        
        //returns an object of the class specified by the $serviceClass string
    	return new $serviceClass();
    }//END function getObject
    
}

?>