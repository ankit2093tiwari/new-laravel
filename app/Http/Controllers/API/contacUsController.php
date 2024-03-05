<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\contacUs;
use App\Models\userformData;
use Mail;

use Illuminate\Support\Str;

class contacUsController extends Controller
{
    //
    public function storeContactUsData(Request $request){
        try{
            $ins_var = array();
            if (empty($request->all())) {
                // Request does not contain any variables
                // Handle accordingly
                return response()->json(['error' => 'No variables sent in the request.'], 400);
            }
           
            if($request->contactHeader||$request->file('contactImage')||$request->companyName||$request->address||$request->cityStateZip||$request->phoneNumber||$request->corpEmail){
                $validator = Validator::make($request->all(), [
                    'contactHeader' => 'string|nullable|sometimes',
                    'companyName' => 'string|nullable|sometimes',
                    'address' => 'string|nullable|sometimes',
                    'cityStateZip' => 'string|nullable|sometimes',
                    'phoneNumber' => 'string|nullable|sometimes|regex:/^[0-9]{10,}$/',
                    'corpEmail' => 'string|nullable|sometimes|email',
                  //  'contactImage' => 'image|nullable|sometimes|mimes:jpeg,png,jpg|max:100000',
                ]);
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 403);
                }
            
                if($request->contactHeader){
                    $ins_var['contact_header']=$request->contactHeader;
                }
                if($request->companyName){
                    $ins_var['company_name']=$request->companyName;
                }
                if($request->address){
                    $ins_var['address']=$request->address;
                }
                if($request->cityStateZip){
                    $ins_var['city_state_zip']=$request->cityStateZip;
                }
                if($request->phoneNumber){
                    $ins_var['phone_number']=$request->phoneNumber;
                }
                if($request->corpEmail){
                    $ins_var['corp_email']=$request->corpEmail;
                }

                $path = storage_path('images/');
                !is_dir($path) && mkdir($path, 0777, true);
                if($file = $request->file('contactImage')){
                    $extension = $file->getClientOriginalExtension();
                            
                    // Generate a random string to append to the filename
                    $randomString = Str::random(10);
                            
                    // Generate a new filename with the original extension and the random string
                    $newFileName = 'new_file_' . $randomString . '.' . $extension;
                            
                    // Upload the file with the new filename
                    // $fileData = $this->storeAs($path, $uniqueFileName);
                    $file->move($path, $newFileName);
                            
                    $upload_path = 'storage/images/' . $newFileName;
                    $ins_var['contact_image']= $upload_path;
                    }

                    $record = contacUs::first();
                 

                    $datatofill = contacUs::updateOrCreate(['id'=>$record->id],
                     $ins_var
                    );

                    
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
                    'message' =>  'All Blank Field Submitted',
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

    // delete data of contact us --- user data
public function deleteContactUsData(Request $request){
    try{
        if($request->delId){
            $item = userformData::find($request->delId);
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
   
public function getContactUsData(){
    try {
        $contactData = contacUs::first(); // Assuming you want to fetch the first contact us data record.
        if ($contactData) {
            $response = [
                'success' => true,
                'data' => $contactData,
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


    


        //contact us user end form to save in db
        public function uuserContactFormData(Request $request){
            try{
                $validator = Validator::make($request->all(), [
                    "name" => 'required|string',
                    "email" => 'required|email',
                    "message" => 'required|string',
                ]);
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 403);
                }
                 
                $datatoFill = userformData::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' =>$request->message,
                ]);
                $response = [
                    'success' => true,
                    'message' => 'Thanks for Contacting Us',
                ];
                $response_code = 200;

                //email code
              /* function contactPost(Request $request){
				
				
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|email',
                        'comment' => 'required'
                    ]);
                    if($validator->fails()){
                        $response = [
                            'success' => false,
                            'message' => 'some data is incorrect or incomplete',
                            'error' => $validator->errors(),
                        ];
                        return response()->json($response, 403);
                    }
                    
                    $name = $request->name;
                    $email = $request->email;
                    $comment = $request->comment;
    
					Mail::send('contact_mail', [
						
						'name' => $request->name,
						'email' => $request->email,
						'comment' =>$request->comment,
						
					],
						function ($message) use ($request) {
							
							$message->from('kumar.ashish06081998@gmail.com');
							$message->to($request->email, $request->name)
							->subject('Your Website Contact Form');
					});
					echo 'hee';
					dd();
				}    
                //email cod end*/

                //calling mail funciton
                //contactPost();
                $this->contactPost($request);
            }catch(\Exception $e){
                $response = [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
                $response_code = 403;
            
            }
            return response()->json($response, $response_code);
        }
		
		
		public function userContactFormData(Request $request){
				
				try{
				$validator = Validator::make($request->all(), [
                    'name' => 'required|string',
                    'email' => 'required|email',
                    'message' => 'required|string',
                ]);
                if($validator->fails()){
                    $response = [
                        'success' => false,
                        'message' => 'some data is incorrect or incomplete',
                        'error' => $validator->errors(),
                    ];
                    return response()->json($response, 403);
                }
				
                $datatoFill = userformData::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' =>$request->message,
                ]);

                if($datatoFill){
               // thanks mail send to user
                Mail::send('contact_mail', [
					
					'name' => $request->name,
					'email' => $request->email,
					'comment' =>$request->message,
					
				],
                function ($message) use ($request) {
					
					$message->from('kumar.ashish06081998@gmail.com');
					$message->to($request->email, $request->name)
					->subject('Your Website Contact Form');
			});
                // mail sent to admin --  user data
            Mail::send('contact_mail_toAdmin', [
					
                'name' => $request->name,
                'email' => $request->email,
                'comment' =>$request->message,
                
            ],
            function ($message) use ($request) {
                
                $message->from('kumar.ashish06081998@gmail.com');
                $message->to('ankit.tiwari2093@gmail.com', 'kindness')
                ->subject('New User Contact Details');
        });

            $response = [
                'success' => true,
                'message' => 'Thanks for Contacting Us',
            ];
            $response_code = 200;
            }else{
            $response = [
                'success' => false,
                'message' => 'Email not sent',
            ];
            $response_code = 403;
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
}

