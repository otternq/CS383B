<?php
/**
 * Contains the financial service utility
 */
 
/**
 * Will save financial data to MongoDB
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage financial
 */
class FinancialServiceUtility {
    
    /**
     * The database interface
     * @var Mongo
     */
    $collection = null;
    
    /**
     * Creates a object
     *
     * @param Mongo $db
     */
    public function __construct($collection=null) {
        $this->setMongo($collection);
    }

    /**
     * Assignes a database interface
     *
     * @param Mongo $db
     *
     * @return bool
     */
    public function setMongo(&$collection) {
        $this->collection = $collection;
    }

    /**
     * Saves a data set to mongoDB
     *
     * @param string $service The service used to retrieve this data
     * @param array $dataSet
     *
     * @return bool
     */
    public function saveHistory($service, $dataSet) {
        
        //walk through the array
        foreach($dataSet as $dataItem) {
        
            //save the array item
            $this->saveHistoryItem($dataItem);
            
        }
    
    }//END function save history
    
    /**
     * Saves a data item to MongoDB
     *
     * @param string $service The service used to retrieve this data
     * @param object $data The data retrieved from the service request
     *
     * @return bool
     */
    public function saveHistoryItem($service, $data) {
    
        //Save the item to the MongoDB
        $this->collection->insert( 
            array (
                "date" => mktime(), //save the current UNIX TIMESTAMP
                "service" => $service,
                "data" => $data
            )
        );
        
    }//END function save history item

}//END class FinancialServiceUtility

?>