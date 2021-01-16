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
        $url = sprintf('%s%s%s%s', 'http://api.ipstack.com/', $ip, '?access_key=', config('app', 'access_key'));
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