<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rh
 * 
 * @property int $ID_RH
 * @property string $T_RH
 * 
 * @property Collection|Empleado[] $empleados
 *
 * @package App\Models
 */
class Rh extends Model
{
	protected $table = 'rh';
	protected $primaryKey = 'ID_RH';
	public $timestamps = false;

	protected $fillable = [
		'T_RH'
	];

	public function empleados()
	{
		return $this->hasMany(Empleado::class, 'id_rh');
	}
}
