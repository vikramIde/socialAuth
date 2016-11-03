<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
use Config;
use DB;
use App\Testdb;
use App\Flag;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;


class ExcelhandellerController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
     public function uploadExcel(Request $request)
        {
            $rules = array(
            'fileExcel' => 'required|max:5000'
            );

            $validator = Validator::make(Input::all(), $rules);

            // process the form
            if ($validator->fails()) 
            {
                return redirect()->back()->withErrors($validator);
                
            }
            else 
            {
                try {
                        $excel_file = Input::file('fileExcel');

                        $fname = md5(rand()).'.csv';
                        $full_path = Config::get('filesystems.disks.local.root');
                        $excel_file->move( $full_path, $fname );
                        $flag_table = Flag::firstOrNew(['file_name'=>$fname]);
                        $flag_table->imported = 0; //file was not imported
                        $flag_table->save();

                        $process = new Process('php ../artisan import:excelfile');
                        $process->start();

                       
                        $request->session()->flash('alert-success', 'Hold on tight. Your file is being processed');
                       
                        return redirect('uploadExcel');
                    
                } catch (\Exception $e) {

                    return redirect()->back()->withErrors($e->getMessage());
                }
                
            } 

            
            
        }

    public function status(Request $request)
       {
           $flag_table = DB::table('flag_table')
                           ->orderBy('created_at', 'desc')
                           ->first();
           // if(empty($flag)) {
           //     return response()->json(['msg' => 'done']); //nothing to do
           // }
           if($flag_table->imported == '1') {
               return response()->json(['msg' => 'done']);
           } else {
               // $status = $flag_table->rows_imported . ' excel rows have been imported out of a total of ' . $flag_table->total_rows;

                $status = ($flag_table->rows_imported/$flag_table->total_rows)*100;
               return response()->json(['msg' => $status]);
           }
       }

       
}