<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Productos';


    protected $hidden = [
        'Ingreso',
        'Margen',
        'ProveedorPreferido',
        'ProveedorUnico',
        'ImprimirListaPrecios',
        'MuestraEnMostrador',
        'GarantiaImprimir',
        'UltImportacionFecha',
        'UltImportacionFob',
        'UltImportacionCBodega',
        'UltImportacionProveedor',
        'CostoReposicion',
        'CostoReposicionFecha',
        'PrecioPublico',
        'PrecioEspecial',
        'PrecioMayoristaVariacion',
        'PromocionPrecio',
        'PromocionInicio',
        'PromocionFin',
        'UMinimo',
        'UPresupuesto',
        'UTransito',
        'UExistenciaMesAnterior',
        'UExistenciaMostrador',
        'VExistenciaMesAnterior',
        'VExistenciaActual',
        'CostoUnitarioMesAnterior',
        'IncluirEnFiscoAlAzar',
        'CodigoReferencia',
        'Rack',
        'Nivel',
        'Estante',
        'USaldoPedidos',
        'UExistenciaDisponible',
  
    ];

}
