<?php

namespace Morpher\CustomerC;

use Morpher\Morpher;

final class ProductMorpher implements Morpher
{
  private const PriceWoVat = 'priceWoTax';
  private const Vat = 'tax';
  
  public function morph(array $data): array
  {
    $output = [
      ...$data,
      'priceWoVat' => $data[self::PriceWoVat],
      'priceWithVat' => $this->priceWithVat($data),
      'vat' => $this->vat($data),
    ];
    
    unset($output[self::PriceWoVat], $output[self::Vat]);
    
    return $output;
  }
  
  
  private function priceWithVat(array $data): ?float
  {
    if (isset($data['priceWithVat'])) {
      return (float)$data['priceWithVat'];
    }
    
    return match($this->vat($data)) {
      null => null,
      0 => (float)$data[self::PriceWoVat],
      default => \round(\floatval($data[self::PriceWoVat]) * (1 + $this->vat($data) / 100), 2)
    };
  }
  
  
  private function vat(array $data): ?int
  {
    return ($data[self::Vat] ?? []) === [] ? null : (int)$data[self::Vat];
  }
}
