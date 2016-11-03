<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Validator;
use Config;
use App\Flag;
use App\Testdb;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Output\ConsoleOutput;

class ImportManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excelfile';

    /**
     * The console command description.
     *
     * @var string
     */
   protected $description = 'This imports an excel file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
  
       
        
        protected $chunkSize = 500;

       public function handle()
       {

         set_time_limit ( 200 );
           $file = Flag::where('imported','=','0')
                       ->orderBy('created_at', 'DESC')
                       ->first();
            
          
           $file_path = Config::get('filesystems.disks.local.root') . '/' .$file->file_name;


          // let's first count the total number of rows
           Excel::load($file_path, function($reader) use($file) {
               $objWorksheet = $reader->getActiveSheet();
               $file->total_rows = $objWorksheet->getHighestRow() - 1; //exclude the heading
               $file->save();
           });


           $chunkid=0;
          //now let's import the rows, one by one while keeping track of the progress

           Excel::filter('chunk')
               ->selectSheetsByIndex(0)
               ->load($file_path)
               ->chunk($this->chunkSize, function($results) use ($file,$chunkid) {
                  //let's do more processing (change values in cells) here as needed
                   $counter = 0;
                   $chunkid++;
                   $output = new ConsoleOutput();
                   $data =array();
                    foreach ($results->toArray() as $row) {
                                     $data[] =    array(  
                                                'name'=>$row['name'],
                                                'dob'=> date('Y-m-d', strtotime($row['dob'])),
                                                'phone'=>$row['phone'],
                                                'addresse'=>$row['addresse'],
                                                'created_at'=>date('Y-m-d H:i:s'),
                                                'updated_at'=> date('Y-m-d H:i:s')
                                             );
                                        //$x->save();
                                        $counter++;
                                        
                                    }
                    DB::table('testdb')->insert($data);
                    $file = $file->fresh(); //reload from the database
                    $file->rows_imported = $file->rows_imported + $counter;
                    $file->save();
               },
               false
           );

           $file->imported =1;
           $file->save();
       }

       public function testfastupload(Request $request)
       {
           $file = Flag::where('imported','=','0')
                       ->orderBy('created_at', 'DESC')
                       ->first();
            $file_path = Config::get('filesystems.disks.local.root') . '/' .$file->file_name;

            
            $query = "LOAD DATA LOCAL INFILE '" . $file_path . "'
            INTO TABLE testdb
            (name,
            phone,
            dob,
            addresse,
            @created_at,
            @updated_at)
            SET created_at=NOW(),updated_at=null";

            DB::connection()->getpdo()->exec($query);
       }
    
}
