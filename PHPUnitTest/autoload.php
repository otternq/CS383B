<?php
require dirname(__DIR__) . '/getSocialData/autoload.php';

spl_autoload_register(
   function($class) {
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
);
