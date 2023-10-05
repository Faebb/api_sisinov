<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoDoc
 * 
 * @property int $ID_Doc
 * @property string $N_TDoc
 * 
 * @property Collection|Empleado[] $empleados
 * @property Collection|Empresa[] $empresas
 *
 * @package App\Models
 */
class TipoDoc extends Model
{
	protected $table = 'tipo_doc';
	protected $primaryKey = 'ID_Doc';
	public $timestamps = false;

	protected $fillable = [
		'N_TDoc'
	];

	public function empleados()
	{
		return $this->hasMany(Empleado::class, 'id_doc');
	}

	public function empresas()
	{
		return $this->hasMany(Empresa::class, 'ID_Doc');
	}
}
