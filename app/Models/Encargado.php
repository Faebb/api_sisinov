<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Encargado
 * 
 * @property int $ID_En
 * @property string $N_En
 * @property string $tel1
 * @property string $tel2
 * @property string $tel3
 * 
 * @property Collection|EncargadoEstado[] $encargado_estados
 *
 * @package App\Models
 */
class Encargado extends Model
{
	protected $table = 'encargado';
	protected $primaryKey = 'ID_En';
	public $timestamps = false;

	protected $fillable = [
		'N_En',
		'tel1',
		'tel2',
		'tel3',
		
	];

	public function encargado_estados()
	{
		return $this->hasMany(EncargadoEstado::class, 'ID_En');
	}
}
