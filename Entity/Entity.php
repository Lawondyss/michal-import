<?php

namespace Entity;

abstract class Entity
{
  /**
   * @return array<string, mixed>
   */
  public function toArray(): array
  {
    $arr = [];
    
    foreach ((array)$this as $property => $value) {
      $arr[$this->toSnakeCase($property)] = $value;
    }
    
    return $arr;
  }
  
  
  private function toSnakeCase(string $s): string
  {
    return \preg_replace_callback(
      '~[A-Z]~',
      fn(array $matches): string => '_' . strtolower($matches[0]),
      $s
    );
  }
}
