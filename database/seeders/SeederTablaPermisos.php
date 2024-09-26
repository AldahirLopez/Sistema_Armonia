<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    public function run()
    {
        // Gestión de Roles
        $permisosRoles = [
            'gestionar-roles-ver',
            'gestionar-roles-crear',
            'gestionar-roles-editar',
            'gestionar-roles-eliminar',
        ];

        // Gestión de Usuarios
        $permisosUsuarios = [
            'gestionar-usuarios-ver',
            'gestionar-usuarios-crear',
            'gestionar-usuarios-editar',
            'gestionar-usuarios-eliminar',
        ];

        // Gestión de Operación y Mantenimiento (OM)
        $permisosOM = [
            'gestionar-om-ver',
            'gestionar-om-crear',
            'gestionar-om-eliminar',
            'gestionar-om-expediente-generar',
            'gestionar-om-expediente-descargar',
            'gestionar-om-documentacion-generar',
            'gestionar-om-documentacion-descargar',
            'gestionar-om-cotizaciones-generar',
            'gestionar-om-cotizaciones-descargar',
            'gestionar-om-pagos-ver',
            'gestionar-om-pagos-subir',
            'gestionar-om-pagos-descargar',
            'gestionar-om-facturas-subir',
            'gestionar-om-facturas-descargar',
        ];

        // Gestión de Anexo 30
        $permisosAnexo30 = [
            'gestionar-anexo30-ver',
            'gestionar-anexo30-crear',
            'gestionar-anexo30-eliminar',
            'gestionar-anexo30-expediente-generar',
            'gestionar-anexo30-expediente-descargar',
            'gestionar-anexo30-documentacion-generar',
            'gestionar-anexo30-cotizaciones-generar',
            'gestionar-anexo30-cotizaciones-descargar',
            'gestionar-anexo30-pagos-ver',
            'gestionar-anexo30-pagos-subir',
            'gestionar-anexo30-pagos-descargar',
            'gestionar-anexo30-facturas-subir',
            'gestionar-anexo30-facturas-descargar',
            'gestionar-anexo30-dictamenes-generar',
        ];

        // Gestión de Estaciones
        $permisosEstaciones = [
            'gestionar-estaciones-ver',
            'gestionar-estaciones-crear',
            'gestionar-estaciones-editar',
            'gestionar-estaciones-eliminar',
            'gestionar-estaciones-expediente-generar',
            'gestionar-estaciones-expediente-descargar',
        ];

        // Gestión de Formatos Vigentes
        $permisosFormatosVigentes = [
            'gestionar-formatos-vigentes-ver',
            'gestionar-formatos-vigentes-crear',
            'gestionar-formatos-vigentes-editar',
            'gestionar-formatos-vigentes-eliminar',
        ];

        // Gestión de Formatos Historial
        $permisosFormatosHistorial = [
            'gestionar-formatos-historial-ver',
            'gestionar-formatos-historial-crear',
            'gestionar-formatos-historial-editar',
            'gestionar-formatos-historial-eliminar',
        ];

        // Crear permisos en la base de datos
        $categoriasPermisos = [
            $permisosRoles,
            $permisosUsuarios,
            $permisosOM,
            $permisosAnexo30,
            $permisosEstaciones,
            $permisosFormatosVigentes,
            $permisosFormatosHistorial,
        ];

        foreach ($categoriasPermisos as $permisos) {
            foreach ($permisos as $permiso) {
                Permission::create(['name' => $permiso, 'guard_name' => 'web']);
            }
        }
    }
}
