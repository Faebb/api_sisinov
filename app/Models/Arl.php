<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Arl
 * 
 * @property int $ID_arl
 * @property string $N_arl
 * 
 * @property Collection|Empleado[] $empleados
 *
 * @package App\Models
 */
class Arl extends Model
{
	protected $table = 'arl';
	protected $primaryKey = 'ID_arl';
	public $timestamps = false;

	protected $fillable = [
		'N_arl'
	];

	public function empleados()
	{
		return $this->hasMany(Empleado::class, 'id_arl');
	}
}
