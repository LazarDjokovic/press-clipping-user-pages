<?php

namespace App\Http\Controllers;

use App\Digital;
use App\Printed;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //

    public function index(Request $request)
    {
        $request->media_id;
        $request->pressType;
        $media = null;
        if($request->pressType == 'elektronski')
        {
            $media = Digital::find($request->media_id);
        }
        else if($request->pressType == 'stampani')
        {
            $media = Printed::find($request->media_id);
        }
        if($media)
        {
            //dd($media->text);
            //$media = mb_convert_encoding($media->text, 'HTML-ENTITIES', 'UTF-8');
            $media->text = mb_convert_encoding($media->text, 'HTML-ENTITIES', 'UTF-8');
            //$pdf = mb_convert_encoding(\View::make('pdf.invoice', $media->text), 'HTML-ENTITIES', 'UTF-8');
            $pdf = PDF::loadView('pdf.index', $media);
            return $pdf->download('novinarnica.pdf');
        }
        else
        {
            return redirect()->back()->with('error', "Greška u izdvajanju PDF-a");
        }

    }
}
