<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login With Google</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
        }
        .login-btn {
            background-color: #4285F4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-btn:hover {
            background-color: #3a77d6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login With Google</h2>
        <?php
        require_once 'vendor/autoload.php';

        $ClientID='948842330293-l6p30o080vsmqoqlferjuahcil7ieq4h.apps.googleusercontent.com';
        $ClientSecret='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';
        $redirectURL='http://journeyinghearts.live/oAuth/oAuth_login.php';

        //Creating Client Request to Google
        $client = new Google_Client();
        $client->setClientId($ClientID);
        $client->setClientSecret($ClientSecret);
        $client->setRedirectUri($redirectURL);
        $client->addScope('profile');
        $client->addScope('email');

        if(isset($_GET['code'])){ 
            $token=$client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            //Getting User profile
            $gauth = new Google_Service_Oauth2($client);
            $google_info = $gauth->userinfo->get();
            $email = $google_info->email;
            $name = $google_info->name;

            header('Location: /src/php/home.php');
            exit;
        } else { 
            echo "<a class='login-btn' href='".$client->createAuthUrl()."'>Login With Google</a>";  
        }
        ?>
   </div>
</body>
</html>
