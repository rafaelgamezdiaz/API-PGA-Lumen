<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12/10/18
 * Time: 02:16 PM
 */

namespace App\Traits;


trait DecodeResponse
{

    private function dictionaryVehicleId()
    {
        return[
            "Vehicle",
            "vehicle_id",
            "veh_id",
            "id_veh",
            "VehicleId",
            "idVehicle",
        ];
    }
    private function dictionaryVehiclePlate()
    {
        return[
            "Vehicle",
            "vehicleplate",
            "vehicleCode",
            "vehicle_plate",
            "plate",
            "veh_pla",
            "pla_veh",
            "plate_vehicle",
            "placa",
            "VehicleTitle"
        ];
    }
    private function dictionaryContainer()
    {
        return[
            "codeContainer",
            "containerCode",
            "containerTitle",
            "containerId",
            "container",
            "container_id",
            "cont_id",
            "id_cont",
            "idcontainer"

        ];
    }
    function is_json($string,$return_data = false) {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
    }

     public function decode($request, $dictionary,$json = true){

        foreach ($request as $key => $value) {
            for($i=0;$i<count($dictionary);$i++) {
                if (strtoupper($key) == strtoupper($dictionary[$i])) {
                    return $value;
                }elseif(is_array($value)){
                    if (strtoupper($key) == strtoupper($dictionary[$i])) {
                        return $value;
                    }
                    foreach ($value as $anotherKey => $val){
                        if (strtoupper($anotherKey) == strtoupper($dictionary[$i])) {
                            return $val;
                        }
                        if (is_array($val)) {
                            if (strtoupper($anotherKey) == strtoupper($dictionary[$i])) {
                                return $val;
                            }
                        }else{
                            foreach ($val as $index => $aja){
                                if (strtoupper($index) == strtoupper($dictionary[$i])) {
                                    return $aja;
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    public function decodeResponse($response,$type){
       $response = $this->is_json($response) ? json_decode( $response) :$response;
        switch ($type){
            case 3:
                return $this->decode($response,$this->dictionaryContainer());
                break;
            case 1:
                return $this->decode($response,$this->dictionaryVehiclePlate());
            case 2:
                return false;#return $this->decode($response,$this->dictionaryUser());
                break;
            default:
                return false;
        }
    }




}