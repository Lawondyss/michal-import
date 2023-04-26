<?php

use Database\Connection;
use Mapper\Mapper;
use Morpher\CustomerA;
use Morpher\CustomerB;
use Morpher\CustomerC;
use Parser\CsvParser;
use Parser\XmlParser;
use Parser\Parser;

class Importer
{
  public function __construct(
    private readonly Connection $db,
  ) {
  }
  
  
  public function importCustomerA(): void
  {
    $this->importProducts(
      Mapper::createForProducts(new CustomerA\ProductMorpher),
      CsvParser::createForCustomerA(__DIR__ . '/sources/customer-a.csv'),
    );
  }
  
  
  public function importCustomerB(): void
  {
    $this->importProducts(
      Mapper::createForProducts(new CustomerB\ProductMorpher),
      CsvParser::createForCustomerB(__DIR__ . '/sources/customer-b.csv'),
    );
  }
  
  
  public function importCustomerC(): void
  {
    $this->importProducts(
      Mapper::createForProducts(new CustomerC\ProductMorpher),
      XmlParser::createForCustomerC(__DIR__ . '/sources/customer-c.xml'),
    );
  }
  
  
  private function importProducts(Mapper $mapper, Parser $parser): void
  {
    $doser = Doser::forProducts($this->db);
    
    foreach ($parser->parse() as $data) {
      $product = $mapper->map($data);
      $doser->add($product);
    }
    
    $doser->persist();
  }
}
