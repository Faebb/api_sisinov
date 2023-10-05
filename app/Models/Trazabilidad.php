<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Trazabilidad
 * 
 * @property int $ID_Tra
 * @property Carbon $Fh_Tra
 * @property int $id_em
 * @property string|null $descripcion
 * 
 * @property Empleado $empleado
 *
 * @package App\Models
 */
class Trazabilidad extends Model
{
	protected $table = 'trazabilidad';
	protected $primaryKey = 'ID_Tra';
	public $timestamps = false;

	protected $casts = [
		'Fh_Tra' => 'datetime',
		'id_em' => 'int'
	];

	protected $fillable = [
		'Fh_Tra',
		'id_em',
		'descripcion'
	];

	public function empleado()
	{
		return $this->belongsTo(Empleado::class, 'id_em');
	}
}
