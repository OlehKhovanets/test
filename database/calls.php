<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require dirname(__FILE__, 2) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('calls', function ($table) {
    $table->increments('id');

    $table->integer('customer_id');

    $table->datetime('call_date');

    $table->string('phone_number');

    $table->string('ip');

    $table->string('continent_code');

    $table->integer('duration');
});