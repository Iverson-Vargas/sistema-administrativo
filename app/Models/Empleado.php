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
        $builder = $this->db->table('empleado e');
        $builder->select('e.id_empleado, pn.id_persona, pn.nombre, pn.apellido, pn.sexo, e.fecha_ingreso, e.estatus, p.tipo, p.direccion, p.telefono, p.correo , p.ci_rif');
        $builder->join('per_natural pn', 'e.id_persona = pn.id_persona');
        $builder->join('persona p', 'e.id_persona = p.id_persona');
        $builder->where('e.id_empleado', $id_empleado);
        $query = $builder->get();
        $empleado = $query->getRowArray();

        if (!$empleado) {
            log_message('error', 'Empleado no encontrado con ID: ' . $id_empleado);
            return false; // Empleado no encontrado
        }

        try {
            log_message('info', 'Datos recibidos para actualizar: ' . json_encode($data));

            // Actualizar tabla persona
            if (isset($data['direccion']) || isset($data['telefono']) || isset($data['correo']) || isset($data['ci_rif'])) {
                $personaData = array_filter([
                    'direccion' => $data['direccion'] ?? null,
                    'telefono' => $data['telefono'] ?? null,
                    'correo' => $data['correo'] ?? null,
                    'ci_rif' => $data['ci_rif'] ?? null,
                ]);
                $this->db->table('persona')->where('id_persona', $empleado['id_persona'])->update($personaData);
                log_message('info', 'Resultado de actualizar persona: ' . json_encode($personaData));
            }

            // Actualizar tabla per_natural
            if (isset($data['sexo'])) {
                $perNaturalData = array_filter([
                    'sexo' => $data['sexo'] ?? null,
                ]);
                $this->db->table('per_natural')->where('id_persona', $empleado['id_persona'])->update($perNaturalData);
                log_message('info', 'Resultado de actualizar per_natural: ' . json_encode($perNaturalData));
            }

            // Actualizar tabla empleado
            if (isset($data['puesto'])) {
                $empleadoData = array_filter([
                    'puesto' => $data['puesto'] ?? null,
                ]);
                $empleadoUpdate = $this->db->table('empleado')->where('id_empleado', $id_empleado)->update($empleadoData);
                log_message('info', 'Resultado de actualizar empleado: ' . json_encode($empleadoUpdate));
            }

            return true;
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
            $result = $builder->update(['estatus' => 'I']);

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
}