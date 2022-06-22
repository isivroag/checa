<?php
    class conn{
        
        function connect(){
        
            define('servidor','tecniem.com');
            define('bd_nombre','tecniemc_checa');
            define('usuario','tecniemc_ivan');
            define('password','66obispo.colima');

            $opciones=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try{
                $conexion=new PDO("mysql:host=".servidor.";dbname=".bd_nombre, usuario,password, $opciones);
                return $conexion;
            }catch(Exception $e){
                return null;
            }
        }
    }
?>