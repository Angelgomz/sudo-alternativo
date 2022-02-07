<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\User;
use Auth;
use DB;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function generateToken($user){
       // $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return [
            'id' => $token->id,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ];
    }
    public function crearUsuario($name,$email,$token){
        $ifExist = User::where('email','=',$email)->first();
        if(!$ifExist){
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $saved = $user->save();
        if($saved){
        Session::put('token',$token);
        Session::put('email', $email);
        Session::put('id',$user->id);
        Auth::login($user);
        $tokenAuth = $this->generateToken($user);
        Session::put('tokenLaravel',$tokenAuth);
        $success = true;
       
        }
        else{   
          $sucess = false;
        }
        }
        else{
            Session::put('token',$token);
            Session::put('email', $ifExist->email);
            Session::put('id',$ifExist->id);
            Auth::login($ifExist);
            $tokenAuth = $this->generateToken($ifExist);
            Session::put('tokenLaravel',$tokenAuth);
            $success = true;
        }
    
    }
    public function index(){
        $client = new \Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes([\Google_Service_Calendar::CALENDAR,\Google_Service_Oauth2::USERINFO_EMAIL]);
        $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].env('CREDENTIALS'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        if(empty($_GET['code'])){
        if ($client->isAccessTokenExpired()){ 
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $gauth = new \Google_Service_Oauth2($client);
                $email = $gauth->userinfo->get();
                return view('home');
            } else{
                $authUrl = $client->createAuthUrl();
                return view('layouts/login')->with('urlauth',$authUrl);
            }
        }
        else{
            $gauth = new \Google_Service_Oauth2($client);
            $email = $gauth->userinfo->get();
            return view('home');
            }
        }
        else{
            $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
            $client->setAccessToken($token);
            if (array_key_exists('error', $token)) {
                throw new Exception(join(', ', $token));
            }
            else{
                $gauth = new \Google_Service_Oauth2($client);
                $email = $gauth->userinfo->get();
                $name = $email->name;
                $email = $email->email;
                $this->crearUsuario($name,$email,$token['access_token']);
                $refreshtoken = $client->getRefreshToken();
                    if (!file_exists(dirname($tokenPath))) {
                        mkdir(dirname($tokenPath), 0700, true);
                    }
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                return view('home')->with('token',$refreshtoken);
            }
        }
    }
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $user = User::where('id',Session::get('id'))->first();
        $id_token = Session::all()['tokenLaravel']['id'];
        $token = DB::table('oauth_access_tokens')->where('id',$id_token)->update(['revoked'=>1]);
        unlink('token.json');
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    /**
     * Obtener el objeto User como json
     */
    
}
