<?php

namespace App\Models;

use CodeIgniter\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';

    protected $allowedFields = [
        'id_empleado',
        'id_persona',
        'fecha_ingreso',
        'estatus',
    ];

    public function insertarEmpleado($data)
    {
        $builder = $this->db->table('empleado');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function getEmpleado()
    {
        $builder = $this->db->table('empleado e');
        $builder->select('e.id_empleado, pn.nombre, pn.apellido, pn.sexo, e.fecha_ingreso, e.estatus, p.tipo, p.direccion, p.telefono, p.correo , p.ci_rif');
        $builder->join('per_natural pn', 'e.id_persona = pn.id_persona');
        $builder->join('persona p', 'e.id_persona = p.id_persona');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getOneEmpleado($id_empleado)
    {
        $builder = $this->db->table('empleado e');
        $builder->select('e.id_empleado, pn.nombre, pn.apellido, pn.sexo, e.fecha_ingreso, e.estatus, p.tipo, p.direccion, p.telefono, p.correo , p.ci_rif');
        $builder->join('per_natural pn', 'e.id_persona = pn.id_persona');
        $builder->join('persona p', 'e.id_persona = p.id_persona');
        $builder->where('e.id_empleado', $id_empleado);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function actualizarEmpleado($id_empleado, $data)
    {
        // Primero, obtenemos solo el id_persona del empleado, que es lo que necesitamos.
        $empleado = $this->select('id_persona')->find($id_empleado);

        if (!$empleado) {
            log_message('error', 'Empleado no encontrado con ID: ' . $id_empleado);
            return false; // Empleado no encontrado
        }

        $id_persona = $empleado['id_persona'];

        // Usar transacciones para asegurar la integridad de los datos.
        $this->db->transStart();

        try {
            log_message('info', 'Datos recibidos para actualizar: ' . json_encode($data));

            // Preparamos los datos para cada tabla
            $personaData = [];
            if (isset($data['direccion'])) $personaData['direccion'] = $data['direccion'];
            if (isset($data['telefono'])) $personaData['telefono'] = $data['telefono'];
            if (isset($data['correo'])) $personaData['correo'] = $data['correo'];
            if (isset($data['ci_rif'])) $personaData['ci_rif'] = $data['ci_rif'];

            $perNaturalData = [];
            if (isset($data['sexo'])) $perNaturalData['sexo'] = $data['sexo'];
            if (isset($data['nombre'])) $perNaturalData['nombre'] = $data['nombre'];
            if (isset($data['apellido'])) $perNaturalData['apellido'] = $data['apellido'];

            $empleadoData = [];
            if (isset($data['fecha_ingreso'])) $empleadoData['fecha_ingreso'] = $data['fecha_ingreso'];


            // Actualizar tabla persona
            if (!empty($personaData)) {
                $this->db->table('persona')->where('id_persona', $id_persona)->update($personaData);
            }

            // Actualizar tabla per_natural
            if (!empty($perNaturalData)) {
                $this->db->table('per_natural')->where('id_persona', $id_persona)->update($perNaturalData);
            }

            // Actualizar tabla empleado
            if (!empty($empleadoData)) {
                $this->db->table('empleado')->where('id_empleado', $id_empleado)->update($empleadoData);
            }

            // Completar la transacción
            $this->db->transComplete();

            // Verificar si la transacción fue exitosa
            return $this->db->transStatus();

        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar empleado: ' . $e->getMessage());
            return false;
        }
    }

    public function deshabilitarEmpleado($id_empleado)
    {
        try {
            // Verificar el estado actual del empleado
            $builder = $this->db->table('empleado');
            $builder->select('estatus');
            $builder->where('id_empleado', $id_empleado);
            $empleado = $builder->get()->getRow();

            if (!$empleado) {
                log_message('error', "Empleado con ID $id_empleado no encontrado.");
                return false; // Empleado no existe
            }

            if ($empleado->estatus === 'I') {
                log_message('info', "El empleado con ID $id_empleado ya está deshabilitado.");
                return false; // Empleado ya deshabilitado
            }

            // Actualizar el estado del empleado a 'I' (Inactivo)
            // Se debe volver a especificar el WHERE, ya que el builder se reinicia después de un get().
            $result = $builder->where('id_empleado', $id_empleado)->update(['estatus' => 'I']);

            if ($result) {
                log_message('info', "Empleado con ID $id_empleado deshabilitado correctamente.");
                return true;
            } else {
                log_message('error', "No se pudo deshabilitar el empleado con ID $id_empleado.");
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al deshabilitar empleado: ' . $e->getMessage());
            return false;
        }
    }

    public function retonarIdEmpleado($id_usuario)
    {
        $builder = $this->db->table('empleado');
        $builder->select('empleado.id_empleado');
        $builder->join('usuario', 'usuario.id_persona = empleado.id_persona');
        $builder->where('usuario.id_usuario', $id_usuario);
        $query = $builder->get();
        $resultado = $query->getRow();
        return $resultado ? $resultado->id_empleado : null;
    }
}