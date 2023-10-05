<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRol
 * 
 * @property int $ID_UR
 * @property int $ID_rol
 * @property int $ID_log
 * 
 * @property Login $login
 * @property Rol $rol
 *
 * @package App\Models
 */
class UserRol extends Model
{
	protected $table = 'user_rol';
	protected $primaryKey = 'ID_UR';
	public $timestamps = false;

	protected $casts = [
		'ID_rol' => 'int',
		'ID_log' => 'int'
	];

	protected $fillable = [
		'ID_rol',
		'ID_log'
	];

	public function login()
	{
		return $this->belongsTo(Login::class, 'ID_log');
	}

	public function rol()
	{
		return $this->belongsTo(Rol::class, 'ID_rol');
	}
}
