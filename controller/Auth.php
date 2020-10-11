<?php
    require_once '../vendor/firebase/php-jwt/src/JWT.php';


    class Auth{
        private $secret_key = 'Sdw1s9x8@';
        private $encrypt = ['HS256'];
        private $aud = null;

        function __construct(){
            $this->jsonwebtoken=new Firebase\JWT\JWt();
        }

        public function SignIn($data){
            $time = time();

            $token = array(
                'exp' => $time + (60*60),
                'aud' => $this->Aud(),
                'data' => $data
            );

            return $this->jsonwebtoken->encode($token, $this->secret_key);
        }


        public function getData($token)
        {
            return $this->jsonwebtoken->decode(
                $token,
                $this->secret_key,
                $this->encrypt
            )->data;
        }

        private function Aud()
        {
            $aud = '';

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $this->aud = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $this->aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $this->aud = $_SERVER['REMOTE_ADDR'];
            }

            $this->aud .= @$_SERVER['HTTP_USER_AGENT'];
            $this->aud .= gethostname();

            return sha1($this->aud);
        }

        public function Check($token)
        {
            if(empty($token))
            {
                throw new Exception("Invalid token supplied.");
            }

            $decode = $this->jsonwebtoken->decode(
                $token,
                $this->secret_key,
                $this->encrypt
            );

            if(!empty($decode)){
                return true;
            }

            if($decode->aud !== $this->Aud())
            {
                throw new Exception("Invalid user logged in.");
            }
        }
    }

    $jwt= new Auth();

    $usuario  = 'eduardo';
    $password = '123456';
    if($usuario === 'eduardo' && $password === '123456')
    {
//        Se forma el token
//        $token= $jwt->SignIn([
//            'id' => 1,
//            'name' => 'Eduardo'
//        ]);

//        echo $jwt->Check($token);
//      Se decodifica y muestra la informacion
//        print_r($jwt->getData(
//            $token
//        ));
    }
