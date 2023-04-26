<?php

namespace Parser;

final class CsvParser implements Parser
{
  /** @var resource $stream */
  private $stream;
  
  private ?array $header = null;
  
  
  private function __construct(
    private readonly string $separator = ',',
    private readonly string $enclosure = '"',
  ) {
  }
  
  
  public static function createForCustomerA(string $file): self
  {
    $self = new self(separator: ';');
    $self->stream = \fopen($file, 'r');
    $self->header = ['name', 'code', 'price', 'vat'];
    
    return $self;
  }
  
  
  public static function createForCustomerB(string $file): self
  {
    $self = new self(enclosure: "'");
    $self->stream = \fopen($file, 'r');
    
    return $self;
  }
  
  
  public function parse(): \Generator
  {
    // defined header or use values in first line
    $header = $this->header ?? $this->getRow();
    
    while ($row = $this->getRow()) {
      yield \array_combine($header, $row);
    }
  }
  
  
  private function getRow(): array|false
  {
    return \fgetcsv($this->stream, separator: $this->separator, enclosure: $this->enclosure);
  }
}
