<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\ConfigSchool;
use App\Http\Requests\SchoolConfigRequest;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class ConfigSchoolController extends Controller
{
    public function index(){
        //
        $title = "School Configuration";
        $data = Config::leftJoin("config_schools","configs.code","=","code_config")->get();
        return view('pages.config-school.list', compact('title','data'));
    }

    public function save(SchoolConfigRequest $request){

        DB::beginTransaction();
        try {
            foreach($request->config as $key=>$val){
                $save = ConfigSchool::firstOrNew(array('school_id'=>'2','code_config'=>$key));
                $save->value = $val;
                $save->code_config = $key;
                $save->save();
            }

            // $config            = new config();
            // $config->name      = $request->name;
            // $config->save();

            DB::commit();
            Alert::toast('Save Config Success ', 'success');
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Ops Error Save Config', 'error');
        }

        return redirect()->route('config.index');
    }
}
