<?php echo $this->extend('auth/login_template') ?>
<?php echo $this->section('login-panel') ?>
<div class="col-12 col-md-6">
    <div class="card border-0 my-5 rounded-0">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
                <div class="text-center">
                    <p>Escribe tu nueva contraseña</p>
                </div>
                <?= session()->getFlashdata('error') ?>

				<form action="<?= site_url('password/reset') ?>" method="POST">
				    <input type="hidden" name="token" value="<?= $token ?>">
				    <label for="password">Nueva contraseña:</label>
				    <input type="password" name="password" required class="form-control">
				    
				    <label for="password_confirm">Confirmar contraseña:</label>
				    <input type="password" name="password_confirm" required class="form-control">
				    
				    <button type="submit" class="btn btn-primary btn-sm rounded-0 mt-2">Restablecer contraseña</button>
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