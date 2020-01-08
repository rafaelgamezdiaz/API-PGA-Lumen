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
        $info = $this->sortByDate([$request->data]);
        $name_date = $this->dateToStr($info[0]);
        $report = (new ReportService());
        $name = $request->has('name') ? $request->input('name') : "Pagos".$name_date;
        $report->indexPerSheet($index);
        $report->dataPerSheet($info);
        $report->data($request->data);
        $report->index($request->index);
        $report->external();
        $report->transmissionRaw();
        return $report->report("automatic",$name,null,null,false,1);
    }

    private function dateToStr($info){
        if (count($info) > 0) {
            $dateIni = $info[0]['fecha_de_pago'];
            $dateEnd = $info[count($info[0])-1]['fecha_de_pago'];
        }
        return $this->formatDateToString($dateIni, $dateEnd);
    }

    private function formatDateToString($dateIni, $dateEnd){
        $date_ini = implode(explode('-',$dateIni));
        $date_end = implode(explode('-',$dateEnd));
        return $date_ini != $date_end ? '_'.$date_ini.'_'.$date_end : '_'.$date_ini;
    }


    private function sortByDate($info){
        $infoSorted = collect($info[0])->sortBy('fecha_de_pago')->values()->all();
        return [$infoSorted];
    }
}