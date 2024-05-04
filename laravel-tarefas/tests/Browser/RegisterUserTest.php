<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterUserTest extends DuskTestCase
{
    /** @test */
    public function checkIfRootSiteIsCorrect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/")->assertSee("Laravel");
        });
    }

    /** @test */
    public function checkIfRegisterIsWorking()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/register")
                ->type("name", "José")
                ->type("telefone", "(99) 99999-9999")
                ->type("email", "jose" . rand(1, 99) . "@teste.com.br")
                ->type("password", "1234567890")
                ->type("password_confirmation", "1234567890")
                ->press("Cadastrar")
                ->assertSee("Lista das Tarefas")
                ->assertSee("José")
                ->assertPathIs("/agenda")
                ->driver->manage()
                ->deleteAllCookies();
        });
    }

    /** @test */
    public function checkIfLoginIsWorking()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/login")
                ->type("email", "everlon@protonmail.com")
                ->type("password", "123123123")
                ->press("Entrar")
                ->assertPathIs("/agenda")
                ->assertSee("Lista das Tarefas");
        });
    }

    /** @test */
    public function checkIfAdicionarTarefaIsWorking()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/agenda")
                ->press("Adicionar nova Tarefa")
                ->type("nome", "Teste de tarefa")
                ->type(
                    "descricao",
                    "Testando para criar uma nova tarefa em Dusk."
                )
                ->press("Salvar")
                ->assertPathIs("/agenda")
                ->assertSee("Tarefa adicionada com sucesso!");
        });
    }

    /** @test */
    public function checkIfApagarTarefaIsWorking()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/agenda")
                ->press("Apagar")
                ->acceptDialog()
                ->assertPathIs("/agenda")
                ->assertSee("Tarefa excluída com sucesso!")
                ->driver->manage()
                ->deleteAllCookies();
        });
    }

    /** @test */
    public function checkIfEditarTarefaIsWorking()
    {
        // Não sei o motivo de estar dando Logout quando chega no editar.
        // Por isso coloquei logout no check anterior.
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/login")
                ->type("email", "everlon@protonmail.com")
                ->type("password", "123123123")
                ->press("Entrar")

                ->visit("/agenda")
                ->press("Editar")
                ->type("nome", "Editando Teste de tarefa")
                ->type(
                    "descricao",
                    "Editando uma Tarefa em Dusk de número " . rand(1, 99)
                )
                ->press("Salvar")
                ->assertSee("Tarefa atualizada com sucesso!")
                ->assertPathIs("/agenda");
        });
    }
}
