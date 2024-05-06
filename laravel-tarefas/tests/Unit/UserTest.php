<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    // use RefreshDatabase;

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

    public function test_CheckIfUserCreateIsWorking()
    {
        $user = User::factory()->create([
            "name" => "José",
            "telefone" => "(99) 99999-9999",
            "email" => "jose" . rand(1, 99) . "@teste.com.br",
            "password" => Hash::make("1234567890"),
        ]);

        $response = $this->actingAs($user)->post("/register");

        $response->assertSessionHasNoErrors()->assertRedirect("/agenda");

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_CheckLoginWithCredentials()
    {
        $usuario = new User([
            "name" => "José",
            "telefone" => "(99) 99999-9999",
            "email" => "jose21@teste.com.br",
            "password" => Hash::make("1234567890"),
        ]);
        $response = $this->actingAs($usuario)->post("/login");

        $response->assertSessionHasNoErrors()->assertRedirect("/agenda");

        $page = $this->get("/agenda");
        $page->assertSessionHasNoErrors()->assertSeeText("Lista das Tarefas");

        $this->assertAuthenticatedAs($usuario);
    }

    public function test_CheckCreateNovaTarefaIsWorking()
    {
        $this->test_CheckLoginWithCredentials();

        $response = $this->post("/agenda", [
            // Este campos só irá inserir se a linha:
            // $input["user_id"] = auth()->user()->id;
            // Não estiver no AgendaController.
            "user_id" => 53,
            "nome" => "Teste de Tarefa",
            "descricao" => "Teste de Tarefa. Teste de Tarefa.",
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect("/agenda");

        $page = $this->get("/agenda");
        $page
            ->assertSessionHasNoErrors()
            ->assertSeeText("Tarefa adicionada com sucesso!");
    }
}
