<?php

namespace Morpher\CustomerB;

use Morpher\Morpher;

final class ProductMorpher implements Morpher
{
  private const Code = 'kód';
  private const Name = 'název';
  private const PriceWoVat = 'cena bez DPH';
  private const Vat = 'DPH';
  
  public function morph(array $data): array
  {
    $output = [
      'code' => $data[self::Code],
      'name' => $data[self::Name],
      'priceWoVat' => $data[self::PriceWoVat],
      'priceWithVat' => $this->priceWithVat($data),
      'vat' => $this->vat($data),
    ];
    
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
