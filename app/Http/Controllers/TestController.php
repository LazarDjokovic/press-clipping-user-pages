<?php

namespace App\Http\Controllers;

use App\Printed;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function two_latest_news_view()
    {
        return view('testing.two_latest_news');
    }

    public function two_latest_news()
    {
        $now = Carbon::now();

        $two_latest_news = DB::select('SELECT media.name as name, broj_izdanja, printeds.created_at as created_at FROM printeds INNER JOIN media ON printeds.media_slug = media.slug 
                                              WHERE printeds.created_at <= "'.$now.'" AND printeds.company_id = 341 ORDER BY printeds.created_at DESC LIMIT 2');

        /*$two_latest_news = Printed::with('media')->orderBy('printeds.created_at', 'DESC')
            ->where('created_at','<=',$now)
            ->where([
                'company_id' => 341
            ])
            ->take(2)->get();*/


        //return array($two_latest_news);

        return view('testing.ajax.two_latest_news',compact('two_latest_news'));
    }
}
