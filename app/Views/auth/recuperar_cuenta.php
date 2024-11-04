<?php echo $this->extend('auth/login_template') ?>
<?php echo $this->section('login-panel') ?>
<div class="col-12 col-md-6">
    <div class="card border-0 my-5 rounded-0">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">¿Olvidaste tu contraseña?</h1>
                    <p>Te ayudamos a recuperarla</p>
                </div>
                <?= session()->getFlashdata('error') ?>
                <?= session()->getFlashdata('message') ?>
                <form class="user" action="<?php echo base_url('password/email'); ?>" method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user"
                            id="exampleInputEmail" aria-describedby="emailHelp"
                            placeholder="Escribe tu correo de inicio" name="email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Recuperar Contraseña
                    </button>
                    <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                        <i class="fab fa-google fa-fw"></i> Login with Google
                    </a> -->
                    <!--<a href="index.html" class="btn btn-facebook btn-user btn-block">
                        <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a>  -->
                    
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="<?php echo base_url('crear_cuenta'); ?>">Crear una cuenta</a>
                </div>
                <div class="text-center">
                    <a class="small" href="<?php echo base_url('/'); ?>">Entrar a mi cuenta</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection()?>