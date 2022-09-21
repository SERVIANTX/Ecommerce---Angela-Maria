<aside class="ps-block--store-banner">

    <div class="ps-block__user">

        <div class="ps-block__user-avatar">

            <?php if ($_SESSION["user"]->method_customer == "direct"): ?>

                <?php if ($_SESSION["user"]->picture_customer == ""): ?>

                    <img class="img-fluid rounded-circle ml-auto" style="height:auto" src="<?php echo TemplateController::srcImg() ?>views/img/customers/default/default.png">

                <?php else: ?>

                    <img class="img-fluid rounded-circle ml-auto" style="height:auto" src="<?php echo TemplateController::srcImg() ?>views/img/customers/<?php echo $_SESSION["user"]->id_customer ?>/<?php echo $_SESSION["user"]->picture_customer ?>">

            <?php endif ?>

            <?php else: ?>

                <?php if (explode("/", $_SESSION["user"]->picture_customer)[0] == "https:"): ?>

                    <img class="img-fluid rounded-circle ml-auto" style="height:auto" src="<?php echo $_SESSION["user"]->picture_customer ?>">

                <?php else: ?>

                    <img class="img-fluid rounded-circle ml-auto" style="height:auto" src="<?php echo TemplateController::srcImg() ?>views/img/customers/<?php echo $_SESSION["user"]->id_customer ?>/<?php echo $_SESSION["user"]->picture_customer ?>">

            <?php endif ?>


            <?php endif ?>


            <div class="br-wrapper">

                <button class="btn btn-primary btn-lg rounded-circle" data-toggle="modal"
                    data-target="#changePicture"><i class="fas fa-pencil-alt"></i></button>

            </div>

        </div>

        <div class="ps-block__user-content text-center text-lg-left">

            <h2 class="text-white"><?php echo $_SESSION["user"]->displayname_customer ?></h2>

            <p><i class="fas fa-user"></i> <?php echo $_SESSION["user"]->username_customer ?></p>

            <p><i class="fas fa-envelope"></i> <?php echo $_SESSION["user"]->email_customer ?></p>

            <?php if ($_SESSION["user"]->method_customer == "direct"): ?>

            <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#changePassword">Cambiar contraseña</button>

            <?php endif ?>

        </div>

    </div>

</aside><!-- s -->




<!--=====================================================
    TODO: Ventana modal para cambiar contraseña
======================================================-->

<!-- The Modal -->
<div class="modal" id="changePassword">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form method="post" class="ps-form--account ps-tab-root needs-validation" novalidate>

                    <div class="form-group form-forgot">

                        <input class="form-control" type="password" placeholder="Password"
                            pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}"
                            onchange="validateJS(event, 'password')" name="changePassword" required>

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill in this field correctly.</div>

                    </div>

                    <?php

                        $change = new UsersController();
                        $change -> changePassword();

                    ?>

                    <div class="form-group submtit">

                        <button type="submit" class="ps-btn ps-btn--fullwidth">Submit</button>

                    </div>


                </form>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>



<!--=====================================================
    TODO: Ventana modal para cambiar fotografía
======================================================-->

<!-- The Modal -->
<div class="modal" id="changePicture">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Picture</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form method="post" class="ps-form--account ps-tab-root needs-validation" novalidate
                    enctype="multipart/form-data">

                    <small class="helsmall-block small">Dimensions: 200px * 200px | Max Size. 2MB | Format: JPG o PNG
                        </p>

                        <div class="custom-file">

                            <input type="file" class="custom-file-input" id="customFile" accept="image/*"
                                maxSize="2000000" name="changePicture"
                                onchange="validateImageJS(event, 'changePicture')" required>

                            <label for="customFile" class="custom-file-label">Choose file</label>

                        </div>

                        <figure class="text-center py-3">

                            <img src="" class="img-fluid rounded-circle changePicture" style="width:150px">

                        </figure>

                        <?php

                            $changePicture = new UsersController();
                            $changePicture -> changePicture();

                        ?>

                        <div class="form-group submtit">

                            <button type="submit" class="ps-btn ps-btn--fullwidth">Submit</button>

                        </div>


                </form>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>