<?php echo $this->extend('auth/login_template') ?>
<?php echo $this->section('login-panel') ?>
<div class="col-12 col-md-6">
    <div class="card border-0 my-5 rounded-0">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
                <div class="text-center">
                    <h1><center>MBI</center></h1>
                    <h1 class="h4 text-gray-900 mb-4">¡Bienvenido nuevamente!</h1>
                </div>
                <form class="user" method="POST" action="<?php echo base_url('entrar'); ?>">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user"
                            id="exampleInputEmail" aria-describedby="emailHelp"
                            placeholder="Escribe tu correo" name="correo">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user"
                            id="exampleInputPassword" placeholder="Contraseña" name="password">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Recuerdame</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Entrar
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
                    <a class="small" href="<?php echo base_url('recuperar'); ?>">¿Olvidaste Contraseña?</a>
                </div>
                <div class="text-center">
                    <a class="small" href="<?php echo base_url('crear_cuenta'); ?>">Crear una cuenta</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection()?>