<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\donationTracking;
use App\Models\donationType;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



class donatePageController extends Controller
{
    //
    public function donationFormData(Request $request){
        try{
            if($request->giftAmt||$request->name){
                $validator = Validator::make($request->all(),[ 
                    'whatInsYouText' => 'required|string',  
                    'giftAmt' => 'required|numeric',  
                    'name' => 'required|string',  
                    'phoneNumber' => 'required|string|nullable|sometimes|regex:/^[0-9]{10,}$/',
                    'email' => 'required|string|nullable|sometimes|email',
                    'address' => 'required|required|string',
                    'giftNote' => 'required|required|string',
                         ]);

                if($validator->fails()){
                    $response = [
                        'success' => 'false',
                        'error' => $validator->messages()
                    ];
                    return response()->json($response, 403);
                }

                $datatofill = donationTracking::create( [                         
                    'what_ins_you_text'=>$request->whatInsYouText,
                    'gift_amt'=>$request-> giftAmt,                
                    'name'=>$request-> name,                
                    'phone_number'=>$request-> phoneNumber,                
                    'email'=>$request-> email,                
                    'address'=>$request-> address,                
                    'gift_note'=>$request-> giftNote,                
                 ]);
                 if($datatofill){
                    $response = [
                        'success' => true,
                        'message' => 'updated',
                    ];
                    $response_code = 200;
                }else{
                    $response = [
                        'success' => false,
                        'message' => 'Not updated',                           
                    ];
                    $response_code = 403;
                }
            }else{
                $response = [
                    'success' => false,
                    'message' => 'Blank form Submitted',
                ];
                $response_code = 501;
            }
        }catch(\Exception $e){
            $response = [
                'success' => false,
                'message' =>  $e->getMessage(),
            ];
            $response_code = 501;
        }
        
        return response()->json($response, $response_code);
    }


    //get functio for above code --getting form data
    public function getdonationFormData()
{
    try {
        $getData = donationTracking::all();

        if ($getData->count() > 0) {
            $response = [
                'success' => true,
                'data' => $getData,
            ];
            $response_code = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'No contact data found.',
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

//function for donation type
    public function donationType(Request $request){
        try{
                //create bank array
                    $field_arr = array();
                    //create media storege path
                    $path = storage_path('images/');
                    !is_dir($path) && mkdir($path, 0777, true);
            // donation -- zelle text
            if($request->zelleText||$request->zelleImage){
                
                $validator = Validator::make($request->all(),[ 
                    'zelleText' => 'string|nullable|sometimes',  
                    //'zelleImage' => 'image|mimes:jpeg,png,jpg|max:2048|nullable|sometimes',
                         ]);

                if($validator->fails()){
                    $response = [
                        'success' => 'false',
                        'error' => $validator->messages()
                    ];
                    return response()->json($response, 403);
                }
                if($request->zelleText){
                    $field_arr['zelle_text'] = $request->zelleText;
                }
                if($file = $request->file('zelleImage')) {
               
                $extension = $file->getClientOriginalExtension();
                            
                // Generate a random string to append to the filename
                $randomString = Str::random(10);
                        
                // Generate a new filename with the original extension and the random string
                $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                // Upload the file with the new filename
                // $fileData = $this->storeAs($path, $uniqueFileName);
                $file->move($path, $newFileName);
                        
                $upload_path = 'storage/images/' . $newFileName;
                    $field_arr['zelle_image'] = $upload_path;
 
                }
                }
                // donationtype -- cash app text
                if($request->cashAppText){
                    
                    $validator = Validator::make($request->all(),[ 
                        'cashAppText' => 'string|nullable|sometimes',  
                        //'cashAppImage' => 'image|mimes:jpeg,png,jpg|max:100000|nullable|sometimes',
                             ]);
    
                    if($validator->fails()){
                        $response = [
                            'success' => 'false',
                            'error' => $validator->messages()
                        ];
                        return response()->json($response, 403);
                    }
                    if($request->cashAppText){
                        $field_arr['cash_app_text'] = $request->cashAppText;
                    }
                    if($file = $request->file('cashAppImage')) {
                        $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                        $randomString = Str::random(10);
                                
                        // Generate a new filename with the original extension and the random string
                        $newFileName = 'new_file_' . $randomString . '.' . $extension;
                                
                        // Upload the file with the new filename
                        // $fileData = $this->storeAs($path, $uniqueFileName);
                        $file->move($path, $newFileName);
                                
                        $upload_path = 'storage/images/' . $newFileName;
                        $field_arr['cash_app_image'] = $upload_path;
     
                    }
                    }
                    // donationtype -- mailing text
                    if($request->mailingText){
                        
                        $validator = Validator::make($request->all(),[ 
                            'mailingText' => 'string|nullable|sometimes',  
                                 ]);
        
                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($request->mailingText){
                            $field_arr['mailing_text'] = $request->mailingText;
                        }
                        }
                     
                        $anyRowExists = donationType::exists();
                        $idd = donationType::first()->id;

                        // $field_arr contains the data for update or create operation

                        if ($anyRowExists) {
                            // If at least one row exists, update the record with the specified ID
                            $datatofill = donationType::where('id', $idd)->update($field_arr);
                        } else {
                            // If no row exists, create a new record with the specified data
                            $datatofill = donationType::create($field_arr);
                        }

                        //print_r($datatofill);
                        
                
               
                if($datatofill){
                    $response = [
                        'success' => true,
                        'message' => 'updated',
                    ];
                    $response_code = 200;
                }else{
                    $response = [
                        'success' => false,
                        'message' => 'Not updated',                           
                    ];
                    $response_code = 403;
                }
              
            
        }catch(\Exception $e){
            $response = [
                'success' => false,
                'message' =>  $e->getMessage(),
            ];
            $response_code = 501;
        }
        
        return response()->json($response, $response_code);


    }
    //get data of donation type
    public function getDonationType()
    {
        try {
            $getData = donationType::all();
    
            if ($getData->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No contact data found.',
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

    //download donation data
    public function donationListDownload(Request $request){
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
            
            $getEnvolvedData = donationTracking::whereBetween('created_at', [$start_date, $end_date])->get();
            
               
               
                if ($getEnvolvedData->isNotEmpty()) {
                    $dataForCsv = $getEnvolvedData->toArray();
            
                    $csvFileName = 'donation_tracking' . date('Y-m-d_His') . '.csv';
                    $filePath = 'docs/' . $csvFileName;
            
                    $columns = array('Count','Amount', 'Name', 'Email','Phone','Address','Note','Q/A','Date');
            
                    $file = fopen(storage_path($filePath), 'w');
                    fputcsv($file, $columns);
                    $count = 0;
                    foreach ($dataForCsv as $task) {
                        $row['Count'] = ++$count;
                        $row['Amount'] = $task['gift_amt'];
                        $row['Name'] = $task['name'];
                        $row['Email'] = $task['email'];
                        $row['Phone'] = $task['phone_number'];
                        $row['Address'] = $task['address'];
                        $row['Note'] = $task['gift_note'];
                        $row['Q/A'] = $task['what_ins_you_text'];
                        $row['Date'] = $task['created_at'];
    
                        $datetimeString =  $row['Date'];
    
                        // Create a Carbon instance from the datetime string
                        $carbonDate = Carbon::parse($datetimeString);
    
                        // Get the date in your desired format (e.g., Y-m-d)
                        $dateOnly = $carbonDate->format('Y-m-d');
    
                        fputcsv($file, array($row['Count'],$row['Amount'], $row['Name'], $row['Email'],$row['Phone'],$row['Address'],$row['Note'],$row['Q/A'],$dateOnly));
                    }
            
                    fclose($file);

                    $url = 'storage/'.$filePath;
                    $response = [
                        'success' => true,
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

}
