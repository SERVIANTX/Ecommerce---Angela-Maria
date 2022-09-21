<?php

if(isset($_POST["idUser"])){

    echo '<script>

            matPreloader("on");
            fncSweetAlert("loading", "Loading...", "");

        </script>';

    /*================================================================
        TODO: Validación de lado del servidor
    ================================================================*/

    if( preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["clientName"] ) &&
        preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["clientCity"] ) &&
        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["clientAddress"] ) &&
        preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["clientPhone"] )){


        /*=============================================
            TODO: Agrupamos la información
        =============================================*/

        $data = "displayname_customer=".trim(TemplateController::capitalize($_POST["clientName"]))."&country_customer=".trim(explode("_",$_POST["clientCountry"])[0])."&city_customer=".trim(TemplateController::capitalize($_POST["clientCity"]))."&address_customer=".trim($_POST["clientAddress"])."&phone_customer=".urlencode(trim(explode("_",$_POST["clientCountry"])[1]."_".$_POST["clientPhone"]))."&date_updated_customer=".date("Y-m-d");

        /*=============================================
            TODO: Solicitud a la API
        =============================================*/
        $id = $_POST["idUser"];
        $url = CurlController::api()."customers?id=".$id."&nameId=id_customer&token=".$_SESSION["user"]->token_customer."&table=customers&suffix=customer";
        $method = "PUT";
        $fields = $data;
        $headers = array();

        $response = CurlController::request($url, $method, $fields, $headers);
        /*=============================================
            TODO: Respuesta de la API
        =============================================*/

        if($response->status == 200){

            echo '<script>

                    fncFormatInputs();
                    matPreloader("off");
                    fncSweetAlert("close", "", "");
                    fncSweetAlert("success", "Sus registros fueron actualizados con éxito.");

                </script>';
            echo '<script>

            window.location = "/account&edit-information";

            </script>';

        }else{

            echo '<script>

                    fncFormatInputs();
                    matPreloader("off");
                    fncSweetAlert("close", "", "");
                    fncNotie(3, "Error al editar el registro.");

                </script>';

        }

    }

    }
    else{
        echo '<script>

                    fncFormatInputs();
                    matPreloader("off");
                    fncSweetAlert("close", "", "");
                    fncNotie(3, "Error al editar el registro.");

                </script>';
    }

?>