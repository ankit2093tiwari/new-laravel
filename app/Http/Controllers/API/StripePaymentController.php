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
use App\Models\donationTracking;

use Session;
use Stripe;

class StripePaymentController extends Controller{
	
	// private $stripe;
    // public function __construct()
    // {
    //     $this->stripe = new StripeClient('sk_test_51NgNKeSIvRgsFXQshl2t5Y27gOpL12TC8VH8pkwu1qhiRjwLzlgh19XWE7aDiSPkpjN0dYTTnpZX5JAKNhq0kpiV00JGbrKJKv');
    // }

	public function stripePost(Request $request){
		
		
		try {
            if($request->amt || $request->donorName){
                $validator = Validator::make($request->all(),[ 
                    'donationMessage' => 'required|string',  
                    'amt' => 'required|numeric',  
                    'donorName' => 'required|string',  
                    'donorPhone' => 'required|string|nullable|sometimes|regex:/^[0-9]{10,}$/',
                    'donorEmail' => 'required|string|nullable|sometimes|email',
                    'donorAddress' => 'required|required|string',
                    'donorGiftNote' => 'required|required|string',
                         ]);

                if($validator->fails()){
                    $response = [
                        'success' => 'false',
                        'error' => $validator->messages()
                    ];
                    return response()->json($response, 403);
                }

                $datatofill = donationTracking::create( [                         
                    'what_ins_you_text'=>$request->donationMessage,
                    'gift_amt'=>$request->amt,                
                    'name'=>$request->donorName,                
                    'phone_number'=>$request->donorPhone,                
                    'email'=>$request->donorEmail,                
                    'address'=>$request->donorAddress,                
                    'gift_note'=>$request->donorGiftNote,                
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
            return response()->json($response, $response_code);
        }catch (\Exception $e) {
		   
			$response = [
				'success' => false,
				'message' =>  $e->getMessage(),
			];
			$response_code = 501;
			return response()->json($response, $response_code);
		}
		
	}
	
}
