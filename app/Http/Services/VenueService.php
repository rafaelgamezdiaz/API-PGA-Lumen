<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22/01/19
 * Time: 01:54 PM
 */

namespace App\Http\Services;


use App\Core\TatucoService;
use App\Http\Repositories\VenueRepository;

class VenueService extends TatucoService
{
    public function __construct()
    {
        $this->repository = new VenueRepository();
        $this->name = "Sede";
        $this->namePlural = "Sedes";
    }
}