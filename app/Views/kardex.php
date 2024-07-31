<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container-fluid">
	<div class="card shadow mb-4 rounded-0">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Solicitud de Diagnóstico</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
			<h5>Solicitud de Diagnostico</h5>
			<hr>
			<div class="row">
				<div class="col-md-5">
					<h5 class="m-0"># <strong>JKG56633</strong></h5>
					<p class="mb-0 mt-1">Generado por:</p>
					<h5><strong>Adela Franco</strong></h5>
					<p class="m-0">Asignagnado a: <strong>Carlos Estrada Caballero</strong></p>
					<p class="m-0">Fecha: 25 Mayo 2025</p>
					<p class="mt-3 mb-0">Cliente: <strong>Hospital Santa Helena</strong></p>
					<p class="m-0">Contacto: <strong>Jose Francisco Almanza</strong></p>
					<p class="m-0">Reportó: <strong>Adriana Salinas</strong></p>
					<p class="m-0">Teléfono: <strong>461 256 2536</strong></p>
				</div>
				<div class="col-md-4 offset-3">
					<p class="mt-3 mb-0">Drirección:</p>
					<p class="m-0"><strong>Calle del llano #23, Colonio Centro. Salamanca, Gto. Entre Rio de la Losa y Arcos de Belen</strong></p>
					<p class="m-0">Atiende:</p>
					<p class="m-0"><strong>Elena Matos</strong></p>
					<p class="m-0">Teléfono: <strong>461 295 1256</strong></p>
					<p class="mt-3 mb-0">Visita programada:</p>
					<p class="m-0"><strong>Miercoles 25 julio 2025, 9:30 a.m</strong></p>
				</div>
			</div>
			<h5 class="mt-4"><strong>Detalle de falla</strong></h5>
			<table class="table table-bordered mt-3">
				<thead>
					<tr>
						<th>Equipo</th>
						<th>Modelo</th>
						<th>Falla</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Desfibrilador Lateral</td>
						<td>MDX-5690</td>
						<td>No prende el compresor de arranque</td>
					</tr>
				</tbody>
			</table>

			<h5 class="mt-4"><strong>Diagnostico</strong></h5>
			<table class="table table-bordered mt-3">
				<tbody>
					<tr>
						<td>
							<img src="<?php echo base_url('public/img/Captura.png');?>" width="450">
						</td>
						<td>Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Inventore perspiciatis perferendis porro iusto corrupti autem quod, illo in voluptatibus maxime voluptatem, laboriosam non, distinctio atque accusantium adipisci quam sequi. Architecto, quam, similique? Rerum dolorem sapiente dignissimos beatae. Tempore possimus, doloremque non illo. Voluptatibus dignissimos incidunt quas nesciunt at tenetur dolore eius iusto, non, suscipit quidem, fuga, id harum. Obcaecati blanditiis, voluptate sit doloribus facere dolore voluptas quisquam maiores ex, quod cumque nam dolores perferendis, dignissimos dolor illum repudiandae. Pariatur, totam.</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo base_url('public/img/ejemplo01.jpg');?>" width="450">
						</td>
						<td>Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Inventore perspiciatis perferendis porro iusto corrupti autem quod, illo in voluptatibus maxime voluptatem, laboriosam non, distinctio atque accusantium adipisci quam sequi. Architecto, quam, similique? Rerum dolorem sapiente dignissimos beatae. Tempore possimus, doloremque non illo. Voluptatibus dignissimos incidunt quas nesciunt at tenetur dolore eius iusto, non, suscipit quidem, fuga, id harum. Obcaecati blanditiis, voluptate sit doloribus facere dolore voluptas quisquam maiores ex, quod cumque nam dolores perferendis, dignissimos dolor illum repudiandae. Pariatur, totam.</td>
					</tr>
				</tbody>
			</table>
			<table class="table table-bordered mt-3">
				<thead>
					<tr>
						<th>Descripcion</th>
						<th>Modelo</th>
						<th>Precio sugerido</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Reparacion de Termostato lineal de arranque</td>
						<td>NA</td>
						<td>$4500.00</td>
					</tr>
					<tr>
						<td>Termostato de arranque</td>
						<td>MHJ56</td>
						<td>$950.00</td>
					</tr>
				</tbody>
			</table>
		</div>
    </div>
</div>
<?php echo $this->endSection() ?>