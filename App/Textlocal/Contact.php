<?php

namespace App\Textlocal;

class Contact
{
    var $number;
    var $first_name;
    var $last_name;
    var $custom1;
    var $custom2;
    var $custom3;

    var $groupID;

    /**
     * Structure of a contact object
     * @param        $number
     * @param string $firstname
     * @param string $lastname
     * @param string $custom1
     * @param string $custom2
     * @param string $custom3
     */
    function __construct($number, $firstname = '', $lastname = '', $custom1 = '', $custom2 = '', $custom3 = '')
    {
        $this->number = $number;
        $this->first_name = $firstname;
        $this->last_name = $lastname;
        $this->custom1 = $custom1;
        $this->custom2 = $custom2;
        $this->custom3 = $custom3;
    }
}

;

/**
 * If the json_encode function does not exist, then create it..
 */

if (!function_exists('tlc_json_encode')) {
    function tlc_json_encode($a = false)
    {
        if (is_null($a)) return 'null';
        if ($a === false) return 'false';
        if ($a === true) return 'true';
        if (is_scalar($a)) {
            if (is_float($a)) {
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if (is_string($a)) {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            } else
                return $a;
        }
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
            if (key($a) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach ($a as $v) $result[] = tlc_json_encode($v);
            return '[' . join(',', $result) . ']';
        } else {
            foreach ($a as $k => $v) $result[] = tlc_json_encode($k) . ':' . tlc_json_encode($v);
            return '{' . join(',', $result) . '}';
        }
    }


}