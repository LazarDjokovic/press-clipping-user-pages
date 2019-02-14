<?php

namespace App\Http\Controllers;

use App\Printed;
use Illuminate\Http\Request;
use App\Media;
use App\PrintedsRead;
use Illuminate\Support\Facades\DB;
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

        $printeds = Printed::search($request);


        Session::put('search_data',$request->all());
        Session::put('printeds',$printeds);

        $media = Media::all();
       /* if (\Route::current()->getName() == 'printeds_back'){

            return view('printed.first',compact('printeds','media'));
        }
        else{

            return view('printed.first',compact('printeds','media'));
            //return back()->withInput();
        }*/

        return view('printed.first',compact('printeds','media'));
        //return array($printeds);
    }

    public function view($media_slug, $broj_izdanja, $created_at, $neprocitani)
    {
        $now = Carbon::now()->format('Y:m:d H:i:s');

        if(\request()->session()->has('printeds'))
            \request()->session()->forget('printeds');

        if(\request()->session()->has('printeds_view'))
            \request()->session()->forget('printeds_view');

        $created_at_from = $created_at . ' 00:00:00';
        $created_at_to = $created_at . ' 23:59:59';

        /*if(Session::has('printeds'))
            Session::flash('printeds');

        if(Session::has('printeds_view'))
            Session::flash('printeds_view');*/

        //dd($created_at);

        /*$printeds_view = Printed::where([
                'media_slug' => $media_slug,
                'broj_izdanja' => $broj_izdanja,
                'company_id' => auth()->user()->company_id
            ])
            ->whereBetween('created_at',[$created_at . ' 00:00:00', $created_at, ' 23:59:59'])
            ->get()->toArray();*/

        $printeds_view = DB::select('SELECT *, DATE(created_at) as created_at FROM printeds WHERE media_slug = "'.$media_slug.'" 
                                            AND broj_izdanja = "'.$broj_izdanja.'" 
                                            AND created_at <= "'.$now.'"
                                            AND company_id = "'.auth()->user()->company_id.'"
											AND stage = 31
                                            AND created_at BETWEEN "'.$created_at_from.'" AND "'.$created_at_to.'";');

        //dd($printeds_view);


        if($neprocitani == 1){
            $printeds_array = [];

            for($i=0; $i<count($printeds_view); $i++){
                $printeds_array[$i] = [
                    'user_id' => auth()->user()->id,
                    'media_slug' => $printeds_view[$i]->media_slug,
                    'broj_izdanja' => $printeds_view[$i]->broj_izdanja,
                    'company_id' => $printeds_view[$i]->company_id,
                    'printed_id' => $printeds_view[$i]->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            PrintedsRead::insert($printeds_array);
        }

        $printeds_view_session =  Printed::where([
                'media_slug' => $media_slug,
                'broj_izdanja' => $broj_izdanja,
                'company_id' => auth()->user()->company_id
            ])
            ->where('created_at','<=',$now)
            ->where('stage',31)
            ->whereBetween('created_at',[$created_at_from,$created_at_to])
            ->get();


        //dd($printeds_view_session);

        //dd($printeds_view->links());

        //dd(session('search_data'));
        $printeds = Printed::search((object)(session('search_data')));

        //dd($printeds_view);

        Session::put('printeds', $printeds);
        Session::put('printeds_view', $printeds_view_session);

        //dd(session('printeds'));



        return view('printed.printeds_view',compact('printeds_view'));
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

        return view('printed.first',compact('printeds','media'));
        //return redirect()->route('printeds_search', compact('printeds','media'));
    }

    public function search_ajax(Request $request)
    {
        //$printeds = Printed::take(4)->skip($request->numItems)->get();

        $request->from = $request->from . ' 00:00:00';
        $request->to = $request->to . ' 23:59:59';

        $now = Carbon::now();

        if($request->publisher == 'svi'){
            $printeds = DB::table('printeds')
                ->join('companies', 'companies.id', '=', 'printeds.company_id')
                ->select(DB::raw(" media_slug, count(*) as objave, companies.name as company_name, DATE(printeds.created_at) as created_at, broj_izdanja, company_id, original_src"))
                ->where([
                    'printeds.stage' => 31,
                    'company_id' => auth()->user()->company_id
                ])
                ->where('printeds.created_at','<=', $now)
                ->whereBetween('printeds.created_at',[$request->from, $request->to])
                ->groupBy('media_slug', 'created_at', 'printeds.stage', 'broj_izdanja', 'company_id', 'original_src', 'companies.name')
                ->havingRaw("count(*) > 0")
                ->take(10)
                ->skip($request->numItems)
                ->get();

            $read = [];
            for ($i = 0; $i < count($printeds); $i++){
                $read[$i] = DB::select("SELECT COUNT(DISTINCT printed_id) as procitani FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND broj_izdanja = '".$printeds[$i]->broj_izdanja."' AND media_slug = '".$printeds[$i]->media_slug."' AND printeds_read.created_at BETWEEN '".$request->from."' AND '".$request->to."'");
                $printeds[$i]->procitani = $read[$i][0]->procitani;
            }
        }
        else{
            $printeds = DB::table('printeds')
                ->join('companies', 'companies.id', '=', 'printeds.company_id')
                ->select(DB::raw(" media_slug, count(*) as objave, companies.name as company_name, DATE(printeds.created_at) as created_at, broj_izdanja, company_id, original_src"))
                ->where([
                    'printeds.stage' => 31,
                    'company_id' => auth()->user()->company_id,
                    'printeds.media_slug' => $request->publisher
                ])
                ->where('printeds.created_at','<=', $now)
                ->whereBetween('printeds.created_at',[$request->from, $request->to])
                ->groupBy('media_slug', 'created_at', 'printeds.stage', 'broj_izdanja', 'company_id', 'original_src', 'companies.name')
                ->havingRaw("count(*) > 0")
                ->take(10)
                ->skip($request->numItems)
                ->get();

            $read = [];
            for ($i = 0; $i < count($printeds); $i++){
                $read[$i] = DB::select("SELECT COUNT(DISTINCT printed_id) as procitani FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND broj_izdanja = '".$printeds[$i]->broj_izdanja."' AND media_slug = '".$printeds[$i]->media_slug."' AND printeds_read.created_at  BETWEEN '".$request->from."' AND '".$request->to."'");
                $printeds[$i]->procitani = $read[$i][0]->procitani;
            }
        }

        //$new_printeds = array_merge((array)session('printeds')[0],(array)$printeds);
        //$new_printeds = session('printeds')[0].toArray() + $printeds.toArray();
        //$new_printeds = session('printeds')[0]->merge($printeds);
        //Session::put('printeds',$new_printeds);

        //return session('printeds');
        return view('printed.ajax.first',compact('printeds'));
    }

    public function two_latest_news()
    {
        $now = Carbon::now();

        $two_latest_news = DB::select('SELECT media.name as name, broj_izdanja, printeds.created_at as created_at FROM printeds INNER JOIN media ON printeds.media_slug = media.slug 
                                              WHERE printeds.created_at <= "'.$now.'" AND printeds.company_id = "'.auth()->user()->company_id.'" ORDER BY printeds.created_at DESC LIMIT 2');

        /*$two_latest_news = Printed::with('media')->orderBy('printeds.created_at', 'DESC')
            ->where('created_at','<=',$now)
            ->where([
                'company_id' => 341
            ])
            ->take(2)->get();*/


        //return array($two_latest_news);

        return view('printed.ajax.two_latest_news',compact('two_latest_news'));
    }
}
