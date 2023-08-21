<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupEquipmentRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\GetOptionsResource;
use Illuminate\Http\Request;
use App\Models\GroupEquipment;

class GroupEquipmentController extends Controller
{
    public function getEquipment(Request $request)
    {
       $equipment = GroupEquipment::with(['equipment'])->get();
       $limit = $request->limit;
        $name = $request->name;
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';

        $groupequipment= GroupEquipment::where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })

        ->orderBy($orderCol,$orderType)->paginate($limit);

         $data['paging'] = new PaginationResource($groupequipment);
        $data['records'] = $equipment;

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
        $area_id = $request->area_id;

        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';


        $groupequipment= GroupEquipment::with('division','area')->where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })->where(function($f) use ($division_id,$area_id) {
            if ($division_id && $division_id!='' && $division_id!='null'){
                $f->where('division_id', '=', $division_id);
            }
            if ($area_id && $area_id!='' && $area_id!='null'){
                $f->where('area_id', '=', $area_id);
            }
        })

        ->orderBy($orderCol,$orderType)->paginate($limit);


        $data['paging'] = new PaginationResource($groupequipment);
        $data['records'] = $groupequipment->items();

        return $this->success($data,'get records data success');
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
    public function store(GroupEquipmentRequest $request)
    {

        $groupequipment = new GroupEquipment();
        $groupequipment->name = $request->name;
        $groupequipment->description = $request->description;
        $groupequipment->division_id = $request->division_id;
        $groupequipment->area_id = $request->area_id;
        $groupequipment->save();
        return $this->success($groupequipment,'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groupequipment = GroupEquipment::findOrFail($id);
        return $this->success($groupequipment,'get record success');
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
    public function update(GroupEquipmentRequest $request, $id)
    {

        $groupequipment = GroupEquipment::findOrFail($id);
        $groupequipment->name = $request->name;
        $groupequipment->description = $request->description;
        $groupequipment->division_id = $request->division_id;
        $groupequipment->area_id = $request->area_id;
        $groupequipment->save();
        return $this->success($groupequipment,'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GroupEquipment::findOrFail($id)->delete();
        return $this->success(null,'delete data success');
    }

    public function GetOptionsResource(Request $request)
    {
        $divisiId =  $request->division_id;
        $areaId =  $request->area_id;
        $name = $request->name;
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';

        $groupequipment= GroupEquipment::where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })->where(function($f) use ($divisiId,$areaId) {
            if ($divisiId && $divisiId!='' && $divisiId!='null'){
                $f->where('division_id', '=',$divisiId);
            }
            if ($areaId && $areaId!='' && $areaId!='null'){
                $f->where('area_id', '=',$areaId);
            }
        })
        ->orderBy($orderCol,$orderType)->get();


        $data['records'] = GetOptionsResource::collection($groupequipment);


        return $this->success($data,'get records data success');
    }
}
