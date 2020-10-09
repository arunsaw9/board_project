<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnotationController extends Controller
{
    public function get($portal, $agenda, $doc) {
        $file =  "public/annotations/$portal/". Auth::user()->username ."/$agenda/$doc.xfdf";
        $exists = Storage::exists($file);
        return $exists ? Storage::get($file) : '404';
    }

    public function post(Request $request,  $portal, $agenda, $doc ) {
        $xfdf_file = "public/annotations/$portal/". Auth::user()->username ."/$agenda/$doc.xfdf";
        $xfdf_string = $request->body;
        return Storage::put( $xfdf_file , $xfdf_string ) ? 'success' : 'failed' ;
    }
}
