<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 13/03/19
 * Time: 02:40 PM
 */

namespace App\Http\Controllers;


use App\Core\ReportService;
use App\Core\TatucoController;
use Illuminate\Http\Request;

class ReportController extends TatucoController
{

    public function __construct()
    {
        parent::__construct(new ReportService());
    }


    /**
     * @param Request $request
     * @return \Dompdf\Dompdf|\Illuminate\Http\JsonResponse|string|null
     */
    public function automatic(Request $request)
    {
        $index= [$request->index];
        $info = [$request->data];
        $report = (new ReportService());
        $nameEnd = $this->nameEnd($request);
        $name = $request->has('name') ? $request->input('name') : "Pagos_".$nameEnd;
        $report->indexPerSheet($index);
        $report->dataPerSheet($info);
        $report->index($request->index);
        $report->data($request->data);
        $report->external();
        $report->transmissionRaw();
        return $report->report("automatic",$name,null,null,false,1);
    }


    private function nameEnd($request){
        $date_ini = $this->dateToStr($request, 0, 'fechaInicio');
        $date_end = $this->dateToStr($request, 1, 'fechaFin');
        return ($date_ini == $date_end) ? "_".$date_ini : "_".$date_ini."_".$date_end;
    }

    private function dateToStr($request, $pos, $dateItem){
        return implode(explode('-',$request->range[$pos][$dateItem]));
    }
}