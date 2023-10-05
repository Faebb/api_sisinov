<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * 
 * @property int $id_e
 * @property string $Nit_E
 * @property string $Nom_E
 * @property string $Eml_E
 * @property string $Nom_Rl
 * @property int $ID_Doc
 * @property string $CC_Rl
 * @property string $telefonoGeneral
 * @property int $Val_E
 * @property string $Est_E
 * @property Carbon $Fh_Afi
 * @property Carbon $fechaFinalizacion
 * @property string $COD_SE
 * @property string $COD_AE
 * 
 * @property TipoDoc $tipo_doc
 * @property Collection|Sede[] $sedes
 *
 * @package App\Models
 */
class Empresa extends Model
{
	protected $table = 'empresa';
	protected $primaryKey = 'id_e';
	public $timestamps = false;

	protected $casts = [
		'ID_Doc' => 'int',
		'Val_E' => 'int',
		'Fh_Afi' => 'datetime',
		'fechaFinalizacion' => 'datetime'
	];

	protected $fillable = [
		'Nit_E',
		'Nom_E',
		'Eml_E',
		'Nom_Rl',
		'ID_Doc',
		'CC_Rl',
		'telefonoGeneral',
		'Val_E',
		'Est_E',
		'Fh_Afi',
		'fechaFinalizacion',
		'COD_SE',
		'COD_AE'
	];

	public function tipo_doc()
	{
		return $this->belongsTo(TipoDoc::class, 'ID_Doc');
	}

	public function sedes()
	{
		return $this->hasMany(Sede::class, 'id_e');
	}
}
