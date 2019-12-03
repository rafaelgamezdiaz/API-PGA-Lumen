<?php

namespace App\Providers;

use App\Http\Services\DoWhereService;
use App\Traits\doWhereTrait;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class DoWhereServiceProvider extends ServiceProvider
{
    use doWhereTrait;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('doWhere', function ($where) {

            if (isset($where)) {
                $where = json_decode($where);
                if(is_array($where)){
                    for ($i=0; $i < count($where); $i++) {
                        $array = (new DoWhereService())->evalWhere($where[$i]);
                        $field =  $array[0];
                        $operator = $array[1];
                        $value = $array[2];
                        $filter = $array[3];
                        switch ($where[$i]->op) {
                            case 'bt':
                                $this->whereBetween($field,$value);
                                break;
                            case 'in':
                                $this->whereIn($field,$value,$filter);
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
                                $this->where($field,$operator,$value,$filter);
                                break;
                        }
                        if (isset($where[$i]->type) && $where[$i]->type == "date") {
                            $this->whereDate($field,$operator,$value,$filter);
                        }
                    }
                }
            }

            return $this;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
