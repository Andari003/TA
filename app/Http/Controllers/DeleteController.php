<?php

namespace App\Http\Controllers;

use App\Models\ImageFile;
use App\Models\VideoFile;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function /* destroy */ DeleteImage($id)
    {
        ImageFile::findOrFail($id)->delete();
        return $this->success(null,'delete data success');
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function /*destroy*/ Deletevideo($id)
    {
        VideoFile::findOrFail($id)->delete();
        return $this->success(null,'delete data success');
    }

}
