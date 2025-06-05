<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Paralelo;
use SoapServer;
use SoapFault;

class SoapController extends Controller
{
    private function initSoapServer()
    {
        $server = new SoapServer(null, [
            'uri' => 'http://localhost:8000/soap'
        ]);
        $server->setObject($this);
        return $server;
    }

    public function handle()
    {
        $server = $this->initSoapServer();
        $server->handle();
    }

    // Métodos para Estudiantes
    public function createEstudiante($nombre, $cedula, $correo, $paralelo_id)
    {
        try {
            $estudiante = Estudiante::create([
                'nombre' => $nombre,
                'cedula' => $cedula,
                'correo' => $correo,
                'paralelo_id' => $paralelo_id
            ]);
            return json_encode(['success' => true, 'data' => $estudiante]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function getEstudiante($id)
    {
        try {
            $estudiante = Estudiante::with('paralelo')->find($id);
            if (!$estudiante) {
                throw new SoapFault('Client', 'Estudiante no encontrado');
            }
            return json_encode(['success' => true, 'data' => $estudiante]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function updateEstudiante($id, $nombre, $cedula, $correo, $paralelo_id)
    {
        try {
            $estudiante = Estudiante::find($id);
            if (!$estudiante) {
                throw new SoapFault('Client', 'Estudiante no encontrado');
            }
            $estudiante->update([
                'nombre' => $nombre,
                'cedula' => $cedula,
                'correo' => $correo,
                'paralelo_id' => $paralelo_id
            ]);
            return json_encode(['success' => true, 'data' => $estudiante]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function deleteEstudiante($id)
    {
        try {
            $estudiante = Estudiante::find($id);
            if (!$estudiante) {
                throw new SoapFault('Client', 'Estudiante no encontrado');
            }
            $estudiante->delete();
            return json_encode(['success' => true, 'message' => 'Estudiante eliminado']);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function getAllEstudiantes()
    {
        try {
            $estudiantes = Estudiante::with('paralelo')->get();
            return json_encode(['success' => true, 'data' => $estudiantes]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    // Métodos para Paralelos
    public function createParalelo($nombre)
    {
        try {
            $paralelo = Paralelo::create(['nombre' => $nombre]);
            return json_encode(['success' => true, 'data' => $paralelo]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function getParalelo($id)
    {
        try {
            $paralelo = Paralelo::with('estudiantes')->find($id);
            if (!$paralelo) {
                throw new SoapFault('Client', 'Paralelo no encontrado');
            }
            return json_encode(['success' => true, 'data' => $paralelo]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function updateParalelo($id, $nombre)
    {
        try {
            $paralelo = Paralelo::find($id);
            if (!$paralelo) {
                throw new SoapFault('Client', 'Paralelo no encontrado');
            }
            $paralelo->update(['nombre' => $nombre]);
            return json_encode(['success' => true, 'data' => $paralelo]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function deleteParalelo($id)
    {
        try {
            $paralelo = Paralelo::find($id);
            if (!$paralelo) {
                throw new SoapFault('Client', 'Paralelo no encontrado');
            }
            $paralelo->delete();
            return json_encode(['success' => true, 'message' => 'Paralelo eliminado']);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }

    public function getAllParalelos()
    {
        try {
            $paralelos = Paralelo::with('estudiantes')->get();
            return json_encode(['success' => true, 'data' => $paralelos]);
        } catch (\Exception $e) {
            throw new SoapFault('Server', $e->getMessage());
        }
    }
}
