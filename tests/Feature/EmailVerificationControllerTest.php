<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\VerificationController;
use Tests\TestCase;

class EmailVerificationControllerTest extends TestCase
{
    public function test_verification_controller_exposes_the_expected_methods(): void
    {
        $controller = new VerificationController();

        $this->assertTrue(method_exists($controller, 'verify'));
        $this->assertTrue(method_exists($controller, 'send'));
    }
}
