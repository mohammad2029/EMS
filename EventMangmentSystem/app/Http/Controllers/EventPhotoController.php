<?php

namespace App\Http\Controllers;

use App\Models\Event_photo;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;

class EventPhotoController extends Controller
{
use HttpResponsesTrait;
public function store_images(Request $request)
{
    try{
        $request->validate([
            'images'=>['required'],
            'images.*'=>['image'],
            'event_id'=>'required'
        ]);
        $images=$request->file('images');
        foreach($images as $image){
            $image_ext =  $image->getClientOriginalExtension();
        $image_name= time() . '.' .$image_ext ;
        $path='images/events';
        $image->move($path,$image_name);
        Event_photo::create([
            'photo_path'=>$path. '/'. $image_name,
            'event_id'=>$request->event_id
        ]);
        }
        return $this->ReturnSuccessMessage('images added succ');
        ;
}
catch(\Throwable $e)
{
    return response()->json([
        'code' => '500',
        'error'=>$e->getMessage(),
    ]);
}


}




    public function destroy(Request $request)
    {
        try{
            $event_photo=Event_photo::where('event_photo_id',$request->event_photo_id)->first();
            if( $event_photo)
            {
                $event_photo->delete('event_photo_id');
                unlink($event_photo->photo_path);
                return $this->ReturnSuccessMessage('deleted succ');
            }
            return $this->ReturnFailMessage('error not found');
        }
        catch(\Throwable $e)
        {
            return response()->json([
                'code' => '500',
                'error'=>$e->getMessage(),
            ]);
        }
    }


}
