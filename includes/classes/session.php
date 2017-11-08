<?php

    class session
    {
        
        /*
         * Start the session
         *
         */
        public static function init ()
        {
            @session_start();
        }

        /*
         * Set session key
         *
         */
        public static function set ($key, $value)
        {
            $_SESSION[$key] = $value;
    		return true;
        }
        

        /*
         * Get a session from the key
         *
         */
        public static function get ($key)
        {
           return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }
        

        /*
         * Unsets a session through the key
         *
         */
        public static function destroy ($key)
        {
            unset($_SESSION[$key]);
            //session_destroy();
        }


        /*
         * Function to be in charge of encrypting our password
         * Make sure you make is as more secured as possible you can
         * if you want to use it in serious projects
         *
         */
        public static function hashPassword($password)
        {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /*
         * Function our encrypted password
         * You can change the function structure based on the hashing function
         *
         */
        public static function passwordMatch($password, $hash)
        {
            return password_verify($password, $hash);
        }
    }
    
