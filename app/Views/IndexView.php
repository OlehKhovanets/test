<?php

namespace App\Views;

class IndexView
{
    public function output()
    {
        if(!empty($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
        } else {
            $errors = [];
        }

        $mustache = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates')
        ));

        $tpl = $mustache->loadTemplate('index');

        echo $tpl->render(['errors' => $errors]);
    }
}