<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
   
class AuthController extends BaseController
{
    public function login(Request $request){
		try {
			
			$validateUser = Validator::make($request->all(), 
				[
					'email' => 'required|email',
					'password' => 'required'
				]
			);

			if($validateUser->fails()){
				return $this->sendError('Validation Error', $validateUser->errors());   
			}

			if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
				$authUser = Auth::user(); 
				$success['token'] =  $authUser->createToken($request->email)->plainTextToken; 
				$success['name'] =  $authUser;

				return $this->sendResponse($success, 'User Logged In Successfully');
				
			}else{ 
				return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
			}
			
		} catch (\Throwable $th) {
			return $this->sendError('Unauthorised.', ['error'=>$th->getMessage()]);
        }
		
		
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User created successfully.');
    }
   
}