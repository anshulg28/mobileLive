<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('isStringSet'))
{
    function isStringSet($var = '')
    {
        return $var!=='';
    }
}

if (!function_exists('myIsArray'))
{
    function myIsArray($data = array())
    {
        if(isset($data) && count($data) > 0 && !empty($data))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('myIsMultiArray'))
{
    function myIsMultiArray($data = array())
    {
        foreach($data as $key => $row)
        {
            if(count($row) != 0)
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('myInArray'))
{
    function myInArray($value = '', $stack = '')
    {
        if(myIsArray($stack) && isStringSet($value) && in_array($value, $stack))
        {
            return $value;
        }
        else
        {
            return false;
        }
    }
}

if(!function_exists('getUniqueLink'))
{
    function getUniqueLink($data = '')
    {
        $data = strtolower($data);
        $data = str_replace(' ', '-', $data);

        $data = preg_replace('/[^A-Za-z0-9\-]/', '', $data);

        $data = str_replace('--', '-', $data);

        return $data;
    }
}

if (!function_exists('isSession'))
{
    function isSession($value)
    {
        if(!is_null($value))
        {
            return $value;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('isSessionVariableSet'))
{
    function isSessionVariableSet($value = '')
    {
        if($value !== '')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('sortMultiArray'))
{
    function sortMultiArray($array = array(), $value = '')
    {
        if(isset($array))
        {
            for($i = 0;$i<count($array);$i++)
            {
                for($j = 0;$j<count($array);$j++)
                {
                    if($array[$i][$value] < $array[$j][$value])
                    {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                }
            }
            return $array;
        }

    }
}

if (!function_exists('ReversesortMultiArray'))
{
    function ReversesortMultiArray($array = array(), $value = '')
    {
        if(isset($array))
        {
            for($i = 0;$i<count($array);$i++)
            {
                for($j = 0;$j<count($array);$j++)
                {
                    if($array[$i][$value] > $array[$j][$value])
                    {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                }
            }
            return $array;
        }

    }
}

if (!function_exists('highlight'))
{
    function highlight($regex,$text)
    {
        preg_match_all($regex, $text, $m);
        if(!$m)
            return $text;
        foreach($m[0] as $hashkey => $hashrow)
        {
            $descrip[$hashkey] = '<label>'.$hashrow.'</label>';
        }
        if(isset($descrip))
        {
            return  str_replace($m[0],$descrip,$text);
        }
        else
        {
            return $text;
        }
    }
}

if (!function_exists('getTimeLapsed'))
{
    function getTimeLapsed($dateStr)
    {
        $dStart = strtotime($dateStr);
        /*$dEnd = new DateTime();
        $dDiff = $dStart->diff($dEnd);*/

        $diff = time() - $dStart;

        if ($diff <= 0) {
            return 'Now';
        }
        else if ($diff < 60) {
            return grammar_date(floor($diff), ' second(s) ago');
        }
        else if ($diff < 60*60) {
            return grammar_date(floor($diff/60), ' minute(s) ago');
        }
        else if ($diff < 60*60*24) {
            return grammar_date(floor($diff/(60*60)), ' hour(s) ago');
        }
        else if ($diff < 60*60*24*30) {
            return grammar_date(floor($diff/(60*60*24)), ' day(s) ago');
        }
        else if ($diff < 60*60*24*30*12) {
            return grammar_date(floor($diff/(60*60*24*30)), ' month(s) ago');
        }
        else {
            return grammar_date(floor($diff/(60*60*24*30*12)), ' year(s) ago');
        }
    }
}

if (!function_exists('grammar_date'))
{
    function grammar_date($val, $sentence) {
        if ($val > 1) {
            return $val.str_replace('(s)', 's', $sentence);
        } else {
            return $val.str_replace('(s)', '', $sentence);
        }
    }
}

if(!function_exists('encrypt_data'))
{
    function encrypt_data($data)
    {
        return hash_hmac('sha256', $data, 'even');
    }
}

if(!function_exists('encrypt_jukebx_data'))
{
    function encrypt_jukebx_data($data)
    {
        return hash_hmac('sha256', $data, 'jukebx');
    }
}

if(!function_exists('hash_compare'))
{
    function hash_compare($a, $b) {
        if (!is_string($a) || !is_string($b)) {
            return false;
        }

        $len = strlen($a);
        if ($len !== strlen($b)) {
            return false;
        }

        $status = 0;
        for ($i = 0; $i < $len; $i++) {
            $status |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $status === 0;
    }
}
if(!function_exists('isEventFinished'))
{
    function isEventFinished($eventDate,$endTime) {

        $result = false;

        $date1 = date_create(date('Y-m-d'));
        $date2 = date_create($eventDate);
        $diff = date_diff($date1, $date2);
        if($diff->format("%a") != '0')
        {
            $result = false;
        }
        else
        {
            $eventTime = date("H:i", strtotime($endTime));
            $nowTime = date('H:i');
            if($nowTime > $eventTime)
            {
                $result = true;
            }
            else
            {
                $result = false;
            }
        }

        return $result;
    }
}

if(!function_exists('isEventStarted'))
{
    function isEventStarted($eventDate,$startTime) {

        $result = false;

        $date1 = date_create(date('Y-m-d'));
        $date2 = date_create($eventDate);
        $diff = date_diff($date1, $date2);
        if($diff->format("%a") != '0')
        {
            $result = false;
        }
        else
        {
            $eventTime = date("H:i", strtotime($startTime));
            $nowTime = date('H:i');
            if($nowTime > $eventTime)
            {
                $result = true;
            }
            else
            {
                $result = false;
            }
        }

        return $result;
    }
}

if(!function_exists('slugify'))
{
    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        $random = substr( md5(rand()), 0, 7);
        $text = $text.'-'.$random;

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if(!function_exists('getExtraCCEmail'))
{
    function getExtraCCEmail($email)
    {
        $ccMail = '';

        switch($email)
        {
            case 'priyanka@brewcraftsindia.com':
                $ccMail = 'anuja@brewcraftsindia.com';
                break;
            case 'anuja@brewcraftsindia.com':
                $ccMail = 'priyanka@brewcraftsindia.com';
                break;
            case 'shweta@brewcraftsindia.com':
                $ccMail = 'krutika@brewcraftsindia.com';
                break;
        }
        return $ccMail;
    }
}