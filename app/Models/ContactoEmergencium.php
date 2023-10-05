<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactoEmergencium
 * 
 * @property int $ID_CEm
 * @property string $N_CoE
 * @property string|null $Csag
 * @property int $id_em
 * @property string|null $T_CEm
 * 
 * @property Empleado $empleado
 *
 * @package App\Models
 */
class ContactoEmergencium extends Model
{
	protected $table = 'contacto_emergencia';
	protected $primaryKey = 'ID_CEm';
	public $timestamps = false;

	protected $casts = [
		'id_em' => 'int'
	];

	protected $fillable = [
		'N_CoE',
		'Csag',
		'id_em',
		'T_CEm'
	];

	public function empleado()
	{
		return $this->belongsTo(Empleado::class, 'id_em');
	}
}
