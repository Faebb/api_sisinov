<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AsignaVehiculo
 * 
 * @property int $ID_AV
 * @property Carbon $Fh_Asi
 * @property int $id_ve
 * @property int $id_em
 * 
 * @property Empleado $empleado
 * @property Vehiculo $vehiculo
 *
 * @package App\Models
 */
class AsignaVehiculo extends Model
{
	protected $table = 'asigna_vehiculo';
	protected $primaryKey = 'ID_AV';
	public $timestamps = false;

	protected $casts = [
		'Fh_Asi' => 'datetime',
		'id_ve' => 'int',
		'id_em' => 'int'
	];

	protected $fillable = [
		'Fh_Asi',
		'id_ve',
		'id_em'
	];

	public function empleado()
	{
		return $this->belongsTo(Empleado::class, 'id_em');
	}

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'id_ve');
	}
}
