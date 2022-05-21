<?php
    // error_reporting(E_ERROR);

    function checkForm($method, $name) {
        if(isset($method[$name]) && !empty($method[$name]) && trim($method[$name])) {
            return true;
        } else {
            return false;
        }
    }

    function checkError($error, $name) {
        $msg = '';
        if(isset($error[$name])) {
            $msg = '<b><span class="error">' . $error[$name] . '</span></b>';
        }
        return $msg;
    }

    function getPostedTime($date) {
        $datetime1 = new DateTime($date);
        $datetime2 = new DateTime(date('Y-m-d H:i:s'));
        $difference = $datetime1 -> diff($datetime2);
        $msg  =  'Posted: ';
        
        if ($difference -> y > 0) {
          $msg .= $difference ->  y . ' years ';
        }

        if ($difference -> m > 0) {
          $msg .= $difference -> m . ' months ';
        }

        if ($difference -> d > 0) {
          $msg .= $difference -> d . ' days ';
        }

        if ($difference -> h > 0) {
          $msg .= $difference -> h . ' hours ';
        }
      
        if ($difference -> i > 0) {
          $msg .= $difference -> i . ' minutes ';
        }

        if ($difference -> i <= 0) {
          $msg .= 'just now';
        }

        if ($difference -> i > 0) {
         $msg .= ' ago';
        }

        return $msg;
    }

    function getShortTime($date) {
        $datetime1 = new DateTime($date);
        $datetime2 = new DateTime(date('Y-m-d H:i:s'));
        $difference = $datetime1 -> diff($datetime2);
        $shortMsg = 'Posted: ';

        if ($difference -> d > 0) {
            $shortMsg .= $difference -> d . ' days';
        } else if ($difference -> h > 0) {
            $shortMsg .= $difference -> h . ' hours ';
        } else if ($difference -> i > 0) {
            $shortMsg .= $difference -> i . ' minutes ';
        }
  
        if ($difference -> i <= 0) {
            $shortMsg .= 'just now';
        }
  
        if ($difference -> i > 0) {
            $shortMsg .= ' ago';
        }

        return $shortMsg;
    }

?>