<?php
namespace App\Http\Controllers;

//use Auth;

//use ohmy\Auth1;
use OAuth;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Meal;

//use OAuth\OAuth1\Service\Etsy;
//use OAuth\Common\Storage\Session;
//use OAuth\Common\Consumer\Credentials;
use Illuminate\Support\Facades\Log;
/*
The Etsy API uses OAuth 1.0 to give developers access to an Etsy member's private account data. The OAuth approach is three-legged:
*/
class EtsyController extends Controller
{
    public function index()
    {
        session_start();

        if (!array_key_exists('oauth_token', $_GET)) {
           //http://windows.php.net/downloads/pecl/releases/oauth/1.2.3/php_oauth-1.2.3-5.6-ts-vc11-x86.zip
            $oauth = new OAuth("ry2qdxt3vmbtbm4ifcxxhpci", "9acefgi98s");
            //http://stackoverflow.com/questions/14566864/peer-certificate-cannot-be-authenticated-with-known-ca-certificates-using-php-oa
            $oauth->disableSSLChecks();
            $req_token = $oauth->getRequestToken("https://openapi.etsy.com/v2/oauth/request_token?scope=email_r%20listings_r", 'http://localhost:82/laravel/index.php/etsy');

            Log::info( print_r( $req_token, true ) );
            //this thing is what needs to be saved so that it can be used in another step 
            $oauth_token_secret = $req_token['oauth_token_secret'];
            $_SESSION["oauth_token_secret"] = $oauth_token_secret;
            return Redirect::away($req_token['login_url']);
        }else{
            // get temporary credentials from the url
            $request_token = $_GET['oauth_token'];

            // get the temporary credentials secret - this assumes you set the request secret  
            // in a cookie, but you may also set it in a database or elsewhere
            $request_token_secret = $_SESSION["oauth_token_secret"];

            // get the verifier from the url
            $verifier = $_GET['oauth_verifier'];

            $oauth = new OAuth("ry2qdxt3vmbtbm4ifcxxhpci", "9acefgi98s");
            $oauth->disableSSLChecks();
            // set the temporary credentials and secret
            $oauth->setToken($request_token, $request_token_secret);

            try {
                // set the verifier and request Etsy's token credentials url
                $acc_token = $oauth->getAccessToken("https://openapi.etsy.com/v2/oauth/access_token", null, $verifier);
                //these are the special values that will be used for all the api calls
                //need to save these somewhere
                $oauth_token = $acc_token["oauth_token"];
                $oauth_token_secret = $acc_token["oauth_token_secret"];
                $_SESSION["oauth_token"] = $oauth_token;
                $_SESSION["oauth_token_secret"] = $oauth_token_secret;
                return "success, you can now call apis";

            } catch (OAuthException $e) {
                error_log($e->getMessage());
            }



        }
    }
    public function create()
    {
        //just puttting this here for now
        session_start();
        $access_token = $_SESSION["oauth_token"];
        $access_token_secret = $_SESSION["oauth_token_secret"] ;

        $oauth = new OAuth("ry2qdxt3vmbtbm4ifcxxhpci", "9acefgi98s",
                        OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI); //these are built in constants to the OAuth package
        $oauth->disableSSLChecks();
        $oauth->setToken($access_token, $access_token_secret);

        try {
            $data = $oauth->fetch("https://openapi.etsy.com/v2/users/jonwoo2", null, OAUTH_HTTP_METHOD_GET);
            $json = $oauth->getLastResponse();
            return print_r(json_decode($json, true));
            
        } catch (OAuthException $e) {
            error_log($e->getMessage());
            error_log(print_r($oauth->getLastResponse(), true));
            error_log(print_r($oauth->getLastResponseInfo(), true));
            exit;
        }



        return $oauth_token . "     secret= "  .  $oauth_token_secret;
    }
    public function store(Request $request)
    {
      
    }
    public function show($id)
    {
      

    }
}