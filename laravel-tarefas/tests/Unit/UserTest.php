<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_CheckIfUserColumnsIsCorrect()
    {
        $user = new User();

        $expected = ["name", "email", "telefone", "password"];
        // EAP: Campos criados mas não informado em $fillable do Model.
        // "email_verified_at",
        // "remember_token",
        // "created_at",
        // "updated_at",

        $arrayCompared = array_diff($expected, $user->getFillable());

        $this->assertEquals(0, count($arrayCompared));
    }
}
