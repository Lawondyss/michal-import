<?php

namespace Parser;

use Parser\CustomerC;

abstract class XmlParser implements Parser
{
  public function __construct(
    protected string $file,
  ) {
  }
  
  
  public static function createForCustomerC(string $file): self
  {
    return new CustomerC\XmlParser($file);
  }
  
  
  /**
   * @return array<string, mixed>
   */
  protected function elementToArray(\SimpleXMLElement $element): array
  {
    return \json_decode(\json_encode($element), associative: true);
  }
  
  
  /**
   * @return array<string, mixed>
   */
  protected function attributesToArray(\SimpleXMLElement $element): array
  {
    return \json_decode(\json_encode($element), associative: true)['@attributes'] ?? [];
  }
}
