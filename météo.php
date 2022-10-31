<?php
require 'OpenWeather.php';
$weather = new OpenWeather('cf653c56122f055c5b115bb3f305471a');
$forecast = $weather->getForcast('Avignon,fr');
// var_dump($forecast);
