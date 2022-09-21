<?php

    session_destroy();

    echo '<script>

            localStorage.removeItem("token_customer");

            window.location = "'.$path.'account&login";

        </script>';

?>

