<?php

namespace Morpher\CustomerA;

use Morpher\Morpher;

final class ProductMorpher implements Morpher
{
  private const PriceWoVat = 'price';
  private const Vat = 'vat';
  
  public function morph(array $data): array
  {
    $output = [
      ...$data,
      'priceWoVat' => $data[self::PriceWoVat],
      'priceWithVat' => $this->priceWithVat($data),
      'vat' => $this->vat($data),
    ];
    
    unset($output[self::PriceWoVat]);
    
    return $output;
  }
  
  
  private function priceWithVat(array $data): ?float
  {
    return match($this->vat($data)) {
      null => null,
      0 => (float)$data[self::PriceWoVat],
      default => \round(\floatval($data[self::PriceWoVat]) * (1 + $this->vat($data) / 100), 2)
    };
  }
  
  
  private function vat(array $data): ?int
  {
    return $data[self::Vat] === '' ? null : (int)$data[self::Vat];
  }
}
