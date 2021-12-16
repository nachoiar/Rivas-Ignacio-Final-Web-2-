<?php


class AuthHelper{

    function __construct(){
    }

    function checkLogin(){
        $logueado = 0;
        session_start();
        if(!isset($_SESSION["Dniusuario"])){
         $logueado = 1;
         $dniLogueado =$_SESSION['Dniusuario'];
        }
        return $logueado;
        return $dniLogueado;
    }

}