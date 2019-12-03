<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22/01/19
 * Time: 01:54 PM
 */

namespace App\Http\Repositories;


use App\Core\TatucoRepository;
use App\Models\Venue;
use App\Query\QueryBuilder;
use Illuminate\Http\Request;

class VenueRepository extends TatucoRepository
{
    public function __construct()
    {
        $this->model = new Venue();
        parent::__construct(new Venue());
    }


    /**
     * @param $request
     * @param $user
     * @return array
     */
    public function index($request, $user)
    {
        $query = QueryBuilder::for(Venue::class)
            ->where('deleted',false);
        if ($user){
            $query =  $query->where('venues.account',$user->account);
        }
        if ($request instanceof Request AND $request->has('where')){
            $query =  $query->doWhere($request->input('where'));

        }
        return $query->get()->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->model::query()->where('id',$id)->first();

        return $item;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        if ($data instanceof Request) {
            $this->data = $data->all();
        }elseif(is_array($data) AND count($data)>0){
            $this->data = $data;
        }
        $new = $this->model::query()->create($this->data);

        return $new;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {

        $object = $this->model::query()->findOrFail($id);

        $object->update($data);
        return ($object) ? $object : null;

    }

}