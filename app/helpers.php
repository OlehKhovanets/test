<?php

if (!function_exists('dd')) {
    function dd($var)
    {
        echo "<pre>";
        print_r($var);
        exit;
    }
}

if (!function_exists('curl')) {
    function curl($ip)
    {
        $handle = curl_init();
        $url = sprintf('%s%s%s%s', config('app', 'api_url'), $ip, '?access_key=', config('app', 'access_key'));

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);

        return $output;
    }
}

if (!function_exists('httpMethod')) {
    function httpMethod($method)
    {
        if (strtoupper($method) !== $_SERVER['REQUEST_METHOD']) {
            (new \App\Views\Errors\ForbiddenView())->output();
            exit();
        }
    }
}

if (!function_exists('config')) {
    function config($fileName, $key)
    {
        $directory = dirname(__FILE__) . '/config';

        if (is_dir($directory)) {
            $file = sprintf('%s/%s.php', $directory, $fileName);

            if (file_exists($file)) {
                $includeFile = include $file;

                if (array_key_exists($key, $includeFile)) {
                    return $includeFile[$key];
                }
            }
        }
        return null;
    }
}

if (!function_exists('errors')) {
    function errors($request)
    {
        if (!empty($request['errors'])) {
            $_SESSION['errors'] = $request['errors'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            unset($_SESSION["errors"]);
        }
    }
}

if (!function_exists('arrGet')) {
    function arrGet($array, $value)
    {
        if(in_array($value, $array)){
            return $value;
        }

        throw new InvalidArgumentException("can not be found");
    }
}

if(!function_exists('isJson')) {
    function isJson($string) {

        return is_string($string) &&
            (is_object(json_decode($string)) ||
                is_array(json_decode($string)));
    }
}