<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * 
 * @property int $id_token
 * @property int $id_em
 * @property string $nToken
 * @property Carbon $fechaVencimiento
 * 
 * @property Token $token
 *
 * @package App\Models
 */

class Token extends Model
{
    protected $table = 'token';
    protected $primaryKey = 'id_token';
    public $timestamps = false;

    protected $fillable = [
        'id_em',
        'nToken',
        'fechaVencimiento'
    ];
}
