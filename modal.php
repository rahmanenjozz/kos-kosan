<!-- Modal Login-->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="login.php" method="POST" method="POST">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sign in</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5 form-group">
                    <i class="fa fa-user prefix grey-text"></i>
                    <input type="text" id="defaultForm-name" class="form-control validate" required="" name="username">
                    <label data-error="wrong" data-success="right" for="defaultForm-name">Username</label>
                </div>

                <div class="md-form mb-4 form-group">
                    <i class="fa fa-lock prefix grey-text"></i>
                    <input type="password" id="defaultForm-pass" class="form-control validate" required="" name="password">
                    <label data-error="wrong" data-success="right" for="defaultForm-pass">Your password</label>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="__" value="Login">Login</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Register-->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="daftar.php" method="POST" method="POST">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sign up</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <i class="fa fa-vcard prefix grey-text"></i>
                    <input type="text" id="dorangeForm-name" class="form-control validate" required="" name="nama">
                    <label data-error="wrong" data-success="right" for="dorangeForm-name">Nama Lengkap</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fa fa-user prefix grey-text"></i>
                    <input type="text" id="orangeForm-name" class="form-control validate" required="" name="username">
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Username</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fa fa-lock prefix grey-text"></i>
                    <input type="password" id="orangeForm-pass" class="form-control validate" required="" name="password">
                    <label data-error="wrong" data-success="right" for="orangeForm-pass">Your password</label>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="__" value="Daftar">Sign up</button>
            </div>
            </form>
        </div>
    </div>
</div>