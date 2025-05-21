<?php

require __DIR__ . '/../vendor/autoload.php';

// Inicializa Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Estudiante;

class EstudianteService
{
    public function obtenerEstudiante($id)
    {
        $estudiante = Estudiante::find($id);
        if (!$estudiante) {
            return null;
        }
        return [
            'id' => $estudiante->id,
            'nombre' => $estudiante->nombre,
            'cedula' => $estudiante->cedula,
            'correo' => $estudiante->correo,
            'paralelo_id' => $estudiante->paralelo_id
        ];
    }
}

$options = ['uri' => 'http://localhost/soap-server.php'];
$server = new SoapServer(null, $options);
$server->setClass('EstudianteService');
$server->handle();