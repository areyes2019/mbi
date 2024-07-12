<?php echo $this->extend('Panel/login_template') ?>
<?php echo $this->section('login-panel')?>
<div class="col-12 col-md-6">
    <div class="card border-0 my-5 rounded-0">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Crear una cuenta</h1>
                    <p>{{msg}}</p>
                </div>
                <form class="user">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Nombre Completo">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Correo Elecrtónico">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user"
                            id="exampleInputPassword" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" placeholder="Confirmar Contraseña">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Recuerdame</label>
                        </div>
                    </div>
                    <a href="index.html" class="btn btn-primary btn-user btn-block">
                        Entrar
                    </a>
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
                    <a class="small" href="<?php echo base_url('/'); ?>">Ya tengo una cuenta</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection()?>