<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Clasificacion
 *
 * @property int $clasificacion_id
 * @property string $nombre
 * @property string $abreviatura
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion whereClasificacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clasificacion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Clasificacion extends Model
{
//    use HasFactory;

    protected $table = "clasificaciones";
    protected $primaryKey = "clasificacion_id";
}
