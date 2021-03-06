<?php


namespace App\Models;


use App\Core\DateRange;
use App\Core\ImageService;
use App\Query\QueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TatucoModel extends Model
{
    use DateRange;
    protected $images;
    protected $modelo;
    protected $fillable = ['*'];

    /**
     * @named Funcion para establecer el Atributo de imagen al llamado del Servicio Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $img = "";
        if (isset($value)){
            $imageService = new ImageService();
            $img = $imageService->image($value);
        }
        $this->attributes['image'] = $img;
    }

    /**
     * @named Funcion para ejecutar el doWhere en el Modelo para ello recibe dos parametros el query y Request
     * @param $query
     * @param $request
     * @return QueryBuilder
     */
    public function scopeDoWhere($query, $request) {


        $list = QueryBuilder::for(static::class)
            ->select($this->getColumns($request))
            ->doJoin($this->getJoins($request))
            ->doWhere($this->getWhere($request))
            ->sort($this->getSort($request));

        if(isset($_GET['limit']))
        {
            $list->limit($_GET['limit']);
        }

        if(isset($_GET['count']))
        {
            $list->selectRaw("count({$_GET['count']}) as total");
        }
        if(isset($_GET['group']))
        {
            $list->groupBy($this->getGroups($request));
        }
        return $list;
    }

    /**
     * @named Funcion para paginar los registros de la consulta
     * @param $request
     * @return mixed
     */
    public function limit($request)
    {
        if(isset($_GET['paginate']))
        {
            $paginate = $request->paginate;
        }
        return $paginate;
    }

    /**
     * @named Funcion para obtener el paginado de la consulta de 10 en 10
     * @param $request
     * @return int
     */
    public function getPag($request)
    {
        $paginate = 10;
        if(isset($_GET['paginate']))
        {
            $paginate = $request->paginate;
        }
        return $paginate;
    }

    /**
     * @named Funcion para obtener el Join
     * @param $request
     * @return |null
     */
    public function getJoins($request)
    {
        $joins = null;
        if(isset($_GET['join']))
        {
            $joins = $request->join;
        }
        return $joins;
    }

    /**
     * @named Funcion para Obtener el Order
     * @param $request
     * @return |null
     */
    public function getSort($request)
    {
        $sort = null;
        if(isset($_GET['sort']))
        {
            $sort = $request->sort;
        }
        return $sort;
    }

    /**
     * @named Funcion para obtener las columnas
     * @param $request
     * @return array|mixed
     */
    public function getColumns($request)
    {
        $columns = ['*'];
        if(isset($_GET['columns']))
        {
            $c = json_decode($request->columns);
            $columns = $c;
        }

        return $columns;
    }

    /**
     * @named Funcion para obtener el grupo o agrupado
     * @param $request
     * @return array|mixed
     */
    public function getGroups($request)
    {
        $groups = ['*'];
        if(isset($_GET['group']))
        {
            $c = json_decode($request->group);
            $groups = $c;
        }

        return $groups;
    }

    /**
     * @named Funcion para obtener el where
     * @param $request
     * @return |null
     */
    public function getWhere($request)
    {
        $where = null;
        if(isset($_GET['where']))
        {

            $where = $request->where;
        }

        return $where;
    }

    /**
     * @named Funcion para el el Modelo
     * @return string
     */
    public function getModel()
    {

        return get_class($this);

    }

    /**
     * @named Funcion para obtener el Nombre de la clase
     * @return string
     */
    public function getNameOfClass()
    {
        return static::class;
    }

    /**
     * @named Funcion para establecer el Atributo en el servicio Image Service
     * @param $value
     */
    public function setImagesAttribute($value)
    {
        $i=0;
        $img = "[";
        $cont = count($value);
        if (isset($value)) {
            foreach ($value as $v) {
                $i++;
                $img .= $this->imageService->image($v);
                if($cont != $i ){
                    $img .= ",";
                }
            }
            $img .= "]";
        }
        $this->attributes['image'] = $img;
    }

    /**
     * @named Funcion para crear un objeto de la Clase ImageService
     * @return \App\Core\ImageService
     */
    public function imageService()
    {
        return new ImageService();
    }

    /**
     * @named Funcion para Obtener formateado (Y-m-d h:ia) el Atributo de Createdat
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->subHours(5)->format('Y-m-d h:ia');
    }

    /**
     * @named Funcion para obtener formateado (Y-m-d h:ia) el Atributo de Updatedat
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->subHours(5)->format('Y-m-d h:ia');
    }
}