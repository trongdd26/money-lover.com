<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/31/2015
 * Time: 12:01 AM
 */
    class ParamUtils {
        private static $POST_ALLOW = true;
        private static $GET_ALLOW = true;
        public static function getParam($param){
            $value = null;
            if (ParamUtils::$GET_ALLOW && array_key_exists($param,$_GET)) $value = $_GET[$param];
            if (ParamUtils::$POST_ALLOW && array_key_exists($param,$_POST)) $value = $_POST[$param];
            return $value;
        }
    }
?>