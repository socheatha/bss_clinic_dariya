<?php

namespace App\Helpers;

class AppHelper
{
    public static function IsInternetConnected()
    {
        $connected = @fsockopen("www.bssdatacenter.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }

    public static function IsProjectHosted()
    {
        return !in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost']);
    }

    public static function GetMySqlDump()
    {
        if (self::IsProjectHosted()) {
            return ['/usr/bin/mysqldump'];
        } else {
            return env('SQL_DUMP_PATH') ?: substr(__DIR__, 0, strpos(__DIR__, 'htdoc')) . '\mysql\bin\mysqldump';
        }
    }

    public static function secure_element ($array = [], $key = '', $default = 'N/A', $return = true) {
        $result = is_array($array) && !empty($key) && !empty($array[$key]) ? trim($array[$key]) : $default;
        if ($return) {
            return $result;
        } else {
            echo $result;
        }
    }
}
