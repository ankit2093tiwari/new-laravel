<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\getEnvolvedInterestSetup;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\learnMoreSignUp;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class getEnvolvedController extends Controller
{
    //
    public function storeGetEnvIntrestList(Request $request){
        try{
            $inv_var = array();
            if($request->interest||isset($request->active)||isset($request->updateId)||isset($request->delId)){
                $validator = Validator::make($request->all(), [
                    'interest' => 'string|nullable|sometimes',
                    'active' => 'string|nullable|sometimes',
                ]);
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 403);
                }
                if($request->interest){
                    $inv_var['interest_type'] = $request->interest;
                }
                if(isset($request->active)){
                    $inv_var['active'] = $request->active;
                }
                  
                if($request->delId){
                    $item = getEnvolvedInterestSetup::find($request->delId);
                    $item->delete();
                    if($item){
                    $response = [
                        'success' => true,
                        'message' => 'Record Deleted',
                    ];
                    $response_code = 200;
                    }else{
                        $response = [
                            'success' => false,
                            'message' => 'Delete id not Found',
                        ];
                        $response_code = 403;
                    }
                }else{

                $datatofill = getEnvolvedInterestSetup::updateOrCreate( ['id'=>$request->updateId],                         
                 $inv_var
                );
                if($request->updateId){
                    $response = [
                        'success' => true,
                        'message' => 'Record updated',
                    ];
                    $response_code = 200;
                }else{
                    $response = [
                        'success' => true,
                        'message' => 'Record created',
                    ];
                    $response_code = 200;
                }
            }
               
            }else{
                $response = [
                    'success' => false,
                    'message' => 'Enter Filed Data',                           
                ];
                $response_code = 403;
            }
        }catch(\Exception $e){
            $response = [
                'success' => false,
                'message' =>  $e->getMessage(),
            ];
            $response_code = 403;
        }
        return response()->json($response, $response_code);
        
    }
    //////////////////////////////get api


public function getEnvIntrestList()
{
    try {

        $getEnvolvedData = getEnvolvedInterestSetup::all(); // Assuming you want to fetch the first contact us data record.
        
        if ($getEnvolvedData) {
            $response = [
                'success' => true,
                'data' => $getEnvolvedData,
            ];
            $response_code = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'Contact data not found.',
            ];
            $response_code = 204;
        }
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}

// delete data of learn more section of get evolved page
public function deleteLearnMore(Request $request){
    try{
        if($request->delId){
            $item = learnMoreSignUp::find($request->delId);
            $item->delete();
            if($item){
                $response = [
                    'success' => true,
                    'message' => 'Record Deleted',
                ];
                $response_code = 200;
        }else{
            $response = [
                'success' => true,
                'message' => 'Record not deleted',
            ];
            $response_code = 200; 
        }
    }else{
        $response = [
            'success' => true,
            'message' => 'Record id not set',
        ];
        $response_code = 200; 
    }
    }catch(\Exception $e){
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $response_code = 403;
    }
    return response()->json($response, $response_code);
}

public function storeLearnMore(Request $request){
    try{
        $inv_var = array();
        if (empty($request->all())) {
            // Request does not contain any variables
            // Handle accordingly
            return response()->json(['error' => 'No variables sent in the request.'], 400);
        }
        
        if(isset($request->section_name)||isset($request->updateId)||isset($request->email)||isset($request->phone)||isset($request->interest)||isset($request->message)||isset($request->name)){
            $validator = Validator::make($request->all(), [
                'section_name' => 'string|nullable|sometimes',
                'name'=> 'string|nullable|sometimes',
                'email'=> 'email|nullable|sometimes',
                'phone'=> 'numeric|nullable|sometimes',
                'interest'=> 'string|nullable|sometimes',
                'message'=> 'string|nullable|sometimes',
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'some data is incorrect or incomplete',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }
            /////////////////////////////////////////////check if eamil already exist///////////////////
            if($request->email){
                //echo $request->email;
                $inputValues['email'] = $request->email;
                // checking if email exists in ‘email’ in the ‘users’ table
                $rules = array(
                    'email' => [
                        'unique:learnmoresignuptables,email,NULL,id,section_name,learn_more',
                    ],
                );
                $validator = Validator::make($inputValues, $rules);
            }
                if ($validator->fails()) {
                  
                $response = [
                    'success' => false,
                    'message' => 'Email already exists',  
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 200);
            
            }else{
                if($request->section_name){
                    $inv_var['section_name']=$request->section_name;
                }
                if($request->name){
                    $inv_var['name']=$request->name;
                }
                if($request->email){
                    $inv_var['email']=$request->email;
                }
                if($request->phone){
                    $inv_var['phone']=$request->phone;
                }
                if($request->interest){
                    $inv_var['interest']=$request->interest;
                }
                if($request->message){
                    $inv_var['message']=$request->message;
                }

                $datatofill = learnMoreSignUp::updateOrCreate( ['id'=> $request->updateId],  $inv_var    );

                //dd($datatofill);
                if($request->updateId){
                    $response = [
                        'success' => true,
                        'message' => 'Record updated',
                    ];
                    $response_code = 200;
                }else{
                    $response = [
                        'success' => true,
                        'message' => 'Record created',
                    ];
                    $response_code = 200;
                }
            }
            ////////////////////////////////////////////  
           
        }else{
            $response = [
                'success' => false,
                'message' => 'Enter Filed Data',                           
            ];
            $response_code = 403;
        }
    }catch(\Exception $e){
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $response_code = 403;
    }
    return response()->json($response, $response_code);
}



 //download donation data
 public function learnMoreListDownload(Request $request){
    try {
        if($request->start_date && $request->end_date){

            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date'=> 'required|date',
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'some data is incorrect or incomplete',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }

                $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                
                $getEnvolvedData = learnMoreSignUp::where('section_name','learn_more')
                ->whereBetween('created_at', [$start_date, $end_date])->get();

        
           
            if ($getEnvolvedData->isNotEmpty()) {
                $dataForCsv = $getEnvolvedData->toArray();
        
                $csvFileName = 'learn_more_list' . date('Y-m-d_His') . '.csv';
                $filePath = 'docs/' . $csvFileName;
        
                $columns = array('Count', 'Name', 'Email','Phone','Interest','Message','Date');
        
                $file = fopen(storage_path($filePath), 'w');
                fputcsv($file, $columns);
                $count = 0;
                foreach ($dataForCsv as $task) {
                    $row['Count'] = ++$count;
                    $row['Name'] = $task['name'];
                    $row['Email'] = $task['email'];
                    $row['Phone'] = $task['phone'];
                    $row['Interest'] = $task['interest'];
                    $row['Message'] = $task['message'];
                    $row['Date'] = $task['created_at'];

                    $datetimeString =  $row['Date'];

                    // Create a Carbon instance from the datetime string
                    $carbonDate = Carbon::parse($datetimeString);

                    // Get the date in your desired format (e.g., Y-m-d)
                    $dateOnly = $carbonDate->format('Y-m-d');

                    fputcsv($file, array($row['Count'], $row['Name'], $row['Email'],$row['Phone'],$row['Interest'],$row['Message'],$dateOnly));
                }
        
                fclose($file);

                $url = 'storage/'.$filePath;
                // Move the file to the 'public' disk to make it accessible from the web
                //Storage::disk('public')->put($csvFileName, Storage::get('public'.$csvFileName));
        
                // Generate a public URL for the file
                //$url = Storage::disk('public')->url($csvFileName);
                //echo $url;
                
                //$sourceFilePath = 'C:\xampp\htdocs\kindness_backend\storage\docs\\' . $csvFileName;
                // $destinationFilePath = 'public/' . $csvFileName;

                // // Copy the file from the storage/docs directory to the public disk
                // Storage::disk('public')->move($filePath, $destinationFilePath);
                // $url = Storage::disk('public')->url($csvFileName);
                $response = [
                    'success' => true,
                    'download_link' => $url,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No downloadable data found',
                ];
                $response_code = 200;
            }
        }else{
            $response = [
                'success' => false,
                'message' => 'Dates to filter data not Found! Please enter both start and end date',
            ];
            $response_code = 200;
        }
        
    }catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}



/*//get api of learn more section of get evolved page
public function getLearMoreData()
{
    try {
        $getEnvolvedData = learnMoreSignUp::where('section_name', 'learn_more')->get();        
        if ($getEnvolvedData) {
            $response = [
                'success' => true,
                'data' => $getEnvolvedData,
            ];
            $response_code = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'Contact data not found.',
            ];
            $response_code = 404;
        }
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}
*/

// store data of signup today get involved page
public function storeSignUp(Request $request){
    try{
        if($request->section_name){
            $validator = Validator::make($request->all(), [
                
                'email'=> 'required|email',
                'section_name'=>'required|string',
               
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'some data is incorrect or incomplete',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }

            if($request->email){
                //echo $request->email;
                $inputValues['email'] = $request->email;
                // checking if email exists in ‘email’ in the ‘users’ table
                $rules = array(
                    'email' => [
                        'unique:learnmoresignuptables,email,NULL,id,section_name,sign_up',
                    ],
                );
                $validator = Validator::make($inputValues, $rules);
            }
                if ($validator->fails()) {
                  
                $response = [
                    'success' => false,
                    'message' => 'Email already exists',  
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 200);
                }
              
            $datatofill = learnMoreSignUp::create( [                         
              
               'email'=>$request->email,
                'section_name'=> $request->section_name,
            ]);
           
            if($datatofill){
                $response = [
                    'success' => true,
                    'message' => 'Record Added',
                ];
                $response_code = 200;
            }else{
                $response = [
                    'success' => false,
                    'message' => 'Error',                           
                ];
                $response_code = 403;
            }
        }else{
            $response = [
                'success' => false,
                'message' => 'Enter Filed Data',                           
            ];
            $response_code = 403;
        }
    }catch(\Exception $e){
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $response_code = 403;
    }
    return response()->json($response, $response_code);
}


// update signup data
public function updateSignUp(Request $request){

    try{
            $ins_var;
            $validator = Validator::make($request->all(), [
                
                'email'=> 'required|email',
               
                'updId' => 'required|numeric',
               
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'some data is incorrect or incomplete',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }

              $ins_var['email'] = $request->email;
             
            $datatofill = learnMoreSignUp::updateOrCreate( ['id' => $request->updId],
            $ins_var
        );

            if(isset($datatofill)){
                $response = [
                    'success' => true,
                    'message' => 'Record Update',
                ];
                $response_code = 200;
            }else{
                $response = [
                    'success' => false,
                    'message' => 'not updated',
                ];
                $response_code = 200;               
        }

      

    }catch(\Exception $e){
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $response_code = 403;
    }
    return response()->json($response, $response_code);
}


// delete data of signup more section of get evolved page
public function deleteSignUp(Request $request){
    try{
        if($request->delId){
            $item = learnMoreSignUp::find($request->delId);
            $item->delete();
            if($item){
                $response = [
                    'success' => true,
                    'message' => 'Record Deleted',
                ];
                $response_code = 200;
        }else{
            $response = [
                'success' => true,
                'message' => 'Record not deleted',
            ];
            $response_code = 200; 
        }
    }else{
        $response = [
            'success' => true,
            'message' => 'Record id not set',
        ];
        $response_code = 200; 
    }
    }catch(\Exception $e){
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $response_code = 403;
    }
    return response()->json($response, $response_code);
}


//get api of signup today get involved page
public function getSignUpData()
{
    try {
       // $learnMoreData = learnMoreSignUp::where('section_name', 'learn_more')->get();
        $signUpData = learnMoreSignUp::where('section_name', 'sign_up')->get();

        // $posts = DB::table('learnmoresignuptables')
        //     ->join('getenvolvedinterestsetuptables', 'learnmoresignuptables.interest', '=', 'getenvolvedinterestsetuptables.id')
        //     ->get();

        $posts = DB::table('learnmoresignuptables')
            ->join('getenvolvedinterestsetuptables', 'learnmoresignuptables.interest', '=', 'getenvolvedinterestsetuptables.id')
            ->where('learnmoresignuptables.section_name', 'learn_more')
            ->select('learnmoresignuptables.id', 'learnmoresignuptables.name', 'learnmoresignuptables.email', 'learnmoresignuptables.phone', 'learnmoresignuptables.message', 'learnmoresignuptables.interest', 'learnmoresignuptables.created_at', 'getenvolvedinterestsetuptables.interest_type')
            ->get();
  
        $response = [];
        
        if ($posts->isNotEmpty()) {
            $response['learn_more'] = [
                'success' => true,
                'data' => $posts,
            ];
            $response_code = 200;
        } else {
            $response['learn_more'] = [
                'success' => false,
                'message' => 'Learn More data not found.',
            ];
            $response_code = 403;
        }
        
        if ($signUpData->isNotEmpty()) {
            $response['sign_up'] = [
                'success' => true,
                'data' => $signUpData,
            ];
            $response_code = 200;
        } else {
            $response['sign_up'] = [
                'success' => false,
                'message' => 'Sign Up data not found.',
            ];
            $response_code = 403;
        }
        
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}

// api for filter of learn more section data  Interest Report
public function getInterestReport(Request $request){
    try {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
       
        
        if ($startDate == '' && $endDate == '') {
            $getEnvolvedData = learnMoreSignUp::where('section_name', 'learn_more')->get();
            if ($getEnvolvedData->isNotEmpty()) {
                $dataForCsv = $getEnvolvedData->toArray();
        
                $csvFileName = 'interest_report_' . date('Y-m-d_His') . '.csv';
                $filePath = 'docs/' . $csvFileName;
        
                $columns = array('Name', 'Email', 'Interest','Message','Date');
        
                $file = fopen(storage_path($filePath), 'w');
                fputcsv($file, $columns);
        
                foreach ($dataForCsv as $task) {
                    $row['Name'] = $task['name'];
                    $row['Email'] = $task['email'];
                    $row['Interest'] = $task['interest'];
                    $row['Message'] = $task['message'];
                    $row['Date'] = $task['created_at'];

                    $datetimeString =  $row['Date'];

                    // Create a Carbon instance from the datetime string
                    $carbonDate = Carbon::parse($datetimeString);

                    // Get the date in your desired format (e.g., Y-m-d)
                    $dateOnly = $carbonDate->format('Y-m-d');

                    fputcsv($file, array($row['Name'], $row['Email'], $row['Interest'],$row['Message'],$dateOnly));
                }
        
                fclose($file);
        
                // Move the file to the 'public' disk to make it accessible from the web
                //Storage::disk('public')->put($csvFileName, Storage::get('public'.$csvFileName));
        
                // Generate a public URL for the file
                //$url = Storage::disk('public')->url($csvFileName);
                //echo $url;
                
                //$sourceFilePath = 'C:\xampp\htdocs\kindness_backend\storage\docs\\' . $csvFileName;
                $destinationFilePath = 'public/' . $csvFileName;

                // Copy the file from the storage/docs directory to the public disk
                Storage::disk('public')->move($filePath, $destinationFilePath);
                $url = Storage::disk('public')->url($csvFileName);
                $response = [
                    'success' => true,
                    'data' => $getEnvolvedData,
                    'download_link' => $url,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No downloadable data found.',
                ];
                $response_code = 200;
            }
        }
        
        if($startDate || $endDate){
            $validator = Validator::make($request->all(), [
                'startDate' => 'date|nullable|sometimes',
                'endDate'=> 'date|nullable|sometimes',
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'Correct the format of Date',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }
            if($startDate && $endDate==''){
                $endDate = Carbon::now()->toDateString();
                  // print_r( $startDate);
                   //print_r( $endDate);
                   //dd();
                   $getEnvolvedData = learnMoreSignUp::where('created_at', '>=', $startDate)
                   ->where('created_at', '<=', $endDate . ' 23:59:59')
                   ->where('section_name', 'learn_more') // Add the condition to check the section_name
                   ->get();

                    if ($getEnvolvedData->isNotEmpty()) {
                        $response = [
                            'success' => true,
                            'data' => $getEnvolvedData,
                        ];
                        $response_code = 200;
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'No downloadable data found.',
                        ];
                        $response_code = 200;
                    }
                }
                if($endDate && $startDate==''){
                    $startDate = Carbon::now()->subYears(10)->toDateString();

                    $getEnvolvedData = learnMoreSignUp::where('created_at', '>=', $startDate)
                   ->where('created_at', '<=', $endDate . ' 23:59:59')
                   ->where('section_name', 'sign_up') // Add the condition to check the section_name
                   ->get();

    
    
                        if ($getEnvolvedData->isNotEmpty()) {
                            $response = [
                                'success' => true,
                                'data' => $getEnvolvedData,
                            ];
                            $response_code = 200;
                        } else {
                            $response = [
                                'success' => false,
                                'message' => 'No downloadable data found.',
                            ];
                            $response_code = 200;
                        }
                    }
        }
     } catch (\Exception $e) {
         $response = [
             'success' => false,
             'message' => $e->getMessage(),
         ];
         $response_code = 403;
     }
 
     return response()->json($response, $response_code);
}


//api for get involved page -- signup today
public function singnUpTodayDownloadList(){
    try {
        
            $getEnvolvedData = learnMoreSignUp::where('section_name', 'sign_up')->get();
            if ($getEnvolvedData->isNotEmpty()) {
                $dataForCsv = $getEnvolvedData->toArray();
        
                $csvFileName = 'sign_up' . date('Y-m-d_His') . '.csv';
                $filePath = 'docs/' . $csvFileName;
        
                $columns = array('Count','Name', 'Email', 'City','State','Date');
        
                $file = fopen(storage_path($filePath), 'w');
                fputcsv($file, $columns);
                $count = 0;
                foreach ($dataForCsv as $task) {
                    $row['Count'] = ++$count;
                    $row['Name'] = $task['name'];
                    $row['Email'] = $task['email'];
                    $row['City'] = $task['city'];
                    $row['State'] = $task['state'];
                    $row['Date'] = $task['created_at'];

                    $datetimeString =  $row['Date'];

                    // Create a Carbon instance from the datetime string
                    $carbonDate = Carbon::parse($datetimeString);

                    // Get the date in your desired format (e.g., Y-m-d)
                    $dateOnly = $carbonDate->format('Y-m-d');

                    fputcsv($file, array($row['Count'],$row['Name'], $row['Email'], $row['City'],$row['State'],$dateOnly));
                }
        
                fclose($file);
                $url = 'storage/'.$filePath;


                // Move the file to the 'public' disk to make it accessible from the web
                //Storage::disk('public')->put($csvFileName, Storage::get('public'.$csvFileName));
        
                // Generate a public URL for the file
                //$url = Storage::disk('public')->url($csvFileName);
                //echo $url;
                
                //$sourceFilePath = 'C:\xampp\htdocs\kindness_backend\storage\docs\\' . $csvFileName;
                // $destinationFilePath = 'public/' . $csvFileName;

                // // Copy the file from the storage/docs directory to the public disk
                // Storage::disk('public')->move($filePath, $destinationFilePath);
                // $url = Storage::disk('public')->url($csvFileName);
                $response = [
                    'success' => true,
                    
                    'download_link' =>$url ,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No downloadable data found.',
                ];
                $response_code = 200;
            }
        
    }catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}


}
