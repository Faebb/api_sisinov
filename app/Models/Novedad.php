<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Novedad
 * 
 * @property int $ID_Nov
 * @property Carbon $Fe_Nov
 * @property int $T_Nov
 * @property string|null $Dic_Nov
 * @property string $Des_Nov
 * @property int $id_em
 * @property int|null $ID_S
 * 
 * @property Empleado $empleado
 * @property Sede|null $sede
 * @property TpNovedad $tp_novedad
 * @property Collection|Evidencium[] $evidencia
 *
 * @package App\Models
 */
class Novedad extends Model
{
	protected $table = 'novedad';
	protected $primaryKey = 'ID_Nov';
	public $timestamps = false;

	protected $casts = [
		'Fe_Nov' => 'datetime',
		'T_Nov' => 'int',
		'id_em' => 'int',
		'ID_S' => 'int'
	];

	protected $fillable = [
		'Fe_Nov',
		'T_Nov',
		'Dic_Nov',
		'Des_Nov',
		'id_em',
		'ID_S'
	];

	public function empleado()
	{
		return $this->belongsTo(Empleado::class, 'id_em');
	}

	public function sede()
	{
		return $this->belongsTo(Sede::class, 'ID_S');
	}

	public function tp_novedad()
	{
		return $this->belongsTo(TpNovedad::class, 'T_Nov');
	}

	public function evidencia()
	{
		return $this->hasMany(Evidencium::class, 'ID_Nov');
	}
}
