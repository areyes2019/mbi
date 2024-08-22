<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<style>
        .email-item {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .email-item:hover {
            background-color: #f8f9fa;
        }
        .email-preview {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .email-details {
            border-left: 1px solid #dee2e6;
        }
        .email-list {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
<div class="container">
	<div class="card rounded-0">
		<div class="card-body">
			<div class="row">
	            <!-- Listado de correos -->
	            <div class="col-md-4 email-list">
	                <h4 class="mb-4">Bandeja de Entrada</h4>
	                <div class="list-group">
	                    <a href="<?php echo base_url('/kardex'); ?>" class="list-group-item list-group-item-action email-item">
	                        <div class="d-flex w-100 justify-content-between">
	                            <div>
	                            	<strong>
	                                	<p class="mb-1 text-danger"><i class="bi bi-envelope-fill me-2"></i>Hospital General de Celaya</p>
	                            	</strong>
	                                <p class="mb-1 email-preview">Maquina de embalaje y subpresor de temperatura</p>
	                                <small class="text-primary"><i class="bi bi-person-circle me-2"></i>De: Adriana Salinas</small>
	                            </div>
	                            <small><i class="bi bi-clock me-2 text-warning"></i>Hace 3 días</small>
	                        </div>
	                    </a>
	                </div>
	            </div>

	            <!-- Vista previa del correo -->
	            <div class="col-md-8 email-details">
	                <h4 class="mb-4">Vista Previa del Correo</h4>
	                <div class="card">
	                    <div class="card-header">
	                        <strong><i class="bi bi-envelope-fill me-2"></i>Hospital General de Celaya</strong>
	                    </div>
	                    <div class="card-body">
	                        <h6><i class="bi bi-person-circle me-2"></i>De: Adriana Salinas</h6>
	                        <h6><i class="bi bi-arrow-right me-2"></i>Para: Enrique Salas</h6>
	                        <hr>
	                        <p>Estimado destinatario,</p>
	                        <p>Este es el contenido detallado del correo 1. Aquí puedes mostrar todo el cuerpo del mensaje, imágenes y otros elementos HTML que puedan estar presentes en un correo electrónico.</p>
	                        <p>Saludos,<br>Remitente 1</p>
	                    </div>
	                    <div class="card-footer text-muted">
	                        <i class="bi bi-clock me-2"></i>Hace 3 días
	                        <a href="" class="float-right">Ver la orden</a>
	                    </div>
	                </div>
	            </div>
        	</div>
		</div>
	</div>
</div>

<?php echo $this->endSection()?>