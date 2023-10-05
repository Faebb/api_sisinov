<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TpNovedad
 * 
 * @property int $T_Nov
 * @property string $Nombre_Tn
 * @property string $descrip_Tn
 * 
 * @property Collection|Novedad[] $novedads
 *
 * @package App\Models
 */
class TpNovedad extends Model
{
	protected $table = 'tp_novedad';
	protected $primaryKey = 'T_Nov';
	public $timestamps = false;

	protected $fillable = [
		'Nombre_Tn',
		'descrip_Tn'
	];

	public function novedads()
	{
		return $this->hasMany(Novedad::class, 'T_Nov');
	}
}
