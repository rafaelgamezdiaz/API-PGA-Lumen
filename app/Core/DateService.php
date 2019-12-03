<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 8/1/18
 * Time: 12:31 PM
 */

namespace App\Http\Services;

use Carbon\Carbon;

class DateService extends TatucoService
{
    protected $format_date ="";
    protected $format_datetime="";
    protected $formato_time="";

    public function __construct($Formato)
    {
        $this->formato = strtolower($Formato);
        switch ($this->formato){
            case $Formato='america':
                {
                    $this->formato_fecha('Y-m-d');
                    $this->formato_fechahora('Y-m-d HH:MM:SS');
                    //$this->formato_
                }
            default:
                {
                    $this->formato_fecha('Y-m-d');
                    $this->formato_fechahora('Y-m-d HH:MM:SS');
                }
        }
    }

    /*
     * Metodo para retornar la Fecha Actual
     */
    public function getDateNow(){
        return Carbon::now()->format($this->formato);
    }

    /*
     * Metodo para retornar la Fecha y Hora Actual
     */
    public function getDateTimeNow(){
        return Carbon::now()->format($this->format_datetime);
    }

    /*
     * Metodo para retorna la Hora Actual
     */
    public function getTimeNow(){
        return Carbon::now()->toTimeString();
    }
}