<?php

    require_once "../controllers/curl.controller.php";

    class ValidateController{

        /* public $data;
        public $table; */
        public $token;

        public function dataRepeat(){

            /* $url = $this->table."?select=".$this->suffix."&linkTo=".$this->suffix."&equalTo=".urlencode($this->data); */
            $url = "users?select=id_user,wishlist_user&linkTo=token_user&equalTo=".$this->token;
            $method = "GET";
            $fields = array();

            $response = CurlController::request2($url, $method, $fields);

            echo $response->status;

        }

    }

    if(isset($_POST["token"])){

        $validate = new ValidateController();
        $validate -> token = $_POST["token"];
        $validate -> dataRepeat();

    }

?>