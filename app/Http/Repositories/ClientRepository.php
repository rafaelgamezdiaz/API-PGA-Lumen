<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 05:02 PM
 */

namespace App\Http\Repositories;


use App\Core\ImageService;
use App\Core\TatucoRepository;
use App\Models\Client;
use App\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClientRepository extends TatucoRepository
{
    public function __construct()
    {
        $this->model = new Client();
        parent::__construct($this->model);
    }

    /**
     * @param $request
     * @param $user
     * @return array
     */
    public function index(Request $request, $user)
    {

        $query = QueryBuilder::for(Client::class)
            ->with('venues')
            ->select('clients.*','types.description as type','status.description as status')
            ->leftJoin('types','types.id','clients.type')
            ->leftJoin('status','status.id','clients.status')
            ->where('deleted',false);

        if ($request->has('where')) {
            $query = $query->doWhere($request->input('where'));

        }
        if ($request->has('account')){
            $query =  $query->where('clients.account',$user->account);
        }
        return $query->get()->toArray();
    }

    /**
     * @param $id
     * @return Client|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function show($id)
    {
        $item = $this->model::with('venues')->where('id',$id)->first();

        return $item;
    }

    /**
     * @param Request $data
     * @return mixed
     */
    public function store(Request $data)
    {
        if (isset($data->image) AND !empty($data->image)){
            $imageService = new ImageService();
            $img = $imageService->image($data->image);
            $data->merge(['image' => $img]);
        }

        if (empty($data->input('commerce_name'))){
            $data->merge(['commerce_name' => $data->input('name') . " " . $data->input('last_name')]);
        }

        $new = $this->model::create($data->all());

        return $new;
    }
    /**
     * @param $value
     * @param $account
     * @return array
     */
    public function getClient($value, $account){
        $query= $this->model::query()->where(function (Builder $query) use ($value,$account) {
            return $query->whereRaw("lower(name) like lower('%{$value}%')")
                ->orWhereRaw("lower(last_name) like lower('%{$value}%')")
                ->orWhereRaw("lower(commerce_name) like lower('%{$value}%')");
        })->where('deleted',false);
        if (!empty($account)){
            $query = $query->where('account',$account);
        }
        return $query->get()->toArray();
    }

    /**
     * @param $id
     * @param $data
     * @return null
     */
    public function update($id, $data)
    {
        if (isset($data['image']) AND !empty($data['image'])){
            $imageService = new ImageService();
            $img = $imageService->image($data['image']);
            $data['image'] =  $img;
        }

        return parent::_update($id, $data);

    }

}