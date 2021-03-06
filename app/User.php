<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'Users';

    /**
     * El nombre de la llave primaria de la tabla.
     * Se modifica debido a que no es el nombre por defecto: id.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'rol',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function calificaciones()
    {
        //inverso de hasMany tecnicamente no es necesasario pero siempre usar la relación y la inversa. el inverso belongsTo trae un dato y el hasmany trae una coleccion.
        return $this->hasMany('App\Calificacion','usua_id');
    }

    public function respuestas()
    {
        //inverso de hasMany tecnicamente no es necesasario pero siempre usar la relación y la inversa. el inverso belongsTo trae un dato y el hasmany trae una coleccion.
        return $this->hasMany('App\Respuesta','usua_id');
    }

    public function respuestasTallerAsientoContable()
    {
        return $this->hasMany('App\RespuestaTallerAsientoContable', 'puc_id');
    }

    /**
     * método para consultar las respuestas que hizo el estudiante en un determinado taller
     *
     * Actualizaciòn:
     * select distinct `Pregunta`.`preg_id`, `preg_texto`, `preg_tipo`, `cali_calificacion`, `cali_ponderado`, `Respuesta`.`resp_id`
     * from `Respuesta`
     * inner join `Pregunta` on `Pregunta`.`preg_id` = `Respuesta`.`preg_id`
     * left join `Calificacion` on `Calificacion`.`preg_id` = `Pregunta`.`preg_id` and `Calificacion`.`usua_id` = `Respuesta`.`usua_id`
     * where `Pregunta`.`tall_id` = 1 and `Respuesta`.`usua_id` = 4
     */
    public function respuestasTallerPorEstudiante($tall_id)
    {
        return DB::table('Respuesta')
        ->select('Pregunta.preg_id','preg_texto','preg_tipo','cali_calificacion','preg_porcentaje','cali_ponderado')
        ->distinct()
        ->join('Pregunta','Pregunta.preg_id','=','Respuesta.preg_id')
        ->leftjoin('Calificacion', function ($join) {
            $join->on('Calificacion.preg_id', '=', 'Pregunta.preg_id')
                ->whereColumn('Calificacion.usua_id', '=', 'Respuesta.usua_id');
        })
        ->where('Pregunta.tall_id',$tall_id)
        ->where('Respuesta.usua_id',$this->id)
        ->get();
    }
    
}
