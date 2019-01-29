<?php

namespace App;

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

        if($request->publisher == 'svi'){
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


        return array($digitals);
    }
}

