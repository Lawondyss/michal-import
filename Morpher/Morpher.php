<?php

namespace Morpher;

interface Morpher
{
  /**
   * @param array<string, mixed> $data
   * @return array<string, mixed>
   */
  public function morph(array $data): array;
}
