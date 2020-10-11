<?php

require_once './Auth.php';

class Usuarios extends  Auth{
    public function __construct()
    {
        $this->auth= new Auth;
    }

    function Login($email,$password,$level){
        try {
            if($email==='test@gmail.com' && $password==='12345'){
                $token=$this->auth->SignIn([
                    'email'=>$email,
                    'level'=>$level
                ]);

                return $token;
            }else{
                return false;
            }
        }catch (Exception $th){
            echo $th->getMessage();
        }
    }

    function getUsers($token){
        try {
            if(empty($token)){
                echo 'No hay token';
            }
            $check=$this->auth->Check($token);
            if($check){
                echo 'Mostramos los usuarios';
            }else{
                return false;
            }
        }catch (Exception $th){
            return $th->getMessage();
        }
    }
}

$usuario= new Usuarios();

echo 'Token: '.$verify=$usuario->Login('test@gmail.com','12345','6').'</br>';

if(!$verify) {
//    Puede retornar al dashboard
   echo  'Credentials not found </br>';
}

echo $users=$usuario->getUsers('');

