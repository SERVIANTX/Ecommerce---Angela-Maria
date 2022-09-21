<!--=====================================================
    TODO: Breadcrumb
======================================================-->

<div class="ps-breadcrumb">

    <div class="container">

        <ul class="breadcrumb">

            <li><a href="/">Home</a></li>

            <li>Mi cuenta</li>

        </ul>

        <?php if (isset($_SESSION["user"])): ?>

        <a href="<?php echo $path ?>account&logout" class="float-right">Cerrar sesión</a>

        <?php endif ?>

    </div>

</div>

<?php

    if(isset($urlParams[1])){
      
        if( $urlParams[1] == "enrollment" ||
            $urlParams[1] == "login" ||
            $urlParams[1] == "wishlist" ||
            $urlParams[1] == "my-shopping" ||
            $urlParams[1] == "detail-ordes" ||
            $urlParams[1] == "edit-information" ||
            $urlParams[1] == "logout"
        ){

            /*=========================================================
                TODO: Filtrar el Ingreso con redes sociales
            =========================================================*/

            if(isset($urlParams[2])){

                if($urlParams[2] == "facebook" || $urlParams[2] == "google"){

                    $url = $path."account&enrollment&".$urlParams[2];

                    $response = UsersController::socialConnect($url, $urlParams[2]);

                }

            }

            include $urlParams[1]."/".$urlParams[1].".php";

        }else{

            echo '<script>

                    window.location = "'.$path.'";

                </script>';
        }

    }else{

        echo '<script>

                window.location = "'.$path.'";

            </script>';

    }

?>