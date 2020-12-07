<?php
    class Config {
       public static function get($path = null) {   // 'Get' function with $path parameter
          if($path) {                               // Check if $path is not null
             $config = $GLOBALS['config'];          // Create $config variable that stores the config array in init.php
             $path = explode('/', $path);           // Take the passed $path parameter which is string separated by / and create an array from it

             foreach($path as $bit) {               // Loop through the new $path array
                if(isset($config[$bit])) {          // Check if the $config variable matches value from $path array
                   $config = $config[$bit];         // Set the $config variable to the asked config array value, basically remove whole $config array and only leave the array part THAT matches the $path array value.
                }
             }                                      // Check again if you passed more in $path and change $config accordingly
            return $config;                         // Return the newly set value of the $config from foreach loop
          }
          return false;
       }
    }
?>