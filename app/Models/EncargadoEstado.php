<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EncargadoEstado
 * 
 * @property int $idEncargadoEstado
 * @property int $ID_En
 * @property int $ID_S
 * @property string $Est_en
 * 
 * @property Encargado $encargado
 * @property Sede $sede
 *
 * @package App\Models
 */
class EncargadoEstado extends Model
{
	protected $table = 'encargado_estado';
	protected $primaryKey = 'idEncargadoEstado';
	public $timestamps = false;

	protected $casts = [
		'ID_En' => 'int',
		'ID_S' => 'int'
	];

	protected $fillable = [
		'ID_En',
		'ID_S',
		'Est_en'
	];

	public function encargado()
	{
		return $this->belongsTo(Encargado::class, 'ID_En');
	}

	public function sede()
	{
		return $this->belongsTo(Sede::class, 'ID_S');
	}
}
