<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiculo
 * 
 * @property int $id_ve
 * @property string $Matricula
 * @property string $Cilindraje
 * @property Carbon|null $Modelo
 * @property Carbon|null $Fecha_Soat
 * @property Carbon|null $Fecha_tecnicomecanica
 * @property string $estado
 * 
 * @property Collection|AsignaVehiculo[] $asigna_vehiculos
 *
 * @package App\Models
 */
class Vehiculo extends Model
{
	protected $table = 'vehiculo';
	protected $primaryKey = 'id_ve';
	public $timestamps = false;

	protected $casts = [
		'Modelo' => 'datetime',
		'Fecha_Soat' => 'datetime',
		'Fecha_tecnicomecanica' => 'datetime'
	];

	protected $fillable = [
		'Matricula',
		'Cilindraje',
		'Modelo',
		'Fecha_Soat',
		'Fecha_tecnicomecanica',
		'estado'
	];

	public function asigna_vehiculos()
	{
		return $this->hasMany(AsignaVehiculo::class, 'id_ve');
	}
}
