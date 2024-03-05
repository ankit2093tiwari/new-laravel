<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homepage;
use App\Models\homePageCampNews_SpoPartner;
use App\Models\homePageDescAcco_MeetExec;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomePageDataController extends Controller
{
        //function for home page static data 
    public function storeHomeStaticData(Request $request){
            try{
                if (empty($request->all())) {
                    // Request does not contain any variables
                    // Handle accordingly
                    return response()->json(['error' => 'No variables sent in the request.'], 400);
                }
                if($request->pageName){
                    $field_arr['page_name']=$request->pageName;
                    $path = storage_path('images/');
                    !is_dir($path) && mkdir($path, 0777, true);
                    //Mission Vission - head
                    if($request->headerText ){
                        $validator = Validator::make($request->all(),[                   
                            'headerText' => 'required|string',                   
                        ]);
                       
                        if($validator->fails()){
                            $response = [
                                'success' => false,
                                'error' => 'Page Header Text has some error' 
                            ];
                            return response()->json($response, 403);
                        }
                        $field_arr['header_text'] = $request->headerText;
                        
                    }
                    // mission text
                    if($request->missionText ){
                        $validator = Validator::make($request->all(),[                   
                            'missionText' => 'string',                   
                        ]);
                        if($validator->fails()){
                            $response = [
                                'success' => false,
                                'message' => 'mission field has some error',
                            ];
                            return response()->json($response, 403);
                        }
                        $field_arr['mission_text'] = $request->missionText;
                                                
                    }
                    // Vission - vision text
                    if($request->vissionText ){
                        $validator = Validator::make($request->all(),[                   
                            'vissionText' => 'string',                   
                        ]);
                        if($validator->fails()){
                            $response = [
                                'success' => false,
                                'message' => 'vission field has some error',
                            ];
                            return response()->json($response, 403);
                        }
                        $field_arr['page_text'] = $request->vissionText;
                                                
                    }
                       
                    
                     //Mission Vission - leftimage
                    if($file = $request->file('leftImage')) {
                        $validator = Validator::make($request->all(),[
                            'leftImage' => 'required|image|mimes:jpeg,png,jpg,webp,gif,bmp,eps,tiff,jfif|max:100000',          
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 422);
                        }
                       
                            $extension = $file->getClientOriginalExtension();
                            
                            // Generate a random string to append to the filename
                            $randomString = Str::random(10);
                            
                            // Generate a new filename with the original extension and the random string
                            $newFileName = 'new_file_' . $randomString . '.' . $extension;
                            
                            // Upload the file with the new filename
                           // $fileData = $this->storeAs($path, $uniqueFileName);
                           $file->move($path, $newFileName);
                            
                            $upload_path = 'storage/images/' . $newFileName;
                            $field_arr['image'] = $upload_path;
                                             
                    }
                     //Mission Vission - mid image
                    if($request->middleImage) {

                        $validator = Validator::make($request->all(),[
                            'middleImage' => 'required',          
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($request->middleImage){
                            $field_arr['image2'] = $request->middleImage;
                            $field_arr['youtube_status_middle']='1';
                            $field_arr['media_type_middle'] = 'video';
                        }
                        if($file = $request->file('middleImage')){
                         $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                        $randomString = Str::random(10);
                        
                        // Generate a new filename with the original extension and the random string
                        $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                        // Upload the file with the new filename
                       // $fileData = $this->storeAs($path, $uniqueFileName);
                       $file->move($path, $newFileName);
                        
                        $upload_path = 'storage/images/' . $newFileName;
                        $field_arr['image2'] = $upload_path; 
                        $field_arr['youtube_status_middle']='0';
                        // Define a list of common image extensions
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp','jfif'];

                        // Check if the extension is in the list of image extensions
                        if (in_array(strtolower($extension), $imageExtensions)) {
                            $field_arr['media_type_middle'] = 'image';
                        } else {
                            $field_arr['media_type_middle'] = 'video';
                        }                   
                    }
                    }

                     //Mission Vission - right image
                    if($file = $request->file('rightImage')) {

                        $validator = Validator::make($request->all(),[
                            'rightImage' => 'required|image|mimes:jpeg,png,jpg,webp,gif,bmp,eps,tiff,jfif|max:100000',          
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }

                        $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                        $randomString = Str::random(10);
                        
                        // Generate a new filename with the original extension and the random string
                        $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                        // Upload the file with the new filename
                       // $fileData = $this->storeAs($path, $uniqueFileName);
                       $file->move($path, $newFileName);
                        
                        $upload_path = 'storage/images/' . $newFileName;
                        $field_arr['image3'] = $upload_path;
                    }
                    //desription accomp - impact link
                    if($request->impactLink){
                        $validator = Validator::make($request->all(),[
                            'impactLink' => 'required|url',                    
                        ]);
                        $field_arr['impact_link'] = $request->impactLink;
                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        
                    }
                    //putting chicago to work - issue link
                    if($request->latestIssueLink){
                        $validator = Validator::make($request->all(),[
                            'latestIssueLink' => 'required|string',                    
                        ]);
                        $field_arr['issue_link'] = $request->latestIssueLink;
                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        
                    }
                    //putting chicago to work - job post link
                    if($request->jobPostLink){
                        $validator = Validator::make($request->all(),[
                            'jobPostLink' => 'required|string',                    
                        ]);
                        $field_arr['job_post_link'] = $request->jobPostLink;
                        
                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        
                    }
                    //meet our founder
                    if($request->section_title || $request->section_post || $request->file('section_media')){

                        $field_arr['section_title'] = $request->section_title;
                        $field_arr['section_post'] = $request->section_post;

                        $validator = Validator::make($request->all(),[
                            'section_title' => 'string|nullable|sometimes',          
                            'section_post' => 'string|nullable|sometimes',          
                            //'section_media' => 'string|nullable|sometimes|url|video',          
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if (preg_match("/^(https?:\/\/)?(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/i",  $request->section_media)) {
                            $field_arr['section_media'] = $request->section_media;
                            $field_arr['youtube_status']='1';
                            $field_arr['section_media_type'] = 'youtube';
                        
                        }else{


                            if($file = $request->file('section_media')) {
                                $file = $request->file('section_media');
                                $extension = $file->getClientOriginalExtension();
                            
                                // Generate a random string to append to the filename
                                    $randomString = Str::random(10);
                                
                                // Generate a new filename with the original extension and the random string
                                    $newFileName = 'new_file_' . $randomString . '.' . $extension;
                                
                                 // Upload the file with the new filename
                                // $fileData = $this->storeAs($path, $uniqueFileName);
                                $file->move($path, $newFileName);
                        
                                $upload_path = 'storage/images/' . $newFileName;
                                $field_arr['section_media'] = $upload_path;
                                $field_arr['youtube_status']='0';
                                // Define a list of common image extensions
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp','jfif'];

                                // Check if the extension is in the list of image extensions
                                if (in_array(strtolower($extension), $imageExtensions)) {
                                    $field_arr['section_media_type'] = 'image';
                                } else {
                                    $field_arr['section_media_type'] = 'video';
                                }
                            }
                        }
                    }
                    //functon for campaign page static data
                    if($request->camp_sec_title || $request->camp_sec_section_post || $request->file('camp_section_media')){

                        $field_arr['section_title'] = $request->camp_sec_title;
                        $field_arr['section_post'] = $request->camp_sec_section_post;

                        $validator = Validator::make($request->all(),[
                            'section_title' => 'string|nullable|sometimes',          
                            'section_post' => 'string|nullable|sometimes',          
                            'camp_section_media' => 'required|image|mimes:jpeg,png,jpg,jfif|max:2048',          
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($file = $request->file('camp_section_media')) {
                            $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                            $randomString = Str::random(10);
                        
                        // Generate a new filename with the original extension and the random string
                             $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                        // Upload the file with the new filename
                       // $fileData = $this->storeAs($path, $uniqueFileName);
                            $file->move($path, $newFileName);
                        
                            $upload_path = 'storage/images/' . $newFileName;
                            $field_arr['section_media'] = $upload_path;
                        
                    }
                    }
                    //functon for event page static data
                    if($request->eventPromoVideo){
 
                        $validator = Validator::make($request->all(),[         
                            'eventPromoVideo' => 'required',
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($request->eventPromoVideo){
                            $field_arr['promo_video'] = $request->eventPromoVideo;
                            $field_arr['youtube_status_promo']='1';
                            $field_arr['media_type_promo'] = 'youtube';
                        }
                        if($file = $request->file('eventPromoVideo')) {
                          
                            $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                            $randomString = Str::random(10);
                        
                        // Generate a new filename with the original extension and the random string
                             $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                        // Upload the file with the new filename
                       // $fileData = $this->storeAs($path, $uniqueFileName);
                            $file->move($path, $newFileName);
                        
                            $upload_path = 'storage/images/' . $newFileName;
                            $field_arr['promo_video'] = $upload_path;
                            $field_arr['youtube_status_promo']='0';

                            // Define a list of common image extensions
                         $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp','jfif'];

                         // Check if the extension is in the list of image extensions
                         if (in_array(strtolower($extension), $imageExtensions)) {
                             $field_arr['media_type_promo'] = 'image';
                         } else {
                            $field_arr['media_type_promo'] = 'video';
                         }
                           
                        
                    }
                    }
                    //function to add content on event page
                    if($request->attentionText){
                        $field_arr['page_text'] = $request->attentionText;
                        $validator = Validator::make($request->all(), [
                            'page_text' => 'string|nullable|sometimes',
                            
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        
                    }
                    //functon for donate page static data -- donate section
                    if($request->donateHeader){
                        $field_arr['header_text'] = $request->donateHeader;
                        $validator = Validator::make($request->all(), [
                            'donateHeader' => 'string|nullable|sometimes',
                            //'donateMedia' => 'image|mimes:jpeg,png,jpg|max:100000|nullable|sometimes',
                        ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($request->donateMedia){
                            $field_arr['image']=$request->donateMedia;

                            $field_arr['youtube_status'] = '1';
                            $field_arr['section_media'] = 'youtube';
                        }
                        if($file = $request->file('donateMedia')) {
                            $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                            $randomString = Str::random(10);
                        
                        // Generate a new filename with the original extension and the random string
                             $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                        // Upload the file with the new filename
                       // $fileData = $this->storeAs($path, $uniqueFileName);
                            $file->move($path, $newFileName);
                        
                            $upload_path = 'storage/images/' . $newFileName;
                            $field_arr['image'] = $upload_path;
                            $field_arr['youtube_status'] = '0';
                            
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp','eps','tiff','jfif'];

                                // Check if the extension is in the list of image extensions
                                if (in_array(strtolower($extension), $imageExtensions)) {
                                    $field_arr['section_media'] = 'image';
                                } else {
                                    $field_arr['section_media'] = 'video';
                                }
                    }
                    }
                    //functon for donate page static data -- wishlist section
                    if($request->wishHeader){
                        $field_arr['page_text'] = $request->wishHeader;
                        $validator = Validator::make($request->all(),[ 
                            'wishHeader' => 'required|string',        
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                    }
                    //functon for donate page static data -- wishlist section--student text
                    if($request->studentText){
                        $field_arr['section_title'] = $request->studentText;

                        $validator = Validator::make($request->all(),[ 
                            'studentText' => 'string|nullable',  
                            'studentPdf' => 'file|mimetypes:application/pdf|max:100000|nullable|sometimes', 
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($file = $request->file('studentPdf')) {
                            $extension = $file->getClientOriginalExtension();
                            
                        // Generate a random string to append to the filename
                            $randomString = Str::random(10);
                        
                        // Generate a new filename with the original extension and the random string
                             $newFileName = 'new_file_' . $randomString . '.' . $extension;
                        
                        // Upload the file with the new filename
                       // $fileData = $this->storeAs($path, $uniqueFileName);
                            $file->move($path, $newFileName);
                        
                            $upload_path = 'storage/images/' . $newFileName;
                            $field_arr['image2'] = $upload_path;
                    }
                    }
                    //functon for donate page static data -- wishlist section -- homless text/pdf
                    if($request->homelessText){
                        $field_arr['section_post'] = $request->homelessText;

                        $validator = Validator::make($request->all(),[ 
                            'homelessText' => 'string|nullable|sometimes',  
                            'homelessPdf' => 'file|mimetypes:application/pdf|max:100000|nullable|sometimes', 
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($file = $request->file('homelessPdf')) {
                            $extension = $file->getClientOriginalExtension();
                            
                    // Generate a random string to append to the filename
                    $randomString = Str::random(10);
                            
                    // Generate a new filename with the original extension and the random string
                    $newFileName = 'new_file_' . $randomString . '.' . $extension;
                            
                    // Upload the file with the new filename
                    // $fileData = $this->storeAs($path, $uniqueFileName);
                    $file->move($path, $newFileName);
                            
                    $upload_path = 'storage/images/' . $newFileName;
                            
                            $field_arr['image3'] = $upload_path;
                    }
                    }
                    //functon for get envolved  volunteer 
                    if($request->volunteerText){
                        $field_arr['header_text'] = $request->volunteerText;
                        $validator = Validator::make($request->all(),[ 
                            'volunteerText' => 'required|string',  
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                    }
                    //functon for get envolved  partner
                    if($request->partnerText){
                        $field_arr['page_text'] = $request->partnerText;
                        $validator = Validator::make($request->all(),[  
                            'partnerText' => 'required|string', 
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                    }
                     //functon for get envolved --  learn more
                     if($request->learnMoreHeader){
                        $field_arr['section_post'] = $request->learnMoreHeader;
                        $validator = Validator::make($request->all(),[ 
                            'learnMoreHeader' => 'required|string',  
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                    }
                    //functon contact us --  hear about us
                    if($request->shareHeader||$request->file('shareImage')||$request->shareText||$request->websiteLink){
    
                        $field_arr['header_text'] = $request->shareHeader;
                        $field_arr['page_text'] = $request->shareText;
                        $field_arr['impact_link'] = $request->websiteLink;

                        $validator = Validator::make($request->all(),[ 
                            'shareHeader' => 'string|nullable|sometimes',
                            'shareText' => 'string|nullable|sometimes',
                            'websiteLink' => 'url|nullable|sometimes',  
                            'shareImage' => 'image|nullable|sometimes|mimes:jpeg,png,jpg,jfif|max:2048', 
                                 ]);

                        if($validator->fails()){
                            $response = [
                                'success' => 'false',
                                'error' => $validator->messages()
                            ];
                            return response()->json($response, 403);
                        }
                        if($file = $request->file('shareImage')) {
                            $extension = $file->getClientOriginalExtension();
                            
                            // Generate a random string to append to the filename
                                $randomString = Str::random(10);
                            
                            // Generate a new filename with the original extension and the random string
                                 $newFileName = 'new_file_' . $randomString . '.' . $extension;
                            
                            // Upload the file with the new filename
                           // $fileData = $this->storeAs($path, $uniqueFileName);
                                $file->move($path, $newFileName);
                            
                                $upload_path = 'storage/images/' . $newFileName;
                                $field_arr['image'] = $upload_path;
                    }
                    }

                    $countValueIn = count($field_arr);
                    if($countValueIn==1){
                        $response = [
                            'success' => false,
                            'message' => 'No Entry Found',
                        ];
                        $response_code = 201;
                        $datatofill = 0;
                    }else{
                    $datatofill = homepage::updateOrCreate(
                        ['page_name' => $request->pageName],                            
                        $field_arr                         
                    );}
                   
                    if($datatofill){
                        $response = [
                            'success' => true,
                            'message' => 'Record data updated'];
                        $response_code = 200;
                    }else{
                        $response = [
                            'success' => false,
                            'message' => 'No entries Updated',                           
                        ];
                        $response_code = 403;
                    }
                  
            }     
            }catch (\Exception $e) {
               
                $response = [
                    'success' => false,
                    'message' =>  $e->getMessage(),
                ];
                $response_code = 501;
            }
            
            return response()->json($response, $response_code);

    }
    //get static data of home section
    public function getHomeStaticData(Request $request)
    {
        try {
            if($request->pageName){
                $getData = homepage::where('page_name', $request->pageName)->get();
           }else{
                $getData = homepage::all();
           }

            //$getData = homepage::where(pageName,); 
    
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
        
//function for Description/Accomplishment section data upload
public function storeHomeDataDescAccomplishment(Request $request){
    try{
        if (empty($request->all())) {
            // Request does not contain any variables
            // Handle accordingly
            return response()->json(['error' => 'No variables sent in the request.'], 400);
        }
        $ins_var = array();
        if($request->secName){
            $ins_var['sectionName'] = $request->secName;
			if($request->total||$request->service||$request->impactyear||isset($request->active)||$request->updateId||isset($request->order)){
             $validator = Validator::make($request->all(),[                   
                'total' => 'string|nullable|sometimes',
                'service' => 'string|nullable|sometimes',
                'impactyear' => 'numeric|nullable|sometimes',
                'order' => 'numeric|nullable|sometimes',
                'active' => 'numeric|nullable|sometimes',                  
            ]);
                       
                        if($validator->fails()){
                            $response = [

                                'success' => false,
                                'message' => 'some data is incorrect or incomplete',
                                'error' => $validator->errors(),
                            ];
                            return response()->json($response, 200);
                        }
                       
                        if($request->total){
                            $ins_var['column_1']= $request->total;
                        }
                        
                        if($request->service){
                            $ins_var['column_2']= $request->service;
                        }
                        
                        if($request->impactyear){
                            $ins_var['impactYear']= $request->impactyear;
                        }

                        if($request->order){
                            $ins_var['order_in_slider']= $request->order;
                        }
                        
                        if(isset($request->active)){
                            $ins_var['active']= $request->active;
                        }

                            $datatofill = homePageDescAcco_MeetExec::updateOrCreate(
                                ['id'=>$request->updateId],
                                $ins_var
                                );
                                if($request->updateId){
                                    $response = [
                                        'success' => true,
                                        'message' => 'Record Upfated',
                                    ];
                                    $rescode = 200;
                                }else{
                                    $response = [
                                        'success' => true,
                                        'message' => 'New Record Added',
                                    ];
                                    $rescode = 200;
                                }
                    }
                }else{
                    $response = [
                        'success' => false,
                        'message' => 'Section Name Not found',
                    ];
                    $rescode = 403;
                }
                if($request->delId){
                    $item = homePageDescAcco_MeetExec::find($request->delId);
                    $item->delete();
                    if($item){
                    $response = [
                        'success' => true,
                        'message' => 'Record Deleted',
                    ];
                    $rescode = 200;
                    }else{
                        $response = [
                            'success' => false,
                            'message' => 'Id not Found',
                        ];
                        $rescode = 403; 
                    }
                }
    
        }catch (\Exception $e) {
            
            $response = [
                'success' => false,
                'message' =>  $e->getMessage(),
            ];
            $rescode = 403;
        }

return response()->json($response, $rescode);

}
//get data of description section
public function getHomeDataDescAccomplishment()
    {
        try {

            $getData = homePageDescAcco_MeetExec::all();
    
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


    //function for Meet Executive section data upload
    public function storeHomeDataMeetExecutive(Request $request){
        try{
            if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
            $ins_var = array();
            if($request->secName){
                $ins_var['sectionName'] = $request->secName;
                if($request->name||$request->title||$request->overview||$request->media||isset($request->active)||$request->updateId){
                $validator = Validator::make($request->all(),[ 
                    'name' => 'string|nullable|sometimes',
                    'title' => 'string|nullable|sometimes',
                    'overview' => 'string|nullable|sometimes',
                    //'media' => 'image|mimes:jpeg,png,jpg|max:100000|nullable|sometimes',
                    'active' => 'numeric|nullable|sometimes',
                ]);
                    if($validator->fails()){
                        $response = [
                            'success' => false,
                            'message' => 'some data is incorrect or incomplete',
                            'error' => $validator->errors(),
                        ];
                        return response()->json($response, 422);
                    }
                    if($request->name){
                        $ins_var['column_1'] = $request->name;
                    }
                    if($request->title){
                        $ins_var['column_2'] = $request->title;
                    }
                    if($request->overview){
                        $ins_var['description'] = $request->overview;
                    }
                    if(isset($request->active)){
                        $ins_var['active'] = $request->active;
                    }
                   
                    $path = storage_path('images/');
                    !is_dir($path) && mkdir($path, 0777, true); 
                
                    if($file = $request->file('media')) {
                        $extension = $file->getClientOriginalExtension();
                                        
                        // Generate a random string to append to the filename
                        $randomString = Str::random(10);
                                        
                        // Generate a new filename with the original extension and the random string
                        $newFileName = 'new_file_' . $randomString . '.' . $extension;
                                        
                        // Upload the file with the new filename
                        // $fileData = $this->storeAs($path, $uniqueFileName);
                        $file->move($path, $newFileName);
                                        
                        $upload_path = 'storage/images/' . $newFileName;
                        $ins_var['media'] = $upload_path;
                    }        
                    
                        $datatofill = homePageDescAcco_MeetExec::updateOrCreate(
                            ['id' => $request->updateId],
                            $ins_var
                        );
                        if($request->updateId){
                            $response = [
                                'success' => true,
                                'message' => 'Recored Updated',
                            ];
                            $rescode = 200;
                        }else{
                            $response = [
                                'success' => true,
                                'message' => 'New Record Created',
                            ];
                            $rescode = 200;
                        }
                }
            }else{
                $response = [
                        'success' => false,
                        'message' => 'Section name Not Found',
                    ];
                    $rescode = 403;
            }
            if($request->delId){
                $item = homePageDescAcco_MeetExec::find($request->delId);
                $item->delete();
                if($item){
                    $response = [
                        'success' => true,
                        'message' => 'Record Deleted',
                    ];
                    $rescode = 200;
                    }else{
                        $response = [
                            'success' => false,
                            'message' => 'Id not Found',
                        ];
                        $rescode = 403; 
                    }
            }
    }catch (\Exception $e) {
        
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $rescode = 403;
    }

    return response()->json($response, $rescode);

    }
    //function for Campaign News section data upload
    public function storeHomeDataCampNews(Request $request){
        try{
            if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
            $ins_var = array();
                if($request->secName){
                    $ins_var['sectionName'] = $request->secName;
                    if($request->title||$request->date||isset($request->featuredItem)||$request->newsArticle||isset($request->active)||$request->media||$request->updateId||$request->isset($request->view)){
						$validator = Validator::make($request->all(),[ 
                            'view' => 'numeric|nullable|sometimes',
							'title' => 'string|nullable|sometimes',
                            //'media' => 'mimetypes:image/jpeg,image/png,image/jpg,image/gif,video/mp4,video/mpeg,video/quicktime,video/x-msvideo,video/x-matroska,video/x-flv,video/x-f4v,video/x-ms-wmv,video/x-ms-asf,video/webm,video/swf|max:2048000|nullable|sometimes',
							'date' => 'date|nullable|sometimes',
							'featuredItem'=> 'numeric|nullable|sometimes',
							'newsArticle' =>'string|nullable|sometimes',
							'active' => 'numeric|nullable|sometimes',
						]);
						if($validator->fails()){
							$response = [
								'success' => false,
								'message' => 'some data is incorrect or incomplete',
								'error' => $validator->errors(),
							];
							return response()->json($response, 400);
						}
                        if($request->view){
							$ins_var['view'] = $request->view;
						}
						if($request->title){
							$ins_var['title'] = $request->title;
						}
						if($request->date){
							$ins_var['expire_date'] = $request->date;
						}
						if(isset($request->featuredItem)){
							$ins_var['featuredItem'] = $request->featuredItem;
						}
						if($request->newsArticle){
							$ins_var['news_artical'] = $request->newsArticle;
						}
						if(isset($request->active)){
							$ins_var['active'] = $request->active;
						}
                   

						$path = storage_path('images/');
						!is_dir($path) && mkdir($path, 0777, true); 
						if($request->media){
                            $ins_var['media'] = $request->media;
                            $ins_var['youtube_status'] = '1';
                            $ins_var['media_type'] = 'youtube';
                        }
						if ($file = $request->file('media')) {
							$extension = $file->getClientOriginalExtension();
	
							// Generate a random string to append to the filename
							$randomString = Str::random(10);
							
							// Generate a new filename with the original extension and the random string
							$newFileName = 'new_file_' . $randomString . '.' . $extension;
							
							// Upload the file with the new filename
							// $fileData = $this->storeAs($path, $uniqueFileName);
							$file->move($path, $newFileName);
							
							$upload_path = 'storage/images/' . $newFileName;
							$ins_var['media'] = $upload_path;
                            $ins_var['youtube_status'] = '0';
                              // Define a list of common image extensions
                         $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp','jfif'];

                         // Check if the extension is in the list of image extensions
                         if (in_array(strtolower($extension), $imageExtensions)) {
                            $ins_var['media_type'] = 'image';
                         }else{
                            $ins_var['media_type'] = 'video';
                         }

						}  
                        //print_r($file['fileType']);
                        //dataToUpldInfolder();
                        //print_r($file);
                        $datatofill = homePageCampNews_SpoPartner::updateOrCreate(
                            ['id' => $request->updateId],
                            $ins_var
                           );
                           //print_r($datatofill);
                           if($request->updateId){
                            $response = [
                                'success' => true,
                                'message' => 'Record updated',
                            ];
                            $rescode = 200;
                        }else{
                            $response = [
                                'success' => true,
                                'message' => 'New record created',
                            ];
                            $rescode = 200;
                        }
					}
                }else{
                        $response = [
                            'success' => false,
                            'message' => 'Section title not defined',
                        ]; 
                        $rescode = 403;
                    }
                    if($request->delId){
                        $item = homePageCampNews_SpoPartner::find($request->delId);
                        $item->delete();
                        if($item){
                            $response = [
                                'success' => true,
                                'message' => 'Record Deleted',
                            ];
                            $rescode = 200;
                            }else{
                                $response = [
                                    'success' => false,
                                    'message' => 'Id not Found',
                                ];
                                $rescode = 403; 
                            }
                    }
    }catch (\Exception $e) {
        
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $rescode = 403;
    }

    return response()->json($response, $rescode);

    }

//get data of camp news and sponser partner
public function getHomeDataCampNews(Request $request)
    {
        try {
            if(isset($request->id)){
                $getData = homePageCampNews_SpoPartner::where('id', $request->id)->get();
            }else{
            $getData = homePageCampNews_SpoPartner::all();
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

    //get camp new data only
    public function getHomeCampNews()
    {
        try {
            
                $getData = homePageCampNews_SpoPartner::where('sectionName', 'camp_news')->get();
           
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


  //function to get only featured image
  public function getFeaturedImage(){
    try{
    $getData = homePageCampNews_SpoPartner::where('featuredItem', '1')->get();
        if($getData->count()>0){
            $response =[
                'success'=>true,
                'data' => $getData,
            ];
            $response_code=200;
        }else{
            $response = [
                'success'=> false,
                'data'=>'no data found',
            ];
            $response_code = 403;
        }
    }catch(\Exception $e){
        $response = [
            'success'=> false,
            'message'=>$e->getMessage(),
        ];
        $response_code = 403;
    }
    return response()->json($response,$response_code);
}



    //function for Sponsors & Partners section data upload
    public function storeHomeSponPartner(Request $request){
        try{
            if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
            $ins_var = array();
           
            if($request->secName){
                $ins_var['sectionName'] = $request->secName;
                if($request->title||isset($request->date)||isset($request->active)||$request->media||$request->updateId){
					$validator = Validator::make($request->all(),[
						'title' => 'string|nullable|sometimes',
						'media' => 'image|mimes:jpeg,png,jpg,jfif|max:100000|nullable|sometimes',
						'date' => 'date|nullable|sometimes',
						'active' => 'string|nullable|sometimes',
					]);
					
					if($validator->fails()){
						$response = [
							'success' => false,
							'message' => 'some data is incorrect or incomplete',
							'error' => $validator->errors(),
						];
						return response()->json($response, 422);
					}

					if($request->title){
						$ins_var['title'] = $request->title;
					}
					if(isset($request->date)){
						$ins_var['date'] = $request->date;
					}
					if(isset($request->active)){
						$ins_var['active'] = $request->active;
					}

					$path = storage_path('images/');
					!is_dir($path) && mkdir($path, 0777, true); 
				
					if($file = $request->file('media')) {
						$extension = $file->getClientOriginalExtension();
						
						// Generate a random string to append to the filename
						$randomString = Str::random(10);
						
						// Generate a new filename with the original extension and the random string
						$newFileName = 'new_file_' . $randomString . '.' . $extension;
						
						// Upload the file with the new filename
						// $fileData = $this->storeAs($path, $uniqueFileName);
						$file->move($path, $newFileName);
						
						$upload_path = 'storage/images/' . $newFileName;
						//echo $upload_path;
						$ins_var['media'] = $upload_path;
			
					}

					
                    $datatofill = homePageCampNews_SpoPartner::updateOrCreate(
                        ['id' => $request->updateId],
                        $ins_var
                    );
				
				
                    if($request->updateId){
                          $response = [
                            'success' => true,
                            'message' => ' Record Updated',
                        ];
                        $resp_var = 200;
                    }else{
                        $response = [
                            'success' => true,
                            'message' => 'New Record Created',
                        ];
                        $resp_var = 200;
                    }
                }
			}else{
				$response = [
					'success' => false,
					'message' =>  'Section title blank',
				];
				$resp_var = 403;
			}
			if($request->delId){
				$item = homePageCampNews_SpoPartner::find($request->delId);
				$item->delete();
				if($item){
				$response = [
					'success' => true,
					'message' => 'Record Deleted',
				];
				$resp_var = 200;
				}else{
					$response = [
						'success' => false,
						'message' => 'Id Not Foundd',
					];
					$resp_var = 403;
				}
			}   
    }catch (\Exception $e) {
        
        $response = [
            'success' => false,
            'message' =>  $e->getMessage(),
        ];
        $resp_var = 403;
    }

    return response()->json($response, $resp_var);

    }

    //get all the image from home page data of different sections
    public function getImagesOfAllSection(){
    try {
       $getEnvolvedData = homepage::where('page_name', 'donate')->select('image AS donateMedia','image2 AS studentPDF','image3 AS homelessPdf')->get();
        
        if ($getEnvolvedData) {
            $response = [
                'success' => true,
                'data' => $getEnvolvedData,
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

}


