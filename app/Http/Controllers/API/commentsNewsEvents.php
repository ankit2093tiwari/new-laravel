<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\saveCommentsNewsEvent;
use Illuminate\Support\Facades\Validator;


class commentsNewsEvents extends Controller
{
    //
    public function storeComments(Request $request){
        try{

            if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
                if($request->secName||$request->eventNewsId||$request->updateId){
                    
                    if($request->name || $request->comment || $request->emailId || isset($request->updateId)){
                    $validator = Validator::make($request->all(),[ 
                        'name' => 'string|nullable|sometimes',
                        'secName' => 'string|nullable|sometimes',
                        'comment' =>'string|nullable|sometimes',
                        'eventNewsId' =>'numeric|nullable|sometimes',
                        'emailId'=> 'email|nullable|sometimes',
                        'updateId' =>'numeric|nullable|sometimes',
                        'status' =>'string|nullable|sometimes',
                        
                    ]);
                   
                    if($validator->fails()){
                        $response = [
                            'success' => false,
                            'message' => 'some data is incorrect or incomplete',
                            'error' => $validator->errors(),
                        ];
                        return response()->json($response, 400);
                    }

                  

                    if($request->secName){
                        $ins_var['sectionName']=$request->secName;
                     }
                     if($request->name){
                        $ins_var['name']=$request->name;
                     }
                     if(isset($request->comment)){
                        $ins_var['comment']=$request->comment;
                     }
                     if(isset($request->eventNewsId)){
                        $ins_var['post_id']=$request->eventNewsId;
                     }
                     if(isset($request->emailId)){
                        $ins_var['email_id']=$request->emailId;
                     }
                     if(isset($request->status)){
                        $ins_var['status']=$request->status;
                     }
                  

                    $datatofill = saveCommentsNewsEvent::updateOrCreate( ['id' => $request->updateId],
                    $ins_var
                );
                        if($datatofill){
                            if($request->updateId){
                                $response = [
                                    'success' => true,
                                    'message' => 'Comment Status Changed',
                                    
                                ];
                                $response_code = 200;
                            }else{
                            $response = [
                                'success' => true,
                                'message' => 'Your Comments Saved',
                                
                            ];
                            $response_code = 200;
                                }
                        }else{
                            $response = [
                                'success' => false,
                                'message' => 'Comments not Saved Error',
                                
                            ];
                            $response_code = 403;
                        }

                    }else{
                        $response = [
                            'success' => false,
                            'message' => 'some data is incorrect or incomplete',
                            
                        ];
                        $response_code = 403;
                    }

                }else{
                    $response = [
                        'success' => false,
                        'message' => 'some fields are incorrect',
                    ];
                    $response_code = 403;
                }
                if($request->delId){
                    $item = saveCommentsNewsEvent::find($request->delId);
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
                                'message' => 'delete Id not Found',
                            ];
                            $response_code = 403; 
                        }
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


    //get all comments
    public function getComments(){
        try {

            $getData = saveCommentsNewsEvent::all();
            if ($getData) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'comments not found.',
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

    //get filtered comments with staus 1
    public function getFilteredComments(){
        try {

            $getData = saveCommentsNewsEvent::where('status','1')->get();
            if ($getData) {
                $response = [
                    'success' => true,
                    'data' => $getData,
                ];
                $response_code = 200;
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No Active Comments found',
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