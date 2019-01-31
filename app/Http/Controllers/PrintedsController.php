<?php

namespace App\Http\Controllers;

use App\Printed;
use Illuminate\Http\Request;
use App\Media;
use App\PrintedsRead;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class PrintedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::all();


        return view('printed.first',compact('media'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        if($request->session()->has('printeds'))
            $request->session()->forget('printeds');

        if($request->session()->has('printeds_view'))
            $request->session()->forget('printeds_view');

        if($request->session()->has('search_data'))
            $request->session()->forget('search_data');

        /*if(Session::has('printeds'))
            Session::forget('printeds');

        if(Session::has('search_data'))
            Session::forget('search_data');

        if(Session::has('printeds_view'))
            Session::forget('printeds_view');*/

        $printeds = Printed::search($request);



        /*$printeds = Paginator::make([$printeds, count($printeds), 10]);

        dd($printeds);*/

        Session::put('search_data',$request->all());
        Session::put('printeds',$printeds);

        /*$objave = 0;

        for($i=0;$i<count($printeds);$i++){
            $objave += $printeds[0][$i]->objave;
        }*/

        //dd(\Route::current()->getName());

        //if (\Route::current()->getName() == 'printeds_back'){
            $media = Media::all();
            return view('printed.first',compact('printeds','media'));
        //}
       // else
            //return back()->withInput();
    }

    public function view(Request $request)
    {
        if($request->session()->has('printeds'))
            $request->session()->forget('printeds');

        if($request->session()->has('printeds_view'))
            $request->session()->forget('printeds_view');

        /*if(Session::has('printeds'))
            Session::flash('printeds');

        if(Session::has('printeds_view'))
            Session::flash('printeds_view');*/

        $printeds_view = Printed::where([
            'media_slug' => $request->media_slug,
            'broj_izdanja' => $request->broj_izdanja,
            'company_id' => auth()->user()->company_id,
            'created_at' => $request->date
        ])->get()->toArray();


        if($request->neprocitani == 1){
            $printeds_array = [];

            for($i=0; $i<count($printeds_view); $i++){
                $printeds_array[$i] = [
                    'user_id' => auth()->user()->id,
                    'media_slug' => $printeds_view[$i]['media_slug'],
                    'broj_izdanja' => $printeds_view[$i]['broj_izdanja'],
                    'company_id' => $printeds_view[$i]['company_id'],
                    'printed_id' => $printeds_view[$i]['id'],
                    'created_at' => $printeds_view[$i]['created_at'],
                    'updated_at' => Carbon::now()
                ];
            }

            PrintedsRead::insert($printeds_array);
        }


        //dd(session('search_data'));
        $printeds = Printed::search((object)(session('search_data')));

        //dd($printeds);

        Session::put('printeds', $printeds);
        Session::put('printeds_view', $printeds_view);

        //dd(session('printeds'));



        return view('printed.view',compact('printeds_view'));
    }

    public function back(Request $request)
    {
        if($request->session()->has('printeds'))
            $request->session()->forget('printeds');

        if($request->session()->has('printeds_view'))
            $request->session()->forget('printeds_view');

        /*if(Session::has('printeds'))
            Session::forget('printeds');

        if(Session::has('search_data'))
            Session::forget('search_data');

        if(Session::has('printeds_view'))
            Session::forget('printeds_view');*/

        $printeds = Printed::search((object)(session('search_data')));

        Session::put('printeds',$printeds);

        //dd(session('search_data'));

        $media = Media::all();

        return view('printed.index',compact('printeds','media'));
        //return redirect()->route('printeds_search', compact('printeds','media'));
    }
}
