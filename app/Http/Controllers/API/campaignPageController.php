<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\campaignPageEquityManagement;
use Illuminate\Support\Str;

class campaignPageController extends Controller
{
    // header section data
   /* public function storeCampaignStaticData(Request $request){
        try{
            if($request->AbtUsHeader){
                $validator = Validator::make($request->all(), [
                    'AbtUsHeader' => 'required|string',
                     'SecPost' => 'required|string',
                     'SecMedia' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 200);
                }
                 
                 $path = storage_path('images/');
                 !is_dir($path) && mkdir($path, 0777, true);       
         
                if($file = $request->file('SecMedia')) {
                     $fileData = $this->uploads($file,$path);           
      
                     $upload_path = 'storage/images/'.$fileData['fileName'];
                    
                     $datatofill = campaignPageModel::updateOrCreate(
                        ['header' => $request->AbtUsHeader],
                        ['header' => $request->AbtUsHeader,
                        'post' => $request->SecPost,
                         'media' => $upload_path]
                        );
                } 
                  
                    if($datatofill){ 
                    $response = [
                        'success' => true,
                        'message' => 'Record Updated',
                    ];
                }
            }else{
                $response = [
                    'success' => false,
                    'message' => 'Empty Header',
                ]; 
            }
        }catch(\Exception $e){
            $response = [
                'success' => false,
                'message' =>  $e->getMessage(),
            ];
        }
        return response()->json($response, 200);
    }*/

    //equity management data
    public function storeCampaignEquityManagement(Request $request){
        try{
         
            $dataArray = array();
            if($request->secName||isset($request->updateId)||isset($request->delId)||$request->newsMedia){
                $validator = Validator::make($request->all(), [
                    'imgDesc' => 'string|nullable|sometimes',
                    //'newsMedia' => 'file|mimes:jpeg,png,jpg,mp4,mp3,mov,webp,avi,webm,gif,wmv,mkv,tiff,wmv,flv,bmp,swf,ico,apng,avif,f4v,webm,avchd|nullable|sometimes', // For 10MB maximum file size
                ]);
                
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 403);
                }
                if($request->imgDesc){
					$dataArray['description'] = $request->imgDesc;
                }
                if($request->secName){
					$dataArray['sec_name'] = $request->secName;
                }

                if($request->newsMedia){
                    $dataArray['media'] = $request->newsMedia;
                    $dataArray['media_type'] = 'youtube';  
                }
                if($file = $request->file('newsMedia')){
                //$file = $request->file('newsMedia');
                
                    $path = storage_path('images/');
                    !is_dir($path) && mkdir($path, 0777, true);
                    $extension = $file->getClientOriginalExtension();
                    $media_type = '';
                    $validImageExtensions = ['jpg', 'jpeg', 'png','svg','webp','bmp','tiff','gif','apng','avif','jfif'];
                    $validVideo = ['mp4','mov','avi','wmv','avchd','flv','f4v','swf','mkv','webm','mpeg2'];
 
                    if (in_array($extension, $validVideo)) {
                        $media_type = 'video';
                    }elseif (in_array($extension, $validImageExtensions)) {
                        $media_type = 'image';
                    } else {
                        $media_type = 'unknown';
                    }
                
                    // Generate a random string to append to the filename
                    $randomString = Str::random(10);
                            
                    // Generate a new filename with the original extension and the random string
                    $newFileName = 'new_file_' . $randomString . '.' . $extension;
                            
                    // Upload the file with the new filename
                    // $fileData = $this->storeAs($path, $uniqueFileName);
                    $file->move($path, $newFileName);
            
                    $upload_path = 'storage/images/' . $newFileName;
                    $dataArray['media'] = $upload_path;
                    $dataArray['media_type'] = $media_type;  
                }
            if($request->delId){
                $item = campaignPageEquityManagement::find($request->delId);
                $item->delete();
                if(isset($item)){
                    $response = [
                        'success' => true,
                        'message' => 'Record Deleted',
                    ];
                    $response_code = 200;
                }else{
                    $response = [
                        'success' => false,
                        'message' => 'Record not Found or Deleted',
                    ];
                    $response_code = 403;
                }
            }else{
                
                $datatofill = campaignPageEquityManagement::updateOrCreate(
                    ['id'=>$request->updateId],
                    $dataArray
                );
            if(isset($request->updateId)){
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
        }   
    }else{
        $response = [
            'success' => false,
            'message' => 'section Name not found',
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

    //get data of equity management data
    public function getCampaignEquityManagement()
    {
        try {
            
            
			$result = campaignPageEquityManagement::all();
			if ($result->count() > 0) {
                $response = [
                    'success' => true,
                    'data' => $result,
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



    //same aas above for admin page get api equity managment
    public function getCampaignEquityManagementAdmin()
{
    try {
        $section_names = array('health_equity', 'education_equity', 'workforce_equity', 'public_equity');
        $responseData = array();

        foreach ($section_names as $section_name) {
            $getData = campaignPageEquityManagement::where('sec_name', $section_name)->get();
            // print_r($getData);
            // dd();

            if ($getData->count() > 0) {
                $sectionData = array(
                    'section_name' => $section_name,
                    'data' => $getData,
                );

                $responseData[] = $sectionData;
            }
        }

        // Group the responseData array by section_name
        $groupedData = collect($responseData)->groupBy('section_name');

        // Transform the groupedData to the required format
        $formattedData = $groupedData->map(function ($sections) {
            $sectionData = [];
            foreach ($sections as $section) {
                foreach ($section['data'] as $item) {
                    $sectionData[] = [
                        'description' => $item->description,
                        'media_type' => $item->media_type,
                        'media' =>$item->media,
                    ];
                }
            }
            return $sectionData;
        });

        if ($formattedData->isEmpty()) {
            $response = [
                'success' => false,
                'message' => 'No data found for the specified sections.',
            ];
            $response_code = 204;
        } else {
            $response = [
                'success' => true,
                'data' => $formattedData,
            ];
            $response_code = 200;
        }

        return response()->json($response, $response_code);
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
        ];
        $response_code = 403;
    }

    return response()->json($response, $response_code);
}


}
