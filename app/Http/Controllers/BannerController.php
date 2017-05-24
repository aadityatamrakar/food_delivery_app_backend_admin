<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class BannerController extends Controller
{

    public function index()
    {
        return view('banner.index');
    }

    public function upload(Request $request)
    {
        if( $request->hasFile('image') ) {
            $file = $request->file('image');
            $dest = base_path().'/public/images/banner';
            $file_name = str_replace('.', '_', $_SERVER['REMOTE_ADDR']).'_'.date('U').'_'.Auth::user()->id.'.'.$file->extension();
            $file->move($dest, $file_name);
            $imagine = new Imagine();
            $imagine->open($dest.'/'.$file_name)
                ->resize(new Box(1200, 900))
                ->save($dest.'/mobile/'.$file_name, array('flatten' => false));

            Banner::create(['url'=>$file_name]);
        }

        return redirect()->route('banner.index')
            ->with(['info'=>"Banner uploaded successfully.", 'type'=>"success"]);
    }

    public function delete($id)
    {
        Banner::find($id)->delete();

        return redirect()->route('banner.index')
            ->with(['info'=>"Banner Deleted Successfully.", 'type'=>"success"]);
    }
}
