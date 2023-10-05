<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pensione
 * 
 * @property int $ID_pens
 * @property string $N_pens
 * 
 * @property Collection|Empleado[] $empleados
 *
 * @package App\Models
 */
class Pensione extends Model
{
	protected $table = 'pensiones';
	protected $primaryKey = 'ID_pens';
	public $timestamps = false;

	protected $fillable = [
		'N_pens'
	];

	public function empleados()
	{
		return $this->hasMany(Empleado::class, 'id_pens');
	}
}
