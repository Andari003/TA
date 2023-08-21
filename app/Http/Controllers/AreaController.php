<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
 use App\Http\Resources\PaginationResource;
use App\Http\Resources\GetOptionsResource;
use App\Models\Area;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;


class AreaController extends Controller
{

    public function getGe(Request $request)
    {
       $groupEquipment = Area::with(['groupEquipment'])->get();
       $limit = $request->limit;
        $name = $request->name;
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';

        $area= Area::where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })

        ->orderBy($orderCol,$orderType)->paginate($limit);

         $data['paging'] = new PaginationResource($area);
        $data['records'] = $groupEquipment;

        return $this->success($data,'get records data success');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit;
        $name = $request->name;
        $description = $request->description;
        $division_id = $request->division_id;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';


        $area = Area::with('division')->where(function ($f) use ($name) {
            if ($name && $name != '' && $name != 'null') {
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })->where(function ($f) use ($division_id) {
            if ($division_id && $division_id != '' && $division_id != 'null') {
                $f->where('division_id', '=', $division_id);
            }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);


        $data['paging'] = new PaginationResource($area);
        $data['records'] = $area->items();
        //jika column di mapping pakai resource
        //$data['records'] = UserResource::collection($user);


        return $this->success($data, 'get records data success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {

        $area = new Area();
        $area->name = $request->name;
        $area->division_id = $request->division_id;
        $area->description = $request->description;
        $area->save();

        return $this->success($area,'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::with(['division'])->findOrFail($id);
        return $this->success($area,'get record success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {

        $area = Area::findOrFail($id);
        $area->name = $request->name;
        $area->description = $request->description;
        $area->division_id = $request->division_id;
        $area->save();
        return $this->success($area,'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Area::findOrFail($id)->delete();
        return $this->success(null,'delete data success');
    }

    public function GetOptionsResource(Request $request)
    {
        $name = $request->name;
        $divisiId =  $request->division_id;
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';


        $area= Area::where(function($f) use ($name,$divisiId) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
            if ($divisiId && $divisiId!='' && $divisiId!='null'){
                $f->where('division_id', '=',$divisiId);
            }
        })

        ->orderBy($orderCol,$orderType)->get();


        $data['records'] = GetOptionsResource::collection($area);


        return $this->success($data,'get records data success');
    }
}
