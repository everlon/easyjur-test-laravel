<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_CheckRoutesExists()
    {
        // EAP: Verificando se a URL existe.
        $response = $this->get("/")->assertStatus(200);
        $response = $this->get("/login")->assertStatus(200);
    }
    public function test_OnlyLoggedInUsersCanSeeThisRoutes()
    {
        // EAP: Verificando se é necessário login nas rotas.
        $response = $this->get("/home")->assertRedirect("/login");
        $response = $this->get("/permissoes")->assertRedirect("/login");
        // $response = $this->get("/permissao")->assertRedirect("/login"); // PATCH
        $response = $this->get("/agenda/exportacao/")->assertRedirect("/login");
        $response = $this->get("/agenda")->assertRedirect("/login");
    }
}
