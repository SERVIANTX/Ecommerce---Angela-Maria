
<footer class="ps-footer">

<div class="container">

    <div class="ps-footer__widgets">

        <!--=====================================================
            TODO: Contact us
        ======================================================-->

        <aside class="widget widget_footer widget_contact-us">

            <h4 class="widget-title">Contacto con nosotros</h4>

            <div class="widget_content">

                <p>Llámenos a las 24/7</p>
                <h3><?php echo $celular->value_extrasetting ?></h3>
                <p><?php echo $direccion->value_extrasetting ?> <br>
                    <a href="mailto:<?php echo $emailAM ?>"><?php echo $emailAM ?></a>
                </p>

                <ul class="ps-list--social">
                    <li><a class="facebook" href="<?php echo $facebook->value_extrasetting ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a class="instagram" href="<?php echo $instagram->value_extrasetting ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a class="twitter" href="<?php echo $whatsapp->value_extrasetting ?>" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                </ul>

            </div>

        </aside>

        <!--=====================================================
            TODO: Quick Links
        ======================================================-->

        <aside class="widget widget_footer">

            <h4 class="widget-title">Enlaces rápidos</h4>

            <ul class="ps-list--link">

                <li><a href="<?php echo $path ?>politicas-de-privacidad">Políticas de Privacidad</a></li>

                <li><a href="<?php echo $path ?>terminos-condiciones">Terminos &amp; Condiciones</a></li>

                <li><a href="<?php echo $path ?>condiciones-de-promociones">Condiciones de Promociones</a></li>

            </ul>

        </aside>

        <!--=====================================================
            TODO: Company
        ======================================================-->

        <aside class="widget widget_footer">

            <h4 class="widget-title">Empresa</h4>

            <ul class="ps-list--link">

                <li><a href="https://landing.e-angelamaria.me/" target="_blank">Acerca de la empresa</a></li>

                <li><a href="tel:<?php echo $celular->value_extrasetting ?>">Contacto</a></li>

                <li><a href="/aviso-cookies">Aviso de Cookies</a></li>

            </ul>

        </aside>

        <!--=====================================================
            TODO: Bussiness
        ======================================================-->

        <aside class="widget widget_footer">

            <h4 class="widget-title">Cuenta</h4>

            <ul class="ps-list--link">

                <li><a href="/shopping-cart">Mi carrito</a></li>

                <li><a href="/account&wishlist">Mi cuenta</a></li>

                <li><a href="/account&my-shopping">Mis compras</a></li>

            </ul>

        </aside>

    </div>

    <!--=====================================================
        TODO: Categories Footer
    ======================================================-->

    <div class="ps-footer__links">

        <?php foreach ($menuCategories as $key => $value): ?>

        <p>
            <strong><?php echo $value->name_category ?></strong>

            <!--=====================================================
                TODO: Traer las subcategorías
            ======================================================-->

            <?php

                $url = CurlController::api()."subcategories?linkTo=id_category_subcategory&equalTo=".rawurlencode($value->id_category)."&select=url_subcategory,name_subcategory";
                $method = "GET";
                $fields = array();
                $header = array();

                $menuSubcategories = CurlController::request($url, $method, $fields, $header)->results;

            ?>

            <?php foreach ($menuSubcategories as $key => $value): ?>

                <a href="<?php echo $path.$value->url_subcategory ?>"><?php echo $value->name_subcategory ?></a>

            <?php endforeach ?>

        </p>

        <?php endforeach ?>

    </div>

    <!--=====================================================
        TODO: CopyRight - Payment method Footer
    ======================================================-->

    <div class="ps-footer__copyright">

        <p>Copyright © <?php echo date("Y") ?> <a href="/">Angela Maria</a>. Todos los derechos reservados</p>

        <p>
            <span>Utilizamos el pago seguro para:</span>

            <a>
                <img src="assets/img/payment-method/mp_logo.png" height="25" width="55" alt="">
            </a>

            <a>
                <img src="assets/img/payment-method/paypal_logo.png" height="25" width="55" alt="">
            </a>

            <a>
                <img src="assets/img/payment-method/1.jpg" alt="">
            </a>

            <a>
                <img src="assets/img/payment-method/3.jpg" alt="">
            </a>

            <a>
                <img src="assets/img/payment-method/5.jpg" alt="">
            </a>

        </p>

    </div>

</div>

</footer>