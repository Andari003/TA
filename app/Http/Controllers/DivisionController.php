<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Http\Resources\GetOptionsResource;
use App\Http\Resources\PaginationResource;
use App\Models\Division;
use Illuminate\Http\Request;


class DivisionController extends Controller
{
    public function getArea(Request $request)
    {
       $areas = Division::with(['areas'])->get();
       $limit = $request->limit;
        $name = $request->name;
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';

        $division= Division::where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })

        ->orderBy($orderCol,$orderType)->paginate($limit);

         $data['paging'] = new PaginationResource($division);
        $data['records'] = $areas;

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
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';

        $division= Division::where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })

        ->orderBy($orderCol,$orderType)->paginate($limit);

         $data['paging'] = new PaginationResource($division);
        $data['records'] = $division->items();

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
    public function store(DivisionRequest $request)
    {
        $division = new Division();
        $division->name = $request->name;
        $division->description = $request->description;
        $division->save();
        return $this->success($division,'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $division = Division::findOrFail($id);
        return $this->success($division,'get record success');
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
    public function update(DivisionRequest $request, $id)
    {

        $division = Division::findOrFail($id);
        $division->name = $request->name;
        $division->description = $request->description;
        $division->save();
        return $this->success($division,'update data success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Division::findOrFail($id)->delete();
        return $this->success(null,'delete data success');
    }

    public function GetOptionsResource(Request  $request)
    {
        $name = $request->name;
        $orderCol = $request->order_col ? $request->order_col :'id';
        $orderType= $request->order_type ? $request->order_type :'asc';

        $division= Division::where(function($f) use ($name) {
            if ($name && $name!='' && $name!='null'){
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })

        ->orderBy($orderCol,$orderType)->get();

        $data['records'] = GetOptionsResource::collection($division);


        return $this->success($data,'get records data success');
    }


}
