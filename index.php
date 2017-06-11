<?php

include "vendor/autoload.php";

use Twitter\Search\Search;

$search = new Search();
$search->setToken("", "");
$value = ["q" => "neema"];

print_r($search->search($value));
