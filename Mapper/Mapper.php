<?php

namespace Mapper;

use Entity\Entity;
use Entity\Product;
use Morpher\Morpher;

class Mapper
{
  /**
   * @param class-string<Entity> $entityClass
   */
  private function __construct(
    private readonly string $entityClass,
    private readonly ?Morpher $morpher,
  ) {
  }
  
  
  public static function createForProducts(?Morpher $morpher = null): self
  {
    return new self(Product::class, $morpher);
  }
  
  
  /**
   * @param array<string, mixed> $data
   * @return <Entity>
   */
  public function map(array $data): Entity
  {
    $data = $this->morpher?->morph($data) ?? $data;
    
    return new ($this->entityClass)(...$data);
  }
}
