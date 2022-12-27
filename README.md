#Laravel 9 Passport Authentication

What is Laravel Passport? Laravel Passport is an OAuth 2.0 server implementation for API authentication using Laravel. Since tokens are generally used in API authentication, Laravel Passport provides an easy and secure way to implement token authorization on an OAuth 2.0 server.

#Passport Or Sanctum?

Before getting started, you may wish to determine if your application would be better served by Laravel Passport or Laravel Sanctum. If your application absolutely needs to support OAuth2, then you should use Laravel Passport.

However, if you are attempting to authenticate a single-page application, mobile application, or issue API tokens, you should use Laravel Sanctum. Laravel Sanctum does not support OAuth2; however, it provides a much simpler API authentication development experience.

###You have to follow the steps for passport api authentication

#Step 1 Create new laravel application

````
composer create-project laravel laravel {YOUR APPLICATION NAME}
````

#Step 2: set up database in your .env file

````
DB_DATABASE={DATABASE NAME}
DB_USERNAME=root
DB_PASSWORD=
````

#Step 3: Run migrations
 ####Go inside your application by cd {APP NAME}
 ####Run your migrations

 ````
 php artisan migrate
 ````

 #Step 3 install passport
####It will create migration keys for secure authentication
 ````
 php artisan passport:install
 ````

 ###Follow this step [IMPORTANT]

 #Step 4
######Add the Laravel\Passport\HasApiTokens trait to your App\Models\User model. 

####Laravel\Sanctum\HasApiTokens
##To
####Laravel\Passport\HasApiTokens

#Step 5
#####Finally, in your application's config/auth.php configuration file, you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:

````
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
 
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
````

##Your passport is successfully installed and setup

Now you have to make routes and methods for authentication

###Routes in routes/api.php

````
<!-- register route -->
Route::post('register',[Icontroller::class,'register']);

<!-- login route -->
Route::post('login',[Icontroller::class,'login']);

<!-- route protected by  config/auth.php  'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],-->
Route::middleware('auth:api')->group(function(){
    Route::get('userinfo',[Icontroller::class,'userInfo']);
});
````

#Methods in Controller

````
<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Auth;
use Hash;

class Icontroller extends Controller
{
    // register function
    function register(Request $request){

        // requesting feilds from api
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>\Hash::make($request->password)
        ]);

        $token=$user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token],200);
    }

    // login function
    function login(Request $request){
        $data=[
            'email'=>$request->email,
            'password'=>$request->password
        ];
        if(Auth::attempt($data))
        {
            $token=Auth::user()->createToken('Token')->accessToken;
            return response()->json(['token'=>$token],200);
        }
        else{
            return response()->json(['error'=>'auth not found']);
        }
    }

    // user info function
    function userinfo(){
        $user=Auth::user();
        return response()->json(['users'=>$user]);
    }
}
````


#####Have a nice day ahead :)




