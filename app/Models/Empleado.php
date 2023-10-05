<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empleado
 * 
 * @property int $id_em
 * @property int $id_doc
 * @property string $documento
 * @property string $n_em
 * @property string $a_em
 * @property string|null $eml_em
 * @property string $f_em
 * @property string $barloc_em
 * @property string|null $dir_em
 * @property string $lic_emp
 * @property string $lib_em
 * @property string $tel_em
 * @property string $contrato
 * @property int $id_pens
 * @property int $id_eps
 * @property int $id_arl
 * @property int $id_ces
 * @property int $id_rh
 * @property string $estado
 * 
 * @property TipoDoc $tipo_doc
 * @property Rh $rh
 * @property Ep $ep
 * @property Arl $arl
 * @property Cesantia $cesantia
 * @property Pensione $pensione
 * @property Collection|AsignaVehiculo[] $asigna_vehiculos
 * @property Collection|ContactoEmergencium[] $contacto_emergencia
 * @property Collection|Login[] $logins
 * @property Collection|Novedad[] $novedads
 * @property Collection|Trazabilidad[] $trazabilidads
 *
 * @package App\Models
 */
class Empleado extends Model
{
	protected $table = 'empleado';
	protected $primaryKey = 'id_em';
	public $timestamps = false;

	protected $casts = [
		'id_doc' => 'int',
		'id_pens' => 'int',
		'id_eps' => 'int',
		'id_arl' => 'int',
		'id_ces' => 'int',
		'id_rh' => 'int'
	];

	protected $fillable = [
		'id_doc',
		'documento',
		'n_em',
		'a_em',
		'eml_em',
		'f_em',
		'barloc_em',
		'dir_em',
		'lic_emp',
		'lib_em',
		'tel_em',
		'contrato',
		'id_pens',
		'id_eps',
		'id_arl',
		'id_ces',
		'id_rh',
		'estado'
	];

	public function tipo_doc()
	{
		return $this->belongsTo(TipoDoc::class, 'id_doc');
	}

	public function rh()
	{
		return $this->belongsTo(Rh::class, 'id_rh');
	}

	public function ep()
	{
		return $this->belongsTo(Ep::class, 'id_eps');
	}

	public function arl()
	{
		return $this->belongsTo(Arl::class, 'id_arl');
	}

	public function cesantia()
	{
		return $this->belongsTo(Cesantia::class, 'id_ces');
	}

	public function pensione()
	{
		return $this->belongsTo(Pensione::class, 'id_pens');
	}

	public function asigna_vehiculos()
	{
		return $this->hasMany(AsignaVehiculo::class, 'id_em');
	}

	public function contacto_emergencia()
	{
		return $this->hasMany(ContactoEmergencium::class, 'id_em');
	}

	public function logins()
	{
		return $this->hasMany(Login::class, 'id_em');
	}

	public function novedads()
	{
		return $this->hasMany(Novedad::class, 'id_em');
	}

	public function trazabilidads()
	{
		return $this->hasMany(Trazabilidad::class, 'id_em');
	}
}
