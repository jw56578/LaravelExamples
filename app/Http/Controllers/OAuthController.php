<?php
namespace App\Http\Controllers;

use OAuth;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
the names of all these functions are specific. as defined in the documentation
*/
class OAuthController extends Controller
{
    public function getoauthconsumertoken()
    {
      session_start();
      $oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET);
      $oauth->disableSSLChecks();
      $req_token = $oauth->getRequestToken("https://openapi.etsy.com/v2/oauth/request_token?scope=email_r%20listings_r",
       'http://localhost:82/laravel/index.php/getoauthtoken');

      $oauth_token_secret = $req_token['oauth_token_secret'];
      $_SESSION["oauth_token_secret"] = $oauth_token_secret;
      return Redirect::away($req_token['login_url']);

    }
    public function getoauthtoken()
    {
       session_start();
       $request_token = $_GET['oauth_token'];
       $verifier = $_GET['oauth_verifier'];

       $request_token_secret = $_SESSION["oauth_token_secret"];
       $oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET);
       $oauth->disableSSLChecks();

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
    public function getetsyuser()
    {
        session_start();
        $access_token = $_SESSION["oauth_token"];
        $access_token_secret = $_SESSION["oauth_token_secret"] ;
        $oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET);
        $oauth->disableSSLChecks();
        $oauth->setToken($access_token, $access_token_secret);

        try {
            $data = $oauth->fetch("https://openapi.etsy.com/v2/users/jonwoo2", null, OAUTH_HTTP_METHOD_GET);
            $json = $oauth->getLastResponse();
            return $json;
            
        } catch (OAuthException $e) {
            error_log($e->getMessage());
            error_log(print_r($oauth->getLastResponse(), true));
            error_log(print_r($oauth->getLastResponseInfo(), true));
            exit;
        }

    }

}