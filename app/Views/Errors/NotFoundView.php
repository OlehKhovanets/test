<?php

namespace App\Views\Errors;

class NotFoundView
{
    public function output()
    {
        $mustache = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates')
        ));

        $tpl = $mustache->loadTemplate('not_found');

        echo $tpl->render();
    }
}