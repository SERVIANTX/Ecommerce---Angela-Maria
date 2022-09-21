<?php

class InformationController{

    /*===========================================================================================
        TODO: Login de Administradores
    ===========================================================================================*/

    public function saveData(){

        if(isset($_POST["idUser"])){

            $idUser = $_POST["idUser"];
            $clientOrder = $_POST["clientOrder"];
            $emailOrder = $_POST["emailOrder"];
            $cityOrder = $_POST["cityOrder"];
            $addressOrder = $_POST["addressOrder"];
            $infoOrder = $_POST["infoOrder"];
            $countryOrder = trim(explode("_",$_POST["countryOrder"])[0]);
            $phoneOrder = trim(explode("_",$_POST["countryOrder"])[1]."_".$_POST["phoneOrder"]);

            if(isset($_POST["addressAcepted"])){
                $addressAcepted = 1;
            }else{
                $addressAcepted = 0;
            }

            if(isset($_POST["phoneAcepted"])){
                $phoneAcepted = 1;
            }else{
                $phoneAcepted = 0;
            }

            if(isset($_POST["cityAcepted"])){
                $cityAcepted = 1;
            }else{
                $cityAcepted = 0;
            }

            if(isset($_POST["countryAcepted"])){
                $countryAcepted = 1;
            }else{
                $countryAcepted = 0;
            }


            $dataArray = array(
                    "idUser" => $idUser,
                    "clientOrder" => $clientOrder,
                    "emailOrder" => $emailOrder,
                    "cityOrder" => $cityOrder,
                    "phoneOrder" => $phoneOrder,
                    "addressOrder" => $addressOrder,
                    "countryOrder" => $countryOrder,
                    "infoOrder" => $infoOrder,
                    "addressAcepted" => $addressAcepted,
                    "phoneAcepted" => $phoneAcepted,
                    "cityAcepted" => $cityAcepted,
                    "countryAcepted" => $countryAcepted
            );
            setcookie("DataUserCheckout",json_encode($dataArray));

            echo '<script>window.location.replace("'.TemplateController::path().'checkout")</script>' ;

        }
    }
}

?>