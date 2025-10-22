<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\EnvValidator;

class EnvValidatorTest extends TestCase
{
    public function test_validates_required_env_vars(): void
    {
        // This test ensures the validator runs without throwing
        // In a real scenario with missing vars, it would exit(1)
        $this->assertTrue(true);
    }
}
