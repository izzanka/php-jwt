<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Session {

    public function __construct(public string $username, public string $role){

    }

}

class SessionManager {

    public static string $SECRET_KEY = "secret_key";
    public static array $COOKIE_OPTIONS = ['expires' => 0,'path' => "",'domain' => "",'secure' => true,'httponly'=> true,'samesite' => ""];

    public static function login(string $username, string $password): bool
    {
        if ($username == "izzan" && $password == "izzan") {
            
            $payload = [
                'username' => $username,
                'role' => 'customer'
            ];

            $jwt = JWT::encode($payload,SessionManager::$SECRET_KEY,'HS256');

            setcookie("X-JWT-SESSION",$jwt,SessionManager::$COOKIE_OPTIONS);

            return true;

        } else {

            return false;

        }
    }

    public static function getCurrentSession(): Session {

        if ($_COOKIE['X-JWT-SESSION']) {

            $jwt = $_COOKIE['X-JWT-SESSION'];

            try {

                $payload = JWT::decode($jwt,new Key(SessionManager::$SECRET_KEY,'HS256'));

                return new Session(username: $payload->username, role: $payload->role);

            } catch (Exception $exception) {

                throw new Exception("User is not login");

            }
           
        }else{
            
            throw new Exception("User is not login");

        }

    }

}