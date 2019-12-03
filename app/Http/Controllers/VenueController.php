<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22/01/19
 * Time: 01:54 PM
 */

namespace App\Http\Controllers;


use App\Core\TatucoController;
use App\Http\Services\VenueService;

class VenueController extends TatucoController
{
    public function __construct()
    {
        $this->service = (new VenueService());

        $this->validateStore = [
            'client' => 'required|max:15',
            'name' => 'required|max:255',
            'description' => 'required',
            'account' => 'required'
        ];

        $this->validateUpdate = [
            'client' => 'required|max:15',
            'name' => 'required|max:255',
            'description' => 'required',
            'account' => 'required'

        ];
    }
}