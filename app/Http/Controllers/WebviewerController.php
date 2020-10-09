<?php

namespace App\Http\Controllers;

use App\BoardAgenda;
use App\CommitteeAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebviewerController extends Controller
{
    public function board($id, $document) {
        $agenda = BoardAgenda::findOrFail($id);
        $document = $document . "_url";
        
        if( !$agenda->$document ) abort(404);

        $url = "/storage/" . $agenda->$document;
        return response()->download(public_path($url));
    }

    public function committee($id, $document) {
        $agenda = CommitteeAgenda::findOrFail($id);
        $document = $document . "_url";

        if( !$agenda->$document ) abort(404);

        $url = "/storage/" . $agenda->$document;
        return response()->download(public_path($url));
    }

    public function watermark($portal, $id, $document) {
        
        $pdfnet_path = "/var/www/html/production/Lib/PDFNetPHP.php";
        // $pdfnet_path = "/Users/sree/Desktop/Tools/wrappers_build/PDFNetWrappers/PDFNetC/Lib/PDFNetPHP.php";
        include($pdfnet_path);
        \PDFNet::Initialize();

        $doctype = $document . "_url";
        $d = $portal == 'board' ? BoardAgenda::findOrFail($id) : CommitteeAgenda::findOrFail($id);
        $url = getcwd() . "/storage/" . $d->$doctype;

        // $url = getcwd() . "/storage/uploads/davechild_mod-rewrite.pdf";

        $array = explode(".", $url);
        $extension = $array[ sizeof($array) - 1 ];

        if( $extension === "pdf" ) {
            $doc = new \PDFDoc( $url );
            $doc->InitSecurityHandler();
            $text = "Downloaded By " . Auth::user()->name;

            $stamp = new \Stamper(\Stamper::e_relative_scale, 0.5, 0.5);
            $stamp->SetAlignment(\Stamper::e_horizontal_center, \Stamper::e_vertical_center);
            $stamp->SetOpacity(0.175);
            // $stamp->setAsBackground(true);
            $stamp->setRotation(-45);
            $stamp->StampText( $doc, $text , new \PageSet(1, $doc->GetPageCount()));

            $output = getcwd() . "/storage/attachment.$extension";
            $doc->save( $output , \SDFDoc::e_linearized);

            return response()->download($output);

        } else {
            return response()->download($url);
            // return "Can't download non-pdf files now! Developer is working on it.";
        }
    }
}
