<?php
    namespace App\Models\framework;
    require_once app_path().'/Libraries/Facebook/FacebookSocial/autoload.php';
    use Facebook;
    use DB;
    use App\Usuario;

    class GestorUsuarios{
        var $fb;
        var $CRED_FACEBOOK_ID='120837944930073';
        var $CRED_FACEBOOK_SECRET='b54135e8f349147d055575d344382fa4';
        var $CRED_FACEBOOK_DEFAULTGRAPHVERSION='v2.2';
        function _construct(){

        }


        function getFacebookLoginURLforRegistry(){
          session_start();
         $this->fb = new Facebook\Facebook([
              'app_id' => $this->CRED_FACEBOOK_ID,
              'app_secret' => $this->CRED_FACEBOOK_SECRET
            ]);
            $helper = $this->fb->getRedirectLoginHelper();

            $permissions = ['email','user_birthday','user_location']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(action("UsuarioController@criarUsuarioFromFacebook"), $permissions);
            foreach ($_SESSION as $k=>$v) {
                if(strpos($k, "FBRLH_")!==FALSE) {
                    if(!setcookie($k, $v)) {
                        //what??
                    } else {
                        $_COOKIE[$k]=$v;
                    }
                }
            }
            session_write_close();
            return $loginUrl;
        }
        function getFacebookLoginURLforLogin(){
          session_start();
         $this->fb = new Facebook\Facebook([
              'app_id' => $this->CRED_FACEBOOK_ID,
              'app_secret' => $this->CRED_FACEBOOK_SECRET
            ]);
            $helper = $this->fb->getRedirectLoginHelper();

            $permissions = ['email','user_birthday','user_location']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(action("AuthController@postLoginFromFacebook"), $permissions);
            foreach ($_SESSION as $k=>$v) {
                if(strpos($k, "FBRLH_")!==FALSE) {
                    if(!setcookie($k, $v)) {
                        //what??
                    } else {
                        $_COOKIE[$k]=$v;
                    }
                }
            }
            session_write_close();
            return $loginUrl;
        }

    function checkIfUserExists($user){


    }

    function loginUsuarioFromFacebook(){
        session_start();

            foreach ($_COOKIE as $k=>$v) {
            if(strpos($k, "FBRLH_")!==FALSE) {
                $_SESSION[$k]=$v;
            }
        }

          $this->fb = new Facebook\Facebook([
          'app_id' => $this->CRED_FACEBOOK_ID,
          'app_secret' => $this->CRED_FACEBOOK_SECRET
          ]);

            $helper = $this->fb->getRedirectLoginHelper();
            try {
              $accessToken = $helper->getAccessToken();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              exit;
            }

            if (! isset($accessToken)) {
              if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
              } else {
                header('HTTP/1.0 400 Bad Request');
              }
              exit;
            }



            $oAuth2Client = $this->fb->getOAuth2Client();

            // Get the access token metadata from /debug_token
            $tokenMetadata = $oAuth2Client->debugToken($accessToken);


            // Validation (these will throw FacebookSDKException's when they fail)
            $tokenMetadata->validateAppId($this->CRED_FACEBOOK_ID);
            // If you know the user ID this access token belongs to, you can validate it here

            $tokenMetadata->validateExpiration();

            if (! $accessToken->isLongLived()) {
              // Exchanges a short-lived access token for a long-lived one
              try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
              } catch (Facebook\Exceptions\FacebookSDKException $e) {

                exit;
              }

            }else{

            }

            $_SESSION['fb_access_token'] = (string) $accessToken;

            try {
              // Returns a `Facebook\FacebookResponse` object
              //get user info
              $response = $this->fb->get('/me?fields=id,name,email,first_name,last_name,middle_name,link,birthday,location,updated_time,verified', $accessToken);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //  echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
           //   echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }

            $user = $response->getGraphUser();
            $usuario=new Usuario();
            $usuario->nome=$user['name'];
            $usuario->email=$user['email'];
            $usuario->senha=$user['email'].$user['name'];
            //check if exists
            if(Usuario::where('email', '=',  $usuario->email)->exists()){
               $usuario= Usuario::where('email', '=',  $usuario->email)->first();
                return array("usuario"=>$usuario,"goreset"=>0);
            }else{
                $usuario->remember_token="";
                $usuario->save();
                if(Usuario::where('nome', '=', $usuario->nome)->where('email', '=',  $usuario->email)->exists()){
                   $usuario= Usuario::where('nome', '=', $usuario->nome)->where('email', '=',  $usuario->email)->first();
                    return array("usuario"=>$usuario,"goreset"=>1);//array
                }else{
                    return null;
                }
            }

            session_write_close();
    }
    function criarUsuarioFromFacebook(){

        session_start();

            foreach ($_COOKIE as $k=>$v) {
            if(strpos($k, "FBRLH_")!==FALSE) {
                $_SESSION[$k]=$v;
            }
        }




            $this->fb = new Facebook\Facebook([
          'app_id' => $this->CRED_FACEBOOK_ID,
          'app_secret' => $this->CRED_FACEBOOK_SECRET
          ]);

            $helper = $this->fb->getRedirectLoginHelper();
            //echo $helper;
            try {
              $accessToken = $helper->getAccessToken();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              // When Graph returns an error
              //echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              // When validation fails or other local issues
            //  echo 'Facebook SDK returned an error: ' . $e->getMessage();
             // var_dump($fb);
              exit;
            }

            if (! isset($accessToken)) {
              if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
              //  echo "Error: " . $helper->getError() . "\n";
               // echo "Error Code: " . $helper->getErrorCode() . "\n";
               // echo "Error Reason: " . $helper->getErrorReason() . "\n";
              //  echo "Error Description: " . $helper->getErrorDescription() . "\n";
              } else {
                header('HTTP/1.0 400 Bad Request');
              //  echo 'Bad request';
              }
              exit;
            }

            // Logged in
           // echo '<h3>Access Token</h3>';
          //  var_dump($accessToken->getValue());

            // The OAuth 2.0 client handler helps us manage access tokens
            $oAuth2Client = $this->fb->getOAuth2Client();

            // Get the access token metadata from /debug_token
            $tokenMetadata = $oAuth2Client->debugToken($accessToken);
          //  echo '<h3>Metadata</h3>';
            //var_dump($tokenMetadata);

            // Validation (these will throw FacebookSDKException's when they fail)
            $tokenMetadata->validateAppId($this->CRED_FACEBOOK_ID);
            // If you know the user ID this access token belongs to, you can validate it here
            //$tokenMetadata->validateUserId('123');
            $tokenMetadata->validateExpiration();

            if (! $accessToken->isLongLived()) {
              // Exchanges a short-lived access token for a long-lived one
              try {
             //   echo "entre";
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
              //  echo "passee";
              } catch (Facebook\Exceptions\FacebookSDKException $e) {
              //  echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
              }

             // echo '<h3>Long-lived</h3>';
            //  var_dump($accessToken->getValue());
            }else{
              //  echo "no es long lived";
            }

            $_SESSION['fb_access_token'] = (string) $accessToken;

            try {
              // Returns a `Facebook\FacebookResponse` object
              //get user info
              $response = $this->fb->get('/me?fields=id,name,email,first_name,last_name,middle_name,link,birthday,location,updated_time,verified', $accessToken);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //  echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
           //   echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }

            $user = $response->getGraphUser();
            $usuario=new Usuario();
            $usuario->nome=$user['name'];
            $usuario->email=$user['email'];
            $usuario->senha=$user['email'].$user['name'];
            $usuario->remember_token="";
            $usuario->save();

            if(Usuario::where('nome', '=', $usuario->nome)->where('email', '=',  $usuario->email)->exists()){
               $usuario= Usuario::where('nome', '=', $usuario->nome)->where('email', '=',  $usuario->email)->first();
                return $usuario;
            }else{
                return null;
            }

            session_write_close();

}



    }

?>
