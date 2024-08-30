<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Employee;

class EmployeeControllerTest extends TestCase
{

    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario de prueba
        $user = User::factory()->create();

        // Generar un token JWT para el usuario
        $this->token = JWTAuth::fromUser($user);
    }

    /** @test */
    public function list_employees()
    {
        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/employee');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $employee->name,
                     'email' => $employee->email,
                 ]);
    }

    /** @test */
    public function store_an_employee()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'position' => 'Test',
            'salary' => 50000,
            'user_id' => $user->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/employee', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('employees', $data);
    }

    /** @test */
    public function show_an_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/employee/' . $employee->id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $employee->name,
                     'email' => $employee->email,
                 ]);
    }

    /** @test */
    public function update_an_employee()
    {
        $employee = Employee::factory()->create();

        $data = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'position' => 'Test',
            'salary' => 60000,

        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/employee/' . $employee->id, $data);

        $response->assertStatus(200)
                ->assertJsonFragment($data);

        $this->assertDatabaseHas('employees', $data);
    }

    /** @test */
    public function delete_an_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/employee/' . $employee->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

}
