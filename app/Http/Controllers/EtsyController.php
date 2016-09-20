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
    
        if (!array_key_exists('oauth_token', $_GET)) {
           //http://windows.php.net/downloads/pecl/releases/oauth/1.2.3/php_oauth-1.2.3-5.6-ts-vc11-x86.zip
            $oauth = new OAuth("ry2qdxt3vmbtbm4ifcxxhpci", "9acefgi98s");
            $oauth->disableSSLChecks();
            $req_token = $oauth->getRequestToken("https://openapi.etsy.com/v2/oauth/request_token?scope=email_r%20listings_r", 'http://localhost:82/laravel/index.php/etsy');

            return Redirect::away($req_token['login_url']);
        }else{
            $oauthtoken = $_GET['oauth_token'];
            $verifier = $_GET['oauth_verifier'];

        }


        //return $req_token['login_url'];
        //$token = $etsy->requestAccessToken($code);

        //Log::info('what the hell is going on');

        //oauth_token=97631af6e5d4525506d8455a0be31b&oauth_verifier=6642265a


        /*
        $whaturlisthis = "huh";
        $storage = new Session();
        // Setup the credentials for the requests
        $credentials = new Credentials(
            "ry2qdxt3vmbtbm4ifcxxhpci", 
            "9acefgi98s",
            $whaturlisthis 
        );
        // Instantiate the Etsy service using the credentials, http client and storage mechanism for the token
        // @var $etsyService Etsy 
        //$etsyService = $serviceFactory->createService('Etsy', $credentials, $storage);
        */





       // instantiate the OAuth object
        // OAUTH_CONSUMER_KEY and OAUTH_CONSUMER_SECRET are constants holding your key and secret
        // and are always used when instantiating the OAuth object 
       // $oauth = Auth\OAuth("ry2qdxt3vmbtbm4ifcxxhpci", "9acefgi98s");

        // make an API request for your temporary credentials
        //$req_token = $oauth->getRequestToken("https://openapi.etsy.com/v2/oauth/request_token?scope=email_r%20listings_r", 'oob');

        //print $req_token['login_url']."\n";

        //return $req_token['login_url'];
    }
    public function create()
    {
        
    }
    public function store(Request $request)
    {
      
    }
    public function show($id)
    {
      

    }
}