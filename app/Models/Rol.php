<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 * 
 * @property int $ID_rol
 * @property string $N_rol
 * 
 * @property Collection|UserRol[] $user_rols
 *
 * @package App\Models
 */
class Rol extends Model
{
	protected $table = 'rol';
	protected $primaryKey = 'ID_rol';
	public $timestamps = false;

	protected $fillable = [
		'N_rol'
	];

	public function user_rols()
	{
		return $this->hasMany(UserRol::class, 'ID_rol');
	}
}
