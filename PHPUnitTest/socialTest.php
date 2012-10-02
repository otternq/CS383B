<?php

require_once "../getSocialData/config.php";

require_once 'PHPUnit/Autoload.php';

/** include application classes */
require_once (BASE_DIR ."/service/service.php");

require_once (BASE_DIR ."/social/socialService.php");
require_once (BASE_DIR ."/social/googlePlusService.php");
require_once (BASE_DIR ."/social/twitterService.php");
require_once (BASE_DIR ."/social/facebookService.php");

require_once (BASE_DIR ."/sentiment/sentiment.php");
require_once (BASE_DIR ."/sentiment/alchemySentiment.php");
require_once (BASE_DIR ."/social/redditService.php");

class SocialServiceTest extends PHPUnit_Framework_TestCase {
    
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
     */
    public function testGetObject() {
        
        foreach ( SocialService::availableServices() as $serviceName ) {
            
            $serviceObj = SocialService::getObject( $serviceName );
            
            $this->assertInstanceOf( $serviceName ."Service" , $serviceObj);
            
        }
        
    }
    
    /**
     * @depends testGetObject
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
                
                $this->$subTest( $data );
                
                
                
            }
            
            
        }
    }
    
    public function subTestGetDataTwitter( $data ) {}
    public function subTestGetDataGooglePlus( $data ) {}
    public function subTestGetDataFacebook( $data ) {
	$test = "Hello";
	}
    public function subTestGetDataReddit( $data ) {}
    
}

?>
