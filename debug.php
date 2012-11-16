<?php

/**
 * Will run the print_r function if the file is in debug mode
 *
 * @author Nick Otter <otternq@gmail.com>
 *
 * @param mixed $print What to be displayed
 * @param bool $localDebug If the local area is in debug mode but the overall install is not
 */
function debug( $print, $localDebug = false ) {
    
    if ( DEBUG == true || $localDebug == true) {
        print_r($print);
    }
 
}


?>