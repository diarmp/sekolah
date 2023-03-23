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
        $data = ConfigSchool::with('master_config')->where('school_id','2')->get();
        if($data->count()>0){
            $init = 1;
            $listconfig = false;
        }else{
            $init = 0;
            $listconfig = Config::all();
        }
        return view('pages.config-school.list', compact('title','data','init','listconfig'));
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
            dd($th);
            Alert::toast('Ops Error Save Config', 'error');
        }

        return redirect()->route('config.index');
    }
}
