<?php

namespace Parser;

use Generator;

interface Parser
{
  /**
   * @return Generator<array<string, mixed>>
   */
  public function parse(): Generator;
}
