<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Resources\PaginationResource;
use App\Models\ImageFile;
use App\Models\VideoFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TypeController extends Controller
{

    public function contentImageUpload(Request $request)
    {
        $request->validate(
            [
                'path' => 'required|string',
                'file' => 'required|mimes:jpg,jpeg,png,bmp |max:4048',
            ]
        );

        $path  = $request->get('path');
        $successStatus = false;
        $file_url = null;

        if( $request->file('file'))
        {
            $hash = Str::random(30);
            $extension = '.'.$request->file('file')->guessExtension();

            $filenameClient = $hash.$extension;
            $request->file('file')->storeAs($path, $filenameClient, $disk = 'images');

            $file_path = Storage::disk('images')->path($path, true). '/'.$filenameClient;
            if (file_exists($file_path)) {
                $file_url = url('images/'.$path.'/'.$filenameClient);
                $successStatus = true;
            }
        }

        if (!$successStatus){
            return $this->error('ERROR.FILE_NOT_FOUND', 'File Upload not found', 500);
        } else {
            $data['file_url'] = $file_url;
            return $this->success($data,"Retrieved data successfully");
        }

    }

    public function contentVideoUpload(Request $request)
    {
        $request->validate(
            [
                'path' => 'required|string',
                'file' => 'required|mimes:jpg,jpeg,png,bmp |max:4048',
            ]
        );

        $path  = $request->get('path');
        $successStatus = false;
        $file_url = null;

        if( $request->file('file'))
        {
            $hash = Str::random(30);
            $extension = '.'.$request->file('file')->guessExtension();

            $filenameClient = $hash.$extension;
            $request->file('file')->storeAs($path, $filenameClient, $disk = 'videos');

            $file_path = Storage::disk('videos')->path($path, true). '/'.$filenameClient;
            if (file_exists($file_path)) {
                $file_url = url('videos/'.$path.'/'.$filenameClient);
                $successStatus = true;
            }
        }

        if (!$successStatus){
            return $this->error('ERROR.FILE_NOT_FOUND', 'File Upload not found', 500);
        } else {
            $data['file_url'] = $file_url;
            return $this->success($data,"Retrieved data successfully");
        }

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
        $division_id = $request->division_id;
        $area_id = $request->area_id;
        $equipment_id = $request->equipment_id;


        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';


        $type = Type::with('division', 'area', 'equipment', 'images', 'videos')->where(function ($f) use ($name) {
            if ($name && $name != '' && $name != 'null') {
                $f->where('name', 'LIKE', '%' . $name . '%');
            }
        })->where(function ($f) use ($division_id, $area_id, $equipment_id) {
            if ($division_id && $division_id != '' && $division_id != 'null') {
                $f->where('division_id', '=', $division_id);
            }
            if ($area_id && $area_id != '' && $area_id != 'null') {
                $f->where('area_id', '=', $area_id);
            }
            if ($equipment_id && $equipment_id != '' && $equipment_id != 'null') {
                $f->where('equipment_id', '=', $equipment_id);
            }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);

        $data['paging'] = new PaginationResource($type);
        $data['records'] = $type->items();


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
    public function store(TypeRequest $request)
    {
        $fileImage  = null;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,bmp |max:4048',
            ]);
            //save upload file
            $hash = Str::random(30);
            $extension = '.' . $request->file('image')->guessExtension();
            $fileSize = $request->file('image')->getSize();
            $filenameClient = $hash . $extension;
            $request->file('image')->storeAs('type/', $filenameClient, $disk = 'images');
            $file_path = Storage::disk('images')->path('type/', true) . '/' . $filenameClient;
            if (file_exists($file_path)) {
                $fileImage = 'images/type/' . $filenameClient;
            }
        }

        $fileVideo  = null;
        if ($request->hasFile('video')) {
            $request->validate([
                'video' => 'required|mimes:mp4,mov,avi,mpg |max:100000',
            ]);
            //save upload file
            $hash = Str::random(30);
            $extension = '.' . $request->file('video')->guessExtension();
            $fileSize = $request->file('video')->getSize();
            $filenameClient = $hash . $extension;
            $request->file('video')->storeAs('type/', $filenameClient, $disk = 'videos');
            $file_path = Storage::disk('videos')->path('type/', true) . '/' . $filenameClient;
            if (file_exists($file_path)) {
                $fileVideo = 'videos/type/' . $filenameClient;
            }
        }



        $type = new Type();
        $type->name = $request->name;
        $type->description = $request->description;
        $type->content = $request->content;
        $type->division_id = $request->division_id;
        $type->area_id = $request->area_id;
        $type->equipment_id = $request->equipment_id;
        $type->save();
        if ($fileImage) {
            $image = new ImageFile();
            $image->name = $filenameClient;
            $image->path = $fileImage;
            $image->size = $fileSize;
            $type->images()->save($image);
        }
        if ($fileVideo) {
            $video = new VideoFile();
            $video->name = $filenameClient;
            $video->path = $fileVideo;
            $video->size = $fileSize;
            $type->videos()->save($video);
        }

        $dataType = Type::with(['images', 'videos'])->findOrFail($type->id);
        return $this->success($dataType, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = Type::with(['division', 'area', 'equipment', 'images', 'videos'])->findOrFail($id);

        return $this->success($type, 'get record success');
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
    public function update(TypeRequest $request, $id)
    {
        $type = Type::findOrFail($id);
        $type->name = $request->name;
        $type->description = $request->description;
        $type->content = $request->content;
        $type->division_id = $request->division_id;
        $type->area_id = $request->area_id;
        $type->equipment_id = $request->equipment_id;
        $type->save();
        return $this->success($type, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Type::findOrFail($id)->delete();

        return $this->success(null, 'delete data success');
    }
}
