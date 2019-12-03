<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 24/07/18
 * Time: 10:41 AM
 */

namespace App\Http\Services;


class DoWhereService
{
    public function sort($sort)
    {
// example order=["id","desc"]
        if ($sort) {
            $sort = json_decode($sort);
            $this->orderBy($sort[0], $sort[1]);
        }
    }


    public function doWhere($where)
    {
        if (isset($where)) {
            $where = json_decode($where);
            if (is_array($where)) {
                for ($i = 0; $i < count($where); $i++) {
                    $array = $this->evalWhere($where[$i]);
                    $field = $array[0];
                    $operator = $array[1];
                    $value = $array[2];
                    $filter = $array[3];
                    switch ($where[$i]->op) {
                        case 'bt':
                            $this->whereBetween($field, $value);
                            break;
                        case 'in':
                            $this->whereIn($field, $value, $filter);
                            break;
                        case 'ct':
                            $this->whereRaw("lower({$field}) like lower('%{$value}%')");
                            // $this->where($field,$operator,'%'.$value.'%',$filter);
                            break;
                        case 'sw':
                            $this->whereRaw("lower({$field}) like lower('{$value}%')");
                            break;
                        case 'ew':
                            // $this->where($field,$operator,'%'.$value,$filter);
                            $this->whereRaw("lower({$field}) like lower('%{$value}')");
                            break;
                        default:
                            $this->where($field, $operator, $value, $filter);
                            break;
                    }
                    /*   if (isset($where[$i]->type) && $where[$i]->type == "date") {
                           $this->whereDate($field, $operator,$value, $filter);
                       }*/
                }
            }
        }

        return $this;
    }

    public function evalDay($where)
    {
        $type = "any";
        if (isset($where)) {
            $where = json_decode($where);
            if (is_array($where)) {
                for ($i = 0; $i < count($where); $i++) {
                    $array = $this->evalWhere($where[$i]);
                    $type = $array[4];
                }
            }
        }

        return $type;

    }

    public function forWhere($where)
    {
        $where = json_decode($where);
        if (is_array($where)) {
            for ($i = 0; $i < count($where); $i++) {
                print_r($where[$i]);
                return $where[$i];
            }
        }
    }

    public function evalWhere($where)
    {
        if (isset($where->op) && isset($where->field) && isset($where->value)) {
            $op = $this->getOp($where->op);
            if (!isset($where->filter)) {
                $where->filter = 'and';
            }
            if (!isset($where->type))
                $where->type = 'any';
        }
        $array = [$where->field, $op, $where->value, $where->filter, $where->type];
        //print_r($array);
        return $array;

    }



    public function evalMeWhere($string)
    {
        $array = [];
        $a = str_replace('"', "", $string);
        $b = str_replace('[', '', $a);
        $d = str_replace(']', '', $b);

        $val = [];
        $arrayWhere = explode(',', $d);

        for ($i=0; $i < count($arrayWhere) ; $i++) {
            array_push($val,(explode(':', $arrayWhere[$i])));
        }
        $posicion=[];
        for ($i=0; $i < 3; $i++) {
            $ope = $val[$i];
            for ($j=0; $j < 2; $j++) {
                array_push($posicion, $ope[$j]);

            }
        }


        return $arraglo = [
            $posicion[0] => $posicion[1],
            $posicion[2] => $posicion[3],
            $posicion[4] => $posicion[5]
        ];


    }

    public function getOp($op)
    {
        switch ($op) {
            case 'ct'://contiene algo en un string
                return 'like';
                break;
            case 'sw': //k% comienza con
                return 'like';
                break;
            case 'ew':   //%k temina con
                return 'like';
                break;
            case 'eq':  // = igual ah
                return '=';
                break;
            case 'gt':  //mayor que
                return '>';
                break;
            case 'gte':  //mayor o igual
                return '>=';
                break;
            case 'lte':  //menor o igual
                return '<=';
                break;
            case 'lt':   // menor que
                return '<';
                break;
            case 'in':  // en []
                return 'in';
                break;
            case 'bt': //entre
                return 'bt';
                break;
            default:
                return '=';
                break;
        }
    }
}