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
    public function automatic(Request $request){

        $index= [$request->index];
        $info = [$request->data];

        $report = (new ReportService());
        $user = $request->get('user')->user;
        $name = $request->has('name') ? $request->input('name') : "Automatico";

        $report->indexPerSheet($index);
        $report->dataPerSheet($info);
        $report->index($request->index);
        $report->data($request->data);
        $report->username($user->username);
        $report->getAccountInfo($user->current_account);
        $report->transmissionRaw();
        return $report->report("automatic",$name,null,null,false,1);

    }
}