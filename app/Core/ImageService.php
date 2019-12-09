<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 8/1/18
 * Time: 10:01 AM
 */

namespace App\Core;


use App\Http\Services\ParamService;
use Carbon\Carbon;

class ImageService //extends TatucoService
{

    /**
     * @named Metodo de Guardado de una Sola Imagen
     * @param $images
     * @param string $id
     * @return string|null
     */
    public function image($images, $id = 'zippyttech')
    {
        $route = public_path().'/images/';//(new ParamService)->findValueForKey('UPLOAD_IMAGES')?:'/opt/tracking/images/';
        $route_web = (new ParamService)->findValueForKey('UPLOAD_IMAGES')?:'/opt/tracking/images/';
        $now = Carbon::now()->format('Y-m-d');
        define('UPLOAD_DIR', $route);
        $img = $images;
        $ext = $this->get_extension($img);
        $img = str_replace('data:image/'.$ext.';base64,', '', $img);
        $data = base64_decode($img);
        $var_for = uniqid().'-'.$id.'-'.$now. '.'.$ext;
        $file = UPLOAD_DIR . $var_for;
        $image = $route_web . $var_for;
        $success = file_put_contents($file, $data);
        if ($success) {
            return $image;
        }else {
            return null;
        }
    }

    /**
     * @named Funcion para verificar el tipo de extension
     * @param $string
     * @return array|int|string
     */
    public function get_extension($string)
    {
        $extension="";
        if(!empty($string)){
            $formats = ["jpg", "jpeg", "png", "gif"];
            if(substr($string,0,4)=='http')
            {
                return $extension=3;
            }else {
                $data = $string;
                $pos = strpos($data, ';');
                $type = explode(':', substr($data, 0, $pos))[1];
                $extension = preg_split("[/]", $type);
                return $extension[1];
            }
        }else{
            return "Extension de la Imagen Vacia o en Blanco, Verifique";
        }
    }
}