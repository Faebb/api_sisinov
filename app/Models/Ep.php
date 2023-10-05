<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ep
 * 
 * @property int $ID_eps
 * @property string $N_eps
 * 
 * @property Collection|Empleado[] $empleados
 *
 * @package App\Models
 */
class Ep extends Model
{
	protected $table = 'eps';
	protected $primaryKey = 'ID_eps';
	public $timestamps = false;

	protected $fillable = [
		'N_eps'
	];

	public function empleados()
	{
		return $this->hasMany(Empleado::class, 'id_eps');
	}
}
