<?php

namespace App;

use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Digital extends Model
{
    protected $fillable = [
        'media_slug', 'company_id', 'link_src','text','nadnaslov','naslov','podnaslov','tizer','new_text'
    ];

    public function company(){
        return  $this->belongsTo(Company::class);
    }

    public function communicationsDigital(){
        return $this->hasMany(CommunicationsDigital::class,'media_id')->latest();
    }

    public function editorApprovedDigital(){
        return  $this->hasMany(EditorApprovedDigital::class);
    }

    public static function getDigitalByCompany($request)
    {
        return Digital::where([
            'id'=>$request->press_id,
            'company_id'=>$request->company_id
        ]);
    }

    public static function search($request)
    {
        $request->from = $request->from . ' 00:00:00';
        $request->to = $request->to . ' 23:59:59';

        $now = Carbon::now();

        if($request->publisher == 'svi'){
            $digitals = DB::table('digitals')
                ->join('companies', 'companies.id', '=', 'digitals.company_id')
                ->select(DB::raw(" media_slug, count(*) as objave, companies.name as company_name, DATE(digitals.created_at) as created_at, company_id, link_src"))
                ->where([
                    'digitals.stage' => 31,
                    'company_id' => auth()->user()->company_id,
                ])
                ->whereBetween('digitals.created_at',[$request->from, $request->to])
                ->where('digitals.created_at','<=', $now)
                ->groupBy('media_slug', 'created_at', 'digitals.stage', 'company_id', 'link_src', 'companies.name')
                ->havingRaw("count(*) > 0")
                ->take(10)
                ->get();


            $read = [];
            for ($i = 0; $i < count($digitals); $i++){
                $read[$i] = DB::select("SELECT COUNT(DISTINCT digital_id) as procitani FROM digitals_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$digitals[$i]->media_slug."' AND digitals_read.created_at BETWEEN '".$request->from."' AND '".$request->to."'");
                $digitals[$i]->procitani = $read[$i][0]->procitani;
            }
        }
        else{
            $digitals = DB::table('digitals')
                ->join('companies', 'companies.id', '=', 'digitals.company_id')
                ->select(DB::raw(" media_slug, count(*) as objave, companies.name as company_name, DATE(digitals.created_at) as created_at, company_id, link_src"))
                ->where([
                    'digitals.stage' => 31,
                    'company_id' => auth()->user()->company_id,
                    'digitals.media_slug' => $request->publisher
                ])
                ->whereBetween('digitals.created_at',[$request->from, $request->to])
                ->where('digitals.created_at','<=', $now)
                ->groupBy('media_slug', 'created_at', 'digitals.stage', 'company_id', 'link_src', 'companies.name')
                ->havingRaw("count(*) > 0")
                ->take(10)
                ->get();

            $read = [];
            for ($i = 0; $i < count($digitals); $i++){
                $read[$i] = DB::select("SELECT COUNT(DISTINCT digital_id) as procitani FROM digitals_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$digitals[$i]->media_slug."' AND digitals_read.created_at  BETWEEN '".$request->from."' AND '".$request->to."'");
                $digitals[$i]->procitani = $read[$i][0]->procitani;
            }
        }

        //dd($digitals);


        //dd($request->from, $request->to, $now, $digitals);
        //dd($digitals);
        return array($digitals);
    }
}

/*$printeds = DB::select("SELECT media_slug, count(*) as objave, companies.name as company_name, printeds.created_at as created_at, broj_izdanja, company_id, original_src
                                  (SELECT COUNT(*) FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$request->publisher."' AND printeds_read.created_at BETWEEN '".$request->from."' AND '".$request->to."' GROUP BY media_slug, broj_izdanja, company_id) as procitani
                                  FROM printeds
                                  INNER JOIN companies ON companies.id = printeds.company_id
                                  WHERE printeds.stage = 31
                                  AND company_id = '".auth()->user()->company_id."'
                                  AND printeds.media_slug = '".$request->publisher."'
                                  AND printeds.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY media_slug, printeds.created_at, printeds.stage, broj_izdanja, company_id, company_name, original_src HAVING count(*) > 0");*/

//->paginate(2);
//->paginate($request->perPage,['*'],'page',$request->page);
/*$printeds = DB::select("
                      SELECT media_slug, count(*) as objave, companies.name as company_name, printeds.created_at as created_at, broj_izdanja, company_id, original_src
                      FROM printeds
                      INNER JOIN companies ON companies.id = printeds.company_id
                      WHERE printeds.stage = 31
                      AND company_id = '".auth()->user()->company_id."'
                      AND printeds.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                      GROUP BY media_slug, printeds.created_at, printeds.stage, broj_izdanja, company_id, original_src, company_name HAVING count(*) > 0");

/*if($request->publisher == 'svi'){
            $digitals = DB::select("SELECT media_slug, count(*) as objave, companies.name as company_name, digitals.created_at as created_at, company_id
                                  FROM digitals
                                  INNER JOIN companies ON companies.id = digitals.company_id
                                  WHERE digitals.stage = 31
                                  AND company_id = '".auth()->user()->company_id."'
                                  AND digitals.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY media_slug, digitals.created_at, digitals.stage, company_id, company_name HAVING count(*) > 0");

            $read = [];
            //dd($digitals);
            for ($i = 0; $i < count($digitals); $i++){
                $read[$i] = DB::select("SELECT COUNT(DISTINCT digital_id) as procitani FROM digitals_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$digitals[$i]->media_slug."' AND digitals_read.created_at = '".$digitals[$i]->created_at."'");
                $digitals[$i]->procitani = $read[$i][0]->procitani;
            }
        }
        else{
            $digitals = DB::select("SELECT media_slug, count(*) as objave, companies.name as company_name, digitals.created_at as created_at, company_id

                                  FROM digitals
                                  INNER JOIN companies ON companies.id = digitals.company_id
                                  WHERE digitals.stage = 31
                                  AND company_id = '".auth()->user()->company_id."'
                                  AND digitals.media_slug = '".$request->publisher."'
                                  AND digitals.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY media_slug, digitals.created_at, digitals.stage, company_id, company_name HAVING count(*) > 0");

            $read = [];
            //dd($digitals);
            for ($i = 0; $i < count($digitals); $i++){
                //dd(DB::select("SELECT COUNT(DISTINCT digital_id) as procitani FROM digitals_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$digitals[$i]->media_slug."' "));
                $read[$i] = DB::select("SELECT COUNT(DISTINCT digital_id) as procitani FROM digitals_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$digitals[$i]->media_slug."' AND digitals_read.created_at = '".$digitals[$i]->created_at."'");
                $digitals[$i]->procitani = $read[$i][0]->procitani;
            }
        }
return array($digitals);*/