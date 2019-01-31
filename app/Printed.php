<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Printed extends Model
{
    protected $fillable = [
        'media_slug', 'company_id', 'link_src','text','broj_izdanja','nadnaslov','naslov','podnaslov','tizer','new_text'
    ];

    public function company(){
        return  $this->belongsTo(Company::class);
    }

    public function communicationsPrinted(){
        return $this->hasMany(CommunicationsPrinted::class,'media_id')->latest();
    }

    public function editorApprovedPrinted(){
        return  $this->hasMany(EditorApprovedPrinted::class);
    }

    public static function getPrintedByCompany($request)
    {
        return Printed::where([
            'id'=>$request->press_id,
            'company_id'=>$request->company_id
        ]);
    }

    public static function search($request)
    {
        if($request->publisher == 'svi'){
            $printeds = DB::select("
                                  SELECT media_slug, count(*) as objave, companies.name as company_name, printeds.created_at as created_at, broj_izdanja, company_id, original_src
                                  FROM printeds
                                  INNER JOIN companies ON companies.id = printeds.company_id
                                  WHERE printeds.stage = 31
                                  AND company_id = '".auth()->user()->company_id."'
                                  AND printeds.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY media_slug, printeds.created_at, printeds.stage, broj_izdanja, company_id, original_src, company_name HAVING count(*) > 0");

            $read = [];
            for ($i = 0; $i < count($printeds); $i++){
                $read[$i] = DB::select("SELECT COUNT(DISTINCT printed_id) as procitani FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND broj_izdanja = '".$printeds[$i]->broj_izdanja."' AND media_slug = '".$printeds[$i]->media_slug."' AND printeds_read.created_at BETWEEN '".$request->from."' AND '".$request->to."'");
                $printeds[$i]->procitani = $read[$i][0]->procitani;
            }
        }
        else{
            $printeds = DB::select("SELECT media_slug, count(*) as objave, companies.name as company_name, printeds.created_at as created_at, broj_izdanja, company_id, original_src
                                  (SELECT COUNT(*) FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND media_slug = '".$request->publisher."' AND printeds_read.created_at BETWEEN '".$request->from."' AND '".$request->to."' GROUP BY media_slug, broj_izdanja, company_id) as procitani
                                  FROM printeds 
                                  INNER JOIN companies ON companies.id = printeds.company_id
                                  WHERE printeds.stage = 31
                                  AND company_id = '".auth()->user()->company_id."'
                                  AND printeds.media_slug = '".$request->publisher."'
                                  AND printeds.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY media_slug, printeds.created_at, printeds.stage, broj_izdanja, company_id, company_name, original_src HAVING count(*) > 0");
        }


        return array($printeds);
    }
}
/*
 *
 * (SELECT COUNT(*) FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND media_id = '".$request->media_id."'
                                    AND printed_id = '".$request->printed_id."' AND broj_izdanja = '".$request->broj_izdanja."') as procitani



DB::select("SELECT media_slug, count(*) as objave, companies.name as company_name, printeds.created_at as created_at, broj_izdanja, company_id, SUM(returned) as returned,
                                  (SELECT COUNT(*) FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND printeds_read.created_at BETWEEN '".$request->from."' AND '".$request->to."') as procitani
                                  FROM printeds
                                  INNER JOIN companies ON companies.id = printeds.company_id
                                  WHERE printeds.stage = 31
                                  AND company_id = '".auth()->user()->company_id."'
                                  AND printeds.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY media_slug, printeds.created_at, printeds.stage, broj_izdanja, company_id, company_name HAVING count(*) > 0");


DB::select("SELECT printeds.media_slug, count(*) as objave, companies.name as company_name, printeds.created_at as created_at, printeds.broj_izdanja, printeds.company_id, SUM(returned) as returned,
                                  (SELECT COUNT(*) FROM printeds_read WHERE user_id = '".auth()->user()->id."' AND company_id = '".auth()->user()->company_id."' AND printeds_read.created_at BETWEEN '".$request->from."' AND '".$request->to."') as procitani
                                  FROM printeds
                                  INNER JOIN companies ON companies.id = printeds.company_id
                                  INNER JOIN printeds_read ON printeds_read.printed_id = printeds.id
                                  WHERE printeds.stage = 31
                                  AND printeds.company_id = '".auth()->user()->company_id."'
                                  AND printeds.created_at BETWEEN '".$request->from."' AND '".$request->to."'
                                  GROUP BY printeds.media_slug, printeds.created_at, printeds.stage, printeds.broj_izdanja, printeds.company_id, company_name HAVING count(*) > 0");
 */