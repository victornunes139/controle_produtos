<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User; 


class AuthController extends Controller 
{
    public function login(Request $request){ 
        $login = $request->validate([
            'email' => 'required|email', 
            'password' => 'required|string', 
        ]);
     

        if(!auth()->attempt($login)) {
            return response()->json([
                'success' => false,
                'message' => 'Dados de login incorretos!',
            ]);
        }

        $tokenLogin =  auth()->user()->createToken('Auth')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $tokenLogin
        ]);
    }

    // public function login(Request $request){ 
    //     $validator = Validator::make($request->all(), [ 
    //         'email' => 'required|email', 
    //         'password' => 'required|string', 
    //     ]);
    //     if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }
    //     if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) { 
    //         $user = Auth::user(); 
    //         $success['token'] =  $user->createToken('MyApp')->accessToken;
    //         $tokenResult = $user->createToken('token');
    //         $token = $tokenResult->token; 
    //         $token->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => $success,
    //         ]);
    //     } 
    //     else{ 
    //         return response()->json(['Dados Incorretos']); 

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Dados Incorretos',
    //         ]);
    //     } 
    // }

    public function register(Request $request) 
    { 
        $validateData = $request->validate([
            'name' => 'required|string', 
            'email' => 'required|email', 
            'password' => 'required|string', 
        ]);

        $validateData['password'] = bcrypt($request->password);
        $user = User::create($validateData);
        $token = $user->createToken('Auth')->accessToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Usuário Cadastrado!',
            'token' => $token
        ]);
    }

    // public function register(Request $request) 
    // { 
    //     $validator = Validator::make($request->all(), [ 
    //         'name' => 'required|string', 
    //         'email' => 'required|email', 
    //         'password' => 'required|string', 
    //     ]);
    //     if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }
    //     $user = $request->all(); 
    //     $user['password'] = bcrypt($user['password']); 
    //     $user = User::create($user); 
    //     $message['token'] = $user->createToken('MyApp')->accessToken; 
    //     $message['name'] =  $user->name;
    //     return response()->json(['success'=>$message], 200); 
    // }

    public function me() 
    { 
        $user = Auth::user(); 
        return response()->json($user, 200); 
    }

    public function logout(Request $request)
    {
        return "Função não implementada";
    }
}