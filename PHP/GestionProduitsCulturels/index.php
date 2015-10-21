<?php
include_once('Client.php');

$worker = new Client;

foreach ($worker->getCulturalProducts() as $product) {
    echo $product->getMetadata()."<br/>";
}
