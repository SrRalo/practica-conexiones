<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Paralelo;
use App\Models\Estudiante;

class SoapTest extends TestCase
{
    public function test_soap_paralelo_crud()
    {
        $client = new \SoapClient(null, [
            'location' => 'http://localhost:8000/soap',
            'uri' => 'http://localhost:8000/soap',
            'trace' => true
        ]);

        // Crear un paralelo
        $response = json_decode($client->createParalelo('Paralelo A'));
        $this->assertTrue($response->success);
        $paralelo_id = $response->data->id;

        // Obtener el paralelo
        $response = json_decode($client->getParalelo($paralelo_id));
        $this->assertTrue($response->success);
        $this->assertEquals('Paralelo A', $response->data->nombre);

        // Actualizar el paralelo
        $response = json_decode($client->updateParalelo($paralelo_id, 'Paralelo B'));
        $this->assertTrue($response->success);
        $this->assertEquals('Paralelo B', $response->data->nombre);

        // Eliminar el paralelo
        $response = json_decode($client->deleteParalelo($paralelo_id));
        $this->assertTrue($response->success);
    }

    public function test_soap_estudiante_crud()
    {
        // Crear un paralelo primero
        $paralelo = Paralelo::create(['nombre' => 'Paralelo Test']);

        $client = new \SoapClient(null, [
            'location' => 'http://localhost:8000/soap',
            'uri' => 'http://localhost:8000/soap',
            'trace' => true
        ]);

        // Crear un estudiante
        $response = json_decode($client->createEstudiante(
            'Juan Pérez',
            '1234567890',
            'juan@example.com',
            $paralelo->id
        ));
        $this->assertTrue($response->success);
        $estudiante_id = $response->data->id;

        // Obtener el estudiante
        $response = json_decode($client->getEstudiante($estudiante_id));
        $this->assertTrue($response->success);
        $this->assertEquals('Juan Pérez', $response->data->nombre);

        // Actualizar el estudiante
        $response = json_decode($client->updateEstudiante(
            $estudiante_id,
            'Juan Pablo Pérez',
            '1234567890',
            'juan.pablo@example.com',
            $paralelo->id
        ));
        $this->assertTrue($response->success);
        $this->assertEquals('Juan Pablo Pérez', $response->data->nombre);

        // Eliminar el estudiante
        $response = json_decode($client->deleteEstudiante($estudiante_id));
        $this->assertTrue($response->success);
    }
}
