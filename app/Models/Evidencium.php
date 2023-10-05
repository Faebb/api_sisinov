<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Evidencium
 * 
 * @property int $id_evi
 * @property string|null $adjunto
 * @property int $ID_Nov
 * 
 * @property Novedad $novedad
 *
 * @package App\Models
 */
class Evidencium extends Model
{
	protected $table = 'evidencia';
	protected $primaryKey = 'id_evi';
	public $timestamps = false;

	protected $casts = [
		'ID_Nov' => 'int'
	];

	protected $fillable = [
		'adjunto',
		'ID_Nov'
	];

	public function novedad()
	{
		return $this->belongsTo(Novedad::class, 'ID_Nov');
	}
}
