<?php

namespace Database;

class Connection
{
  /**
   * @param array<array<string, mixed>> ...$rows
   * @return void
   */
  public function insert(string $table, array ...$rows): void
  {
    /* save to DB, but for a example only show SQL */
    
    $sql = "INSERT INTO `$table` ";
    
    $columns = \array_keys($rows[0]);
    $sql .= '(`' . \implode('`, `', $columns) . "`) VALUES\n";
    
    $values = [];
    foreach ($rows as $row) {
      $row = \array_map(fn(mixed $value): string => $this->quote($value), $row);
      $values[] = '(' . \implode(', ', $row) . ')';
    }
    
    $sql .= \implode(",\n", $values);
    
    echo $sql, PHP_EOL;
  }
  
  
  private function quote(mixed $value): string
  {
    return match (true) {
      \is_null($value) => 'NULL',
      \is_numeric($value) => "{$value}",
      default => "'{$value}'",
    };
  }
}
