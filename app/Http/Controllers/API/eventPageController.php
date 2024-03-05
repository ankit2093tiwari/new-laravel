<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\eventCategory;
use App\Models\eventManagement;
use App\Models\userEventRegister;
use App\Models\eventPromoImage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;



class eventPageController extends Controller
{
    //
    public function storeEventCategory(Request $request){
        try{
             $ins_var = array();
             if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
            if($request->eventType||$request->eventDescription||isset($request->active)||isset($request->updateId)){
                $validator = Validator::make($request->all(), [
                    'eventType' => 'string|nullable|sometimes',
                    'eventDescription' => 'string|nullable|sometimes',
                    'active' => 'numeric|nullable|sometimes',
                ]);
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 403);
                    }
                 
                 if($request->eventType){
                    $ins_var['event_category']=$request->eventType;
                 }
                 if($request->eventDescription){
                    $ins_var['event_description']=$request->eventDescription;
                 }
                 if(isset($request->active)){
                    $ins_var['active']=$request->active;
                 }
                 
                $datatofill = eventCategory::updateOrCreate( ['id' => $request->updateId],
                    $ins_var
                );
                if(isset($request->updteId)){
                    $response = [
                        'success' => true,
                        'message' => 'Record Update',
                    ];
                    $response_code = 200;
                }else{
                    $response = [
                        'success' => true,
                        'message' => 'New Record Created',
                    ];
                    $response_code = 200;               
            }
        }else{
            $response = [
                'success' => false,
                'message' => 'No field for Update',
            ];
            $response_code = 403;
        }
        if($request->delId){
            $item = eventCategory::find($request->delId);
            $item->delete();
            $response = [
                'success' => true,
                'message' => 'Record Deleted',
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

    //get evevnt category data
    public function getEventCategory()
    {
        try {
            $getData = eventCategory::all();
    
            if ($getData->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No event data found.',
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

    //search API  for category
    public function searchCategory(Request $request){
        try{
            $catSearchResult = eventCategory::where('event_category', 'LIKE', '%' . $request->catSearch . '%')->get();
           
            if ($catSearchResult->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $catSearchResult, // Assuming you want to send the search results
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No category data found.',
                ];
                $response_code = 204;
            }
        }catch(\Exception $e){
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
            $response_code = 403;
        }
        return response()->json($response, $response_code);
    }


    // event promo image
    public function storeEventPromoImage(Request $request){
        try{
            $ins_var = array();
            if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
        if($request->newsTitle||isset($request->active)||$request->newsMedia||isset($request->updateId)){
            $validator = Validator::make($request->all(), [
                'newsTitle' => 'string|nullable|sometimes',
                'active' => 'numeric|nullable|sometimes',
                //'newsMedia' => 'file|mimetypes:image/jpeg,image/png,image/jpg,video/mp4,video/quicktime|max:100000|nullable|sometimes', // For 2MB maximum file size
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'some data is incorrect or incomplete',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }
            if($request->newsTitle){
                $ins_var['event_title']=$request->newsTitle;
            }
            if(isset($request->active)){
                $ins_var['active']=$request->active;
            }

            //code to add video and youtube link
            if (preg_match("/^(https?:\/\/)?(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/i",  $request->newsMedia)){
                $ins_var['event_media'] = $request->newsMedia;
                $ins_var['youtube_status']='1';
                $ins_var['media_type'] = 'youtube';
                
            }else{
                if($file = $request->file('newsMedia')){
                    $path = storage_path('images/');
                    !is_dir($path) && mkdir($path, 0777, true);
                    $extension = $file->getClientOriginalExtension();
                        //$ins_var['media_type']=$extension;
                        // Generate a random string to append to the filename
                        $randomString = Str::random(10);
                                
                        // Generate a new filename with the original extension and the random string
                        $newFileName = 'new_file_' . $randomString . '.' . $extension;
                                
                        // Upload the file with the new filename
                        // $fileData = $this->storeAs($path, $uniqueFileName);
                        $file->move($path, $newFileName);
                                
                        $upload_path = 'storage/images/' . $newFileName;
                        $ins_var['event_media'] = $upload_path;
                        $ins_var['youtube_status']='0';
                         // Define a list of common image extensions
                         $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp','jfif'];

                         // Check if the extension is in the list of image extensions
                         if (in_array(strtolower($extension), $imageExtensions)) {
                             $ins_var['media_type'] = 'image';
                         } else {
                             $ins_var['media_type'] = 'video';
                         }
                    }
            }
            

                $datatofill = eventPromoImage::updateOrCreate( ['id'=>$request->updateId],
                    $ins_var
                );
                
                 if(isset($request->updateId)){
                     $response = [
                         'success' => true,
                         'message' => 'Record Updated',
                     ];
                     $response_code = 200;
                 }else{
                     $response = [
                         'success' => true,
                         'message' => 'New Record Created',                           
                     ];
                     $response_code = 200;
                 }
            
        }else{
            $response = [
                'success' => false,
                'message' => 'No field found',                           
            ];
            $response_code = 403;
        }
        if($request->delId){
            $item = eventPromoImage::find($request->delId);
            $item->delete();
            $response = [
                'success' => true,
                'message' => 'Record Deleted',
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
    //get evevnt promo media data
    public function getEventPromoImage()
    {
        try {
            $getData = eventPromoImage::all();
    
            if ($getData->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No data found.',
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


    //event management section
    public function storeEventManagement(Request $request){
        try{
            
			if($request->eventTitle||$request->eventDescription||$request->date||$request->time||$request->eventType||$request->locationAddress||$request->city||$request->state||$request->zipcode||$request->eventMedia||$request->eventCost||isset($request->active)||isset($request->delId)||isset($request->updateId)||isset($request->hits)){
				
				$validator = Validator::make($request->all(), [
                    'hits' => 'numeric|nullable|sometimes',
					'eventTitle' => 'string|nullable|sometimes',
					'eventDescription' => 'string|nullable|sometimes',
					'date' => 'date|nullable|sometimes',
					'time' => 'string|nullable|sometimes',
					'eventType' => 'string|nullable|sometimes',
					'locationAddress' => 'string|nullable|sometimes',
					'city' => 'string|nullable|sometimes',
					'state' => 'string|nullable|sometimes',
					'zipcode' => 'string|nullable|sometimes',
					//'eventMedia' => 'file|mimes:jpeg,png,jpg,gif,bmp,tiff,webp,eps|max:100000|nullable|sometimes', 
					'eventCost' => 'numeric|nullable|sometimes',
					'active' => 'numeric|nullable|sometimes',
                    'notice'=>'string|nullable|sometimes',
				]);
				if($validator->fails()){
					$response = [
						'success' => false,
						'message' => 'some data is incorrect or incomplete',
						'error' => $validator->errors(),
					];
					return response()->json($response, 403);
				}
                if(isset($request->hits)){
					$ins_var['hits']=$request->hits;
				}
				if($request->eventTitle){
					$ins_var['event_title']=$request->eventTitle;
				}
				if($request->eventDescription){
					$ins_var['event_description']=$request->eventDescription;
				}
				if(isset($request->date)){
					$ins_var['date']=$request->date;
				}
				if(isset($request->time)){
					$ins_var['time']=$request->time;
				}
				if($request->eventType){
					$ins_var['event_type']=$request->eventType;
				}
				if($request->locationAddress){
					$ins_var['location_address']=$request->locationAddress;
				}
				if($request->city){
					$ins_var['city']=$request->city;
				}
				if($request->state){
					$ins_var['state']=$request->state;
				}
				if($request->zipcode){
					$ins_var['zip_code']=$request->zipcode; 
				}
				if(isset($request->eventCost)){
					$ins_var['event_cost']=$request->eventCost;
				}
                if(isset($request->notice)){
					$ins_var['notice']=$request->notice;
				}
				if(isset($request->active)){
					$ins_var['active']=$request->active;
				}
				
                if (preg_match("/^(https?:\/\/)?(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/i",  $request->eventMedia)){
                    $ins_var['event_media'] = $request->eventMedia;
                    $ins_var['youtube_status']='1';
                    $ins_var['media_type'] = 'youtube';
                    
                }else{
				if($file = $request->file('eventMedia')){
					$path = storage_path('images/');
					!is_dir($path) && mkdir($path, 0777, true);
					$extension = $file->getClientOriginalExtension();
								
					// Generate a random string to append to the filename
					$randomString = Str::random(10);
							
					// Generate a new filename with the original extension and the random string
					$newFileName = 'new_file_' . $randomString . '.' . $extension;
							
					// Upload the file with the new filename
					// $fileData = $this->storeAs($path, $uniqueFileName);
					$file->move($path, $newFileName);
							
					$upload_path = 'storage/images/' . $newFileName;
					$ins_var['event_media']=$upload_path;
                    $ins_var['youtube_status']='0';

                    $validImageExtensions = ['jpg', 'jpeg', 'png','svg','webp','bmp','tiff','gif','apng','avif','jfif'];
                    $validVideo = ['mp4','mov','avi','wmv','avchd','flv','f4v','swf','mkv','webm','mpeg2'];
 
                    if (in_array($extension, $validVideo)) {
                        $ins_var['media_type'] = 'video';
                    }elseif (in_array($extension, $validImageExtensions)) {
                        $ins_var['media_type'] = 'image';
                    } else {
                        $ins_var['media_type'] = 'unknown';
                    }

                    
				}
                }

					
					
				if($request->delId){
					$item = eventManagement::find($request->delId);
					$item->delete();
					$response = [
						'success' => true,
						'message' => 'Record Deleted',
					];
					$response_code = 200;
				}else{
					$datatofill = eventManagement::updateOrCreate( ['id'=>$request->updateId], $ins_var);
					if($request->updateId){
						$response = [
							'success' => true,
							'message' => 'Record Updated',
						];
						$response_code = 200;
					}else{
						$response = [
							'success' => true,
							'message' => 'New Record created',                           
						];
						$response_code = 200;
					}
				}                
				
			}else{
				$response = [
					'success' => false,
					'message' => 'No Field data Found',                           
				];
				$response_code = 403;
			}
		} catch(\Exception $e){
			$response = [
				'success' => false,
				'message' =>  $e->getMessage(),
			];
			$response_code = 403;
		}

		return response()->json($response, $response_code);
    
    }

    //get event management data
    public function getEventManagementFilterData(){
    try {
        $currentDateTime = Carbon::now();
        $todayDate = Carbon::now()->format('Y-m-d');
		//echo "currentDateTime".$currentDateTime;echo "<br>";
		$week_start_date = $currentDateTime->startOfWeek()->toDateString();
        $week_end_date = $currentDateTime->endOfWeek()->toDateString();
		
       

        $month_start_date = $currentDateTime->startOfMonth()->toDateString();
        $month_end_date = $currentDateTime->endOfMonth()->toDateString();       
       
        $getData = eventManagement::all();
        
        $formattedDateTime = Carbon::now()->format('Y-m-d');
        $todayEvents = $getData->filter(function ($event) use ($formattedDateTime) {
            return Carbon::parse($event->date)->format('Y-m-d') === $formattedDateTime;
        });		
		
        $today = eventManagement::where('date',$todayDate)->get();
        $thisWeekEvents = eventManagement::whereBetween('date', [$week_start_date,$week_end_date])->get();


        $thisMonthEvents = eventManagement::whereBetween('date', [$month_start_date,$month_end_date])->get();

        $response = [
            'success' => true,
            'today_events' => $today,
            'this_week_events' => $thisWeekEvents,
            'this_month_events' => $thisMonthEvents,
        ];
        $response_code = 200;
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}
//get all data of events
public function getEventManagement(Request $request)
    {
        try {
            if(isset($request->id)){
                $getData = eventManagement::where('id',$request->id)->get();
            }else{
            $getData = eventManagement::all();
            }
            if ($getData->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No data found.',
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
///download list of events created by admin 
public function downloadEventList(){
    $getData = eventManagement::all();

    if ($getData->isNotEmpty()) {
        $dataForCsv = $getData->toArray();

        $csvFileName = 'list_of_events' . date('Y-m-d_His') . '.csv';
        $filePath = 'docs/' . $csvFileName;

        $columns = array('Item', 'Hits', 'Event Title','Total RSVP','Date','Active');

        $file = fopen(storage_path($filePath), 'w');
        fputcsv($file, $columns);

        $row = array();
        $incrRow = 0;
        foreach ($dataForCsv as $task) {
            $row['Item'] = ++$incrRow;
            $row['Hits'] = '';
            $row['Event Title'] = $task['event_title'];
            $row['Total RSVP'] = '';
            $row['Date'] = $task['date'];
            $row['Active'] = $task['active'];

                    $datetimeString =  $row['Date'];

                    // Create a Carbon instance from the datetime string
                    $carbonDate = Carbon::parse($datetimeString);

                    // Get the date in your desired format (e.g., Y-m-d)
                    $dateOnly = $carbonDate->format('Y-m-d');

            fputcsv($file, array($row['Item'], $row['Hits'], $row['Event Title'],$row['Total RSVP'],$dateOnly,$row['Active']));
        }

        fclose($file);
        $customPath = '/storage'.'/'.$filePath;
        // $url = storage_path($filePath);
        // echo $customPathurl;
        // dd();
        $response = [
            'success' => true,
            'download_link' => $customPath,
        ];
        $response_code = 200;
    }else{
        $response = [
            'success' => false,
            'message' => 'No data Found!',
        ];
        $response_code = 200;
    }


   // $path = storage_path('kindness_backend\storage\docs');
    return response()->json($response,$response_code);
  
}


// store data of user who registers in the event 
public function storeUserEventSelectionData(Request $request){
    try{
        if($request->eventId){
            $validator = Validator::make($request->all(), [
                'eventId' =>'required|numeric',
                'userName' => 'required|string',
                'email' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',

            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => 'some data is incorrect or incomplete',
                    'error' => $validator->errors(),
                ];
                return response()->json($response, 403);
            }
            
            $storeData = userEventRegister::create([
                'event_id' => $request->eventId,
                'user_name' => $request->userName,
                'user_email'=> $request->email,
                'city' => $request->city,
                'state' => $request->state,
            ]);

            if($storeData){
                $response = [
                    'success' => true,
                    'message' => 'Record Created',
                ];
                $response_code = 200;
            }else{
                $response = [
                    'success' => false,
                    'message' => 'No record created',
                ];
                $response_code = 403;
            }


        }else{
            $response = [
                'success' => false,
                'message' => 'Event Id Not Found',
            ];
            $response_code = 403;
        }

    }catch(\Exception $e){

    }
    return response()->json($response, $response_code);
}

//get all data of user registered to event
public function getUserEventSelectionData()
    {
        try {
           
            $getData = userEventRegister::all();
            
            if ($getData->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No data found.',
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

 //download list of data of user registered to event
 public function downloadUserRegisteredData(){
    try{
    $getData = userEventRegister::all();

    if ($getData->isNotEmpty()) {
        $dataForCsv = $getData->toArray();

        $csvFileName = 'user_registered_to_events_list' . date('Y-m-d_His') . '.csv';
        $filePath = 'docs/' . $csvFileName;

        $columns = array('Count', 'Candidate Name', 'Email','City','State','Date');

        $file = fopen(storage_path($filePath), 'w');
        fputcsv($file, $columns);

        $count = 0;
        foreach ($dataForCsv as $task) {
            $row['Count'] = ++$count;
            $row['Candidate Name'] = $task['user_name'];
            $row['Email'] = $task['user_email'];
            $row['City'] = $task['city'];
            $row['State'] = $task['state'];
            $row['Date'] = $task['created_at'];

                    $datetimeString =  $row['Date'];

                    // Create a Carbon instance from the datetime string
                    $carbonDate = Carbon::parse($datetimeString);

                    // Get the date in your desired format (e.g., Y-m-d)
                    $dateOnly = $carbonDate->format('Y-m-d');

            fputcsv($file, array($row['Count'], $row['Candidate Name'], $row['Email'],$row['City'],$row['State'],$dateOnly));
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
    }else{
        $response = [
            'success' => false,
            'message' => 'No data Found!',
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

//get data from two tables user register and eventManagement
public function getRsvpList(){
    try{
   
        $getData = eventManagement::select('id','event_title')->where('active','1')->get();
        
        $results = [];
       
        foreach($getData as $event){
            $idd = $event->id;
            $data = UserEventRegister::where('event_id', $idd)->get();
            $count = UserEventRegister::where('event_id', $idd)->count();
        //echo $results;
      
                    $result = [
                        'event_id' => $idd,
                        'totalRSVP' =>$count,
                        'event_name' => $event->event_title,
                        'user_data' => $data,

                    ];
            
                    $results[] = $result;
        }

        
        if (!empty($getData)) {
            $response = [
                'success' => true,
                'data' => $results,
            ];
            $response_code = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'No data found.',
            ];
            $response_code = 204;
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

    //delete rsvp data
    public function deleteRsvpListData(Request $request){
        try{
       
            if($request->delId){
                $item = UserEventRegister::find($request->delId);
                $item->delete();
               
            
            
            if (!empty($item)) {
                $response = [
                    'success' => true,
                    'message' => 'Data deleted',
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No record deleted.',
                ];
                $response_code = 204;
            }
            
        }else{
            $response = [
                'success' => false,
                'message' => 'Id not Found.',
            ];
            $response_code = 204;
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

    //// download list of rsvp
    public function downloadRSVPList(Request $request){

        $results = UserEventRegister::where('event_id', $request->id)->get();
        $results2 = eventManagement::where('id', $request->id)->select('event_title')->get();
        
         
        if ($results->isNotEmpty()) {
           $dataForCsv = $results->toArray();
           

            $csvFileName = 'rsvp_list' . date('Y-m-d_His') . '.csv';
            $filePath = 'docs/' . $csvFileName;
    
            $columns = array('id', 'user_name', 'city','state');
    
            $file = fopen(storage_path($filePath), 'w');
            $data[] = $results2;
            fputcsv($file, $data);
            fputcsv($file, $columns);
    
            $row = array();
            $incrRow = 0;
            foreach ($results as $task) {
                $row['id'] = ++$incrRow;
                $row['user_name'] = $task['user_name'];
                $row['city'] = $task['city'];
                $row['state'] = $task['state'];

                fputcsv($file, array($row['id'], $row['user_name'], $row['city'],$row['state']));
            }
           
            fclose($file);
            $customPath = '/storage'.'/'.$filePath;
            // $url = storage_path($filePath);
            // echo $customPathurl;
            // dd();
            $response = [
                'success' => true,
                'download_link' => $customPath,
            ];
            $response_code = 200;
        }else{
            $response = [
                'success' => false,
                'message' => 'No data Found!',
            ];
            $response_code = 200;
        }
    
    
       // $path = storage_path('kindness_backend\storage\docs');
        return response()->json($response,$response_code);
      
    }


}
