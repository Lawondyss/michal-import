<?php

use Database\Connection;
use Entity\Entity;

final class Doser
{
  private const BATCH_SIZE = 3;
  
  /** @var Entity[] */
  private array $rows = [];
  
  private int $counter = 0;
  
  
  private function __construct(
    private readonly Connection $db,
    private string $table,
  ) {
  }
  
  
  public static function forProducts(Connection $db): self
  {
    return new self($db, 'product');
  }
  
  
  
  public function add(Entity $product): void
  {
    $this->rows[] = $product;
    
    if (++$this->counter >= self::BATCH_SIZE) {
      $this->persist();
    }
  }
  
  
  public function persist(): void
  {
    if ($this->counter === 0) {
      return;
    }
    
    $rows = array_map(static fn(Entity $entity): array => $entity->toArray(), $this->rows);
    $this->db->insert('product', ...$rows);
    $this->reset();
  }
  
  
  private function reset(): void
  {
    $this->rows = [];
    $this->counter = 0;
  }
}
