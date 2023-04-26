<?php

namespace Parser\CustomerC;

use Generator;

final class XmlParser extends \Parser\XmlParser
{
  /**
   * @inheritDoc
   */
  public function parse(): Generator
  {
    $xml = \simplexml_load_file($this->file);
    
    foreach ($xml->xpath('product') as $element) {
      $attributes = $this->attributesToArray($element->priceWoTax->attributes());

      yield [
        ...$this->elementToArray($element),
        'priceWithVat' => $attributes['withTax'] ?? null,
      ];
    }
  }
}
