<?php
require dirname(__DIR__) . '/getSocialData/autoload.php';

function my_autoloader_tester($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'socialservicetest' => '/socialTest.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }

spl_autoload_register('my_autoloader_tester');
