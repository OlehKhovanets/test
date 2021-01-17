<?php

namespace App\Views;

class StatisticView
{
    public function output($output)
    {
        $mustache = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates')
        ));

        $tpl = $mustache->loadTemplate('statistic');

        echo $tpl->render(['output' => $output]);
    }
}