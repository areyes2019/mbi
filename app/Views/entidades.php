<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Entidades</h1>
    </div>
    <a href="<?php echo base_url('entidades/create'); ?>" class="btn btn-primary btn-sm rounded-0">Nueva Entidad</a>
	<div class="card mt-3 rounded-0">
        <div class="card-body">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Razón social</th>
                        <th>RFC</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entidades as $entidad):?>
                    <tr>
                        <td><?php echo $entidad['razon_social'] ?></td>
                        <td><?php echo $entidad['rfc'] ?></td>
                        <td>
                            <a href="<?php echo base_url('/entidades/show/'.$entidad['id_entidad']); ?>" class="btn btn-primary btn-sm rounded-0">Editar</a>
                            <a href="<?php echo base_url('/entidades/delete/'.$entidad['id_entidad']); ?>" class="btn btn-danger btn-sm rounded-0">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>		
        </div>
	</div>
</div>

<?php echo $this->endSection(); ?>