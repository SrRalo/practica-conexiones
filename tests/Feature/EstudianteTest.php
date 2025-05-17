<?php

namespace Tests\Feature;

use App\Models\Paralelo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use APP\Models\Paralelo;
Use APP\Models\Estudiante;
use function PHPUnit\Framework\assertJson;

class EstudianteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $paralelo = Paralelo::factory()->create();
        $response = $this->postJson('/api/estudiantes',[ 
            'nombre'=>'Carlos Perez',
            'cedula'=>'1102567890',
            'correo'=>'Carlos@example.com',
            'paralelo_id'=>$paralelo->id,
        ])

      //  $response->assertStatus(200);
      $response->assertStatus(201);
      ->assertJsonFragment([ 'mensaje'=>'Estudiante creado exitoso'] )
    }
}
