<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_returns_200(): void
    {
        $response = $this->get('/entrar');
        $response->assertStatus(200);
    }

    public function test_register_page_returns_200(): void
    {
        $response = $this->get('/cadastrar');
        $response->assertStatus(200);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::create([
            'name' => 'Maria Teste',
            'email' => 'maria@teste.com',
            'password' => Hash::make('senha123'),
        ]);

        $response = $this->post('/entrar', [
            'email' => 'maria@teste.com',
            'password' => 'senha123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/entrar', [
            'email' => 'naoexiste@teste.com',
            'password' => 'senhaerrada',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/cadastrar', [
            'name' => 'João Silva',
            'email' => 'joao@teste.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => 'joao@teste.com']);
    }

    public function test_authenticated_user_is_redirected_from_login(): void
    {
        $user = User::create([
            'name' => 'Teste',
            'email' => 'teste@email.com',
            'password' => Hash::make('senha123'),
        ]);

        $response = $this->actingAs($user)->get('/entrar');
        $response->assertRedirect('/');
    }

    public function test_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Teste',
            'email' => 'logout@teste.com',
            'password' => Hash::make('senha123'),
        ]);

        $this->actingAs($user)->post('/sair');
        $this->assertGuest();
    }

    public function test_orders_page_requires_auth(): void
    {
        $response = $this->get('/pedidos');
        $response->assertRedirect('/entrar');
    }

    public function test_profile_page_requires_auth(): void
    {
        $response = $this->get('/perfil');
        $response->assertRedirect('/entrar');
    }
}
