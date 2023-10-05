<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cesantia
 * 
 * @property int $ID_ces
 * @property string $N_ces
 * 
 * @property Collection|Empleado[] $empleados
 *
 * @package App\Models
 */
class Cesantia extends Model
{
	protected $table = 'cesantias';
	protected $primaryKey = 'ID_ces';
	public $timestamps = false;

	protected $fillable = [
		'N_ces'
	];

	public function empleados()
	{
		return $this->hasMany(Empleado::class, 'id_ces');
	}
}
