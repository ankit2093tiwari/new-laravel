<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use ErrorException;
use App\Http\Controllers\Controller;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    
	private $stripe;
    public function __construct(){
		//$this->stripe = new StripeClient('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');
		$this->stripe = new StripeClient('sk_test_51NWr6bKALw1Ok2lyMc6O5SUT2JdTjv2d9Bvk7JC8QsWS7tlOm0LNupaEfIe773iDxBx39tzpeZOKZuU2aVxKw1su00QjSVvtjo');
        //$this->stripe = new StripeClient('sk_test_tR3PYbcVNZZ796tH88S4VQ2u');

    }
	
	/** Pay order via stripe */
    public function payByStripe(Request $request){
        //Stripe::setApiKey('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');
       Stripe::setApiKey('sk_test_51NWr6bKALw1Ok2lyMc6O5SUT2JdTjv2d9Bvk7JC8QsWS7tlOm0LNupaEfIe773iDxBx39tzpeZOKZuU2aVxKw1su00QjSVvtjo');
       // Stripe::setApiKey('sk_test_tR3PYbcVNZZ796tH88S4VQ2u');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $request->paymentAmount*100, 
                'currency' => 'USD',
                'description' => $request->description,
		'payment_method'=> $request->paymentMethodId,
		'payment_method_types' => ['card'],
                'confirm' => false,
                //'return_url'=> 'http://3.142.144.214:3000/',
		//'return_url'=> 'https://kindness-omega.vercel.app/#',
            ]);
             
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntent' => $paymentIntent,
                'check' => 'this data',
            ];
            return response()->json($output);
            
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /** Calculate order total for stripe */
    public function calculateOrderAmount(array $items): int {
        // Replace this constant with a calculation of the order's amount
        // Calculate the order total on the server to prevent
        // people from directly manipulating the amount on the client
        foreach($items as $item){
            return $item->amount * 100;
        }
    }	



	
	public function payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'expmonth' => 'required',
            'expyear' => 'required',
            'cvc' => 'required'
        ]);

        if ($validator->fails()) {
           
			$response_code = 200;
			return response()->json([ $validator->errors()->first()], $response_code);
        }

        $token = $this->createToken($request);
		//echo "token---";print_r($token);

        $charge = $this->createCharge($token['id'], 2);
		
	
        if (!empty($charge) && $charge['status'] == 'succeeded') {
           
			$response_code = 200;
			return response()->json([ 'payment completed'], $response_code);
        } else {
			$response_code = 200;
			return response()->json([ 'payment failed'], $response_code);
        }       
    }

    private function createToken($cardData){
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['number'],
                    'exp_month' => $cardData['expmonth'],
                    'exp_year' => $cardData['expyear'],
                    'cvc' => $cardData['cvc']
                ]
            ]);
        } catch (CardException $e) {
           
			$response_code = 203;
			return response()->json([  $e->getError()->message], $response_code);
        } catch (Exception $e) {
            
			$response_code = 203;
			return response()->json([  $e->getMessage()], $response_code);
        }
        return $token;
    }

    private function createCharge($tokenId, $amount)
    {
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $tokenId,
                'description' => 'My first payment'
            ]); 
			
			
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }
}
