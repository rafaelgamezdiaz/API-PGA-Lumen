<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 8/1/18
 * Time: 11:24 AM
 */

namespace App\Core;


use App\Core\ImageService;
use App\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class TatucoModel extends Model
{
    protected $images;

    protected $fillable = ['*'];

    public function scopeDoWhere($query, $request) {


        $list = QueryBuilder::for(static::class)
            ->select($this->getColumns($request))
            ->doJoin($this->getJoins($request))
            ->doWhere($this->getWhere($request))
            ->sort($this->getSort($request));
            //->paginate($this->getPag($request));

        return $list;
    }

    public function getPag($request)
    {
        $paginate = 10;
        if(isset($_GET['paginate']))
        {
            $paginate = $request->paginate;
        }
        return $paginate;
    }

    public function getJoins($request)
    {
        $joins = null;
        if(isset($_GET['join']))
        {
            $joins = $request->join;
        }
        return $joins;
    }

    public function getSort($request)
    {
        $sort = null;
        if(isset($_GET['sort']))
        {
            $sort = $request->sort;
        }
        return $sort;
    }

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

    public function getWhere($request)
    {
        $where = null;
        if(isset($_GET['where']))
        {

            $where = $request->where;
        }

        return $where;
    }

    public function setImageAttribute($value)
    {
        $img = "";
        if (isset($value)){
            $imageService = new ImageService();
            $img = $imageService->image($value);
        }
        $this->attributes['image'] = $img;
    }

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

    public function imageService()
    {
        return new ImageService();
    }
}