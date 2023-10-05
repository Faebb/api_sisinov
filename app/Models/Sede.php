<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sede
 * 
 * @property int $ID_S
 * @property string $Dic_S
 * @property int $Sec_V
 * @property string $est_sed
 * @property int $id_e
 * 
 * @property Empresa $empresa
 * @property Collection|EncargadoEstado[] $encargado_estados
 * @property Collection|Novedad[] $novedads
 *
 * @package App\Models
 */
class Sede extends Model
{
	protected $table = 'sede';
	protected $primaryKey = 'ID_S';
	public $timestamps = false;

	protected $casts = [
		'Sec_V' => 'int',
		'id_e' => 'int'
	];

	protected $fillable = [
		'Dic_S',
		'Sec_V',
		'est_sed',
		'id_e'
	];

	public function empresa()
	{
		return $this->belongsTo(Empresa::class, 'id_e');
	}

	public function encargado_estados()
	{
		return $this->hasMany(EncargadoEstado::class, 'ID_S');
	}

	public function novedads()
	{
		return $this->hasMany(Novedad::class, 'ID_S');
	}
}
