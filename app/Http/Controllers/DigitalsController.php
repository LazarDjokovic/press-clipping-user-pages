<?php

namespace App\Http\Controllers;

use App\Digital;
use App\DigitalsRead;
use Illuminate\Http\Request;
use App\Media;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DigitalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::all();


        return view('digital.index',compact('media'));
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

        if($request->session()->has('digitals'))
            $request->session()->forget('digitals');

        if($request->session()->has('digitals_view'))
            $request->session()->forget('$digitals_view');

        if($request->session()->has('search_data_digital'))
            $request->session()->forget('search_data_digital');

        /*if(Session::has('printeds'))
            Session::forget('printeds');

        if(Session::has('search_data'))
            Session::forget('search_data');

        if(Session::has('printeds_view'))
            Session::forget('printeds_view');*/

        $digitals = Digital::search($request);

        Session::put('search_data_digital',$request->all());
        Session::put('digitals',$digitals);

        //dd(session('search_data'));

        //if (\Route::current()->getName() == 'digitals_back'){
            $media = Media::all();
            return view('digital.index',compact('digitals','media'));
        //}
        //else
            //return back()->withInput();
    }

    public function view(Request $request)
    {
        if($request->session()->has('digitals'))
            $request->session()->forget('digitals');

        if($request->session()->has('digitals_view'))
            $request->session()->forget('digitals_view');

        /*if(Session::has('printeds'))
            Session::flash('printeds');

        if(Session::has('printeds_view'))
            Session::flash('printeds_view');*/

        $digitals_view = Digital::where([
            'media_slug' => $request->media_slug,
            'company_id' => auth()->user()->company_id,
            'created_at' => $request->date,
            'stage' => 31
        ])->get()->toArray();

        //dd($digitals_view);

        if($request->neprocitani == 1){
            $digitals_array = [];

            for($i=0; $i<count($digitals_view); $i++){
                $digitals_array[$i] = [
                    'user_id' => auth()->user()->id,
                    'media_slug' => $digitals_view[$i]['media_slug'],
                    'company_id' => $digitals_view[$i]['company_id'],
                    'digital_id' => $digitals_view[$i]['id'],
                    'created_at' => $digitals_view[$i]['created_at'],
                    'updated_at' => Carbon::now()
                ];
            }

            DigitalsRead::insert($digitals_array);
        }


        //dd(session('search_data'));
        $digitals = Digital::search((object)(session('search_data_digital')));

        //dd($printeds);

        Session::put('digitals', $digitals);
        Session::put('digitals_view', $digitals_view);

        //dd(session('printeds'));



        return view('digital.view',compact('digitals_view'));
    }

    public function back(Request $request)
    {
        if($request->session()->has('digitals'))
            $request->session()->forget('digitals');

        if($request->session()->has('digitals_view'))
            $request->session()->forget('digitals_view');

        /*if(Session::has('printeds'))
            Session::forget('printeds');

        if(Session::has('search_data'))
            Session::forget('search_data');

        if(Session::has('printeds_view'))
            Session::forget('printeds_view');*/

        $digitals = Digital::search((object)(session('search_data_digital')));

        Session::put('digitals',$digitals);

        //dd(session('search_data'));

        $media = Media::all();

        return view('digital.index',compact('digitals','media'));
        //return redirect()->route('digitals_search', compact('printeds','media'));
    }

}
