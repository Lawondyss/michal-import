<?php

spl_autoload_register(function ($class) {
  $dir = __DIR__;
  $path = str_replace('\\', '/', $class);
  require "{$dir}/{$path}.php";
});

use Database\Connection;

$importer = new Importer(new Connection);

echo "Customer A\n";
$importer->importCustomerA();
echo "\nCustomer B\n";
$importer->importCustomerB();
echo "\nCustomer C\n";
$importer->importCustomerC();
