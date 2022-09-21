<div class="ps-newsletter">

    <div class="container">

        <form class="ps-form--newsletter needs-validation" novalidate method="post">

            <div class="row">

                <div class="col-xl-5 col-12 ">
                    <div class="ps-form__left">
                        <h3>Boletín de noticias</h3>
                        <p>Suscríbase para recibir información sobre productos y ofertas.</p>
                    </div>
                </div>

                <div class="col-xl-7 col-12 ">

                    <div class="ps-form__right">

                        <div class="form-group--nest">

                            <div class="jr">

                                <input
                                    type="email"
                                    placeholder="Ingresa tu correo"
                                    class="form-control"
                                    pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
                                    onchange="validateRepeat(event,'email','subscribers','email_subscriber')"
                                    name="regEmailSubs"
                                    required>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>



                            <?php

                                $register = new SubscribersController();
                                $register -> register();

                            ?>

                            <button type="submit" class="ps-btn">Suscribirme</button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<style>

@media (min-width: 768px) {
    .jr {
        width: 1000px;
    }
}

</style>