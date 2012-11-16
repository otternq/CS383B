<?php
/**
 * The file that tests our code using PHPUnit
 *
 * @author Nick Otter <otternq@gmail.com>
 */
/*require_once "/home/otternq/stock/getSocialData/config.php";
require_once "/home/otternq/stock/debug.php";*/

require_once "autoload.php";
require_once 'PHPUnit/Autoload.php';

/** include application classes */
/*require_once (BASE_DIR ."/service/service.php");

require_once (BASE_DIR ."/social/socialService.php");
require_once (BASE_DIR ."/social/googlePlusService.php");
require_once (BASE_DIR ."/social/twitterService.php");
require_once (BASE_DIR ."/social/facebookService.php");

require_once (BASE_DIR ."/sentiment/sentiment.php");
require_once (BASE_DIR ."/sentiment/alchemySentiment.php");
require_once (BASE_DIR ."/social/redditService.php");*/

/**
 * The Social Service Test using PHPUnit
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @package socialStocks
 * @subpackage UnitTest
 *
 * @link http://www.phpunit.de/manual/current/en/ PHPUnit Documentation
 */
class SocialServiceTest extends PHPUnit_Framework_TestCase {
    
    /**
     * @author Nick Otter <otternq@gmail.com>
     */
    public function testAvailableServices() {
        
        $this->assertEquals( 
            SocialService::availableServices(), 
            array (
                "Twitter",
        		"GooglePlus",
                "Facebook",
                "Reddit"
        	)
        );
        
    }
    
    /**
     * @depends testAvailableServices
     *
     * @author Nick Otter <otternq@gmail.com>
     */
    public function testGetObject() {
        
        foreach ( SocialService::availableServices() as $serviceName ) {
            
            //creates and assigns a service object of the type specified by $serviceName ie Facebook -> FacebookService
            $serviceObj = SocialService::getObject( $serviceName );
            
            $this->assertInstanceOf( $serviceName ."Service" , $serviceObj);
            
        }
        
    }
    
    /**
     * @large
     *
     * @author Nick Otter <otternq@gmail.com>
     */
    public function testGetData() {
        
        foreach ( SocialService::availableServices() as $serviceName ) {
            
            $serviceObj = SocialService::getObject( $serviceName );
            
            $dataSet = null;
            
            $dataSet = $serviceObj->getData("apple");
            
            $this->assertInternalType("array", $dataSet);
            
            foreach ($dataSet as $data) {
                
                $subTest = "subTestGetData". $serviceName;
                
                $this->assertInstanceOf("stdClass", $data);
                
            }
            
            
        }
    }
    
    /**
     * @depends testGetObject
     * @large
     *
     * Tests to see of the messages were recieved properly
     *
     * <p>This is going to be ticky because the method retrieveMessages() is 
     * protected and cannot be accessed publicly, going to use make a reflection
     * class that then sets the methods access to public for the test</p>
     */
    function testRetrieveMessages() {
        $term = "Apple";
        //walks through an array provided by the service class
        foreach ( SocialService::availableServices() as $serviceName ) {
            
            //create and assign an object for the current service. I.E. FacebookService
            $serviceObj = SocialService::getObject( $serviceName );
            
            //call a local static method to access the protected function retriveMessages()
            $method = self::makeMethodPublic( $serviceName ."Service", "retrieveMessages" );
            
            //run the new publicly accessable method as if it were a method of the Service Object, passing the paramater apple
            $message = $method->invoke( $serviceObj, $term );
            
            $this->assertInternalType("string", $term);
            
            $subTest = "subTestRetrieveMessages". $serviceName;
            $this->$subTest( $message, $term );
            
        }
    }
    
    /**
     * Creates a reflection(clone) class/object for the specified class
     *
     * @param string $class The class to be reflected
     * @param string $method The method to be set public
     */
    static function makeMethodPublic( $class, $method ) {
        //create a reflection of the specified class
        $class = new ReflectionClass( $class );
        
        //gets a ReflectionMethod for the specified method
        $method = $class->getMethod($method);
        
        $method->setAccessible(true);
        
        //return the method
        return $method;
    }
    
    /**
     * A sub test for testGetData, checks to see that the response from twitter is correct
     *
     * @author Nick Otter <otternq@gmail.com>
     * @author Santiago Pina <pina3608@vandals.uidaho.edu>
     *
     * @param JSONString $message The contents of a file_get_contents, not yet parsed to json
     * @param String $term The term searched in the Social Service
     */
    public function subTestRetrieveMessagesTwitter( $message, $term ) {
        
        $data = json_decode( $message );
        
        // (expected, actual)
        $this->assertInternalType( "array", $data->results );
        
        // (expected, actual) may not be a good test, what if the response is
        // good but there were no result entries
        $this->assertGreaterThan( 0, count( $data->results ) );

//        foreach( $data->results as $res ){
//            $this->assertTrue( $this->findTerm ( $res, $term ) );
//        }
        
    }
    
    /* hey guys, 
    
       I noticed something wrong with our functions below,
       please see ticket http://184.73.239.62/mantis/view.php?id=3
       and I renamed your functions bellow to subTestRetrieveMessages<Service>( $message ),
       
       Thanks -Nick */
    
    /**
     * A sub test for testGetData, checks to see that the response from google+ is correct
     *
     * @author Nick Otter <otternq@gmail.com>
     * @author Santiago Pina <pina3608@vandals.uidaho.edu>
     *
     * @param JSONString $message The contents of a file_get_contents, not yet parsed to json
     * @param String $term The term searched in the Social Service
     */
    public function subTestRetrieveMessagesGooglePlus( $message, $term ) {
        
        $data = json_decode( $message );
        
        // (expected, actual) checks to see the the items variable is an array
        $this->assertInternalType( "array", $data->items );
        
        // (expected, actual) may not be a good test, what if the response is
        // good but there were no result entries
        $this->assertGreaterThan( 0, count( $data->items ) );

//        foreach( $data->items as $post ){
//            $this->assertTrue( $this->findTerm ( $post, $term ) );
//        }
        
    }

   /**
     * A sub test for testGetData, checks to see that the response from Facebook is correct
     *
     * @author Santiago Pina <pina3608@vandals.uidaho.edu>
     *
     * @param JSONString $message The contents of a file_get_contents, not yet parsed to json
     * @param String $term The term searched in the Social Service
     */


    
    public function subTestRetrieveMessagesFacebook( $message , $term) {
        
        $data = json_decode( $message );
        
        // (expected, actual)
        $this->assertInternalType( "array", $data->data );

        // (expected, actual) may not be a good test, what if the response is
        // good but there were no result entries
        $this->assertNotEmpty( $data->data );

        foreach( $data->data as $post ){
            $this->assertTrue( $this->findTerm ( $post, $term ) );
        }

    }
    
    
    /**
     * A sub test for testGetData, checks that the response from reddit is correct 
     * 
     * @author Sean Heagerty <heag7943@vandals.uidaho.edu>
     * 
     * @param JSONString $message The contents of file_get_contents, not yet parsed to json
     * @param String $term The term searched in the Social Service
     */
     public function subTestRetrieveMessagesReddit($message, $term)
     {
        $data = json_decode($message);
        
        // (expected, acual) checks to see that the data variable is an array
        $this->assertInstanceOf("stdClass", $data->data);
        
        // (expected, acual) checks to see that the children variable is an array
        $this->assertInternalType("array", $data->data->children);
        
        // (expected, actual) may not be a good test, what if the response is
        // good but there were no result entries
        $this->assertGreaterThan(0, count($data->data->children));
		
		// Check if $term is actually in the posts
//		foreach($data->data->children as $post)
//		{
//			$this->assertTrue($this->findterm($post,$term));
//		}
     }
    
    
   /**
     * Try to find a term at any level inside a multible level stdClass $data 
     *
     * @author Santiago Pina <pina3608@vandals.uidaho.edu>
     *
     * @param Iterable $data Structure that contains Iterable or String object inside
     * @param String $term The term searched in the Social Service
     */


    private function findTerm( $data, $term ){

      $this->assertInstanceOf( "stdClass", $data );

      if ( is_array( $data ) ){

        foreach( $data as $elem){
       
          if( is_string( $elem ) ){
            if( stripos( $elem, $term ) !== false ){
              return true;
           }
         }
          elseif( $elem instanceof stdClass ){
            // Recirsive call
            if( $this->findTerm( $elem, $term ) !== false) {
              return true;
            }
          }
        }


      }

      else{
        foreach( $data as $key => $elem){
       
          if( is_string( $elem ) ){
            if( stripos( $elem, $term ) !== false ){
              return true;
           }
         }
          elseif( $elem instanceof stdClass ){
            // Recirsive call
            if( $this->findTerm( $elem, $term ) !== false) {
              return true;
            }
          }
        }
      }
   
      return false;
    }
}

?>
