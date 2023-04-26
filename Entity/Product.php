<?php

namespace Entity;

class Product extends Entity
{
  public function __construct(
    public readonly string $code,
    public readonly string $name,
    public readonly float $priceWoVat,
    public readonly ?float $priceWithVat,
    public readonly ?int $vat,
  ) {
  }
}
