<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Login
 * 
 * @property int $ID_log
 * @property string $passw
 * @property int $id_em
 * 
 * @property Empleado $empleado
 * @property Collection|UserRol[] $user_rols
 *
 * @package App\Models
 */
class Login extends Model
{
	protected $table = 'login';
	protected $primaryKey = 'ID_log';
	public $timestamps = false;

	protected $casts = [
		'id_em' => 'int'
	];

	protected $fillable = [
		'passw',
		'id_em'
	];

	public function empleado()
	{
		return $this->belongsTo(Empleado::class, 'id_em');
	}

	public function user_rols()
	{
		return $this->hasMany(UserRol::class, 'ID_log');
	}
}
