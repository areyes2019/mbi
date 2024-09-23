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
    /* Estilos personalizados para el árbol */
        .tree ul {
            list-style-type: none;
            padding-left: 20px;
            border-left: 1px solid #ddd;
        }
        .tree ul li {
            margin: 5px 0;
            position: relative;
        }
        .tree ul li::before {
            content: '';
            position: absolute;
            top: 0;
            left: -20px;
            width: 20px;
            height: 100%;
            border-left: 1px solid #ddd;
        }
        .tree ul li::after {
            content: '';
            position: absolute;
            top: 15px;
            left: -20px;
            width: 10px;
            height: 1px;
            background-color: #ddd;
        }
</style>
<div class="container-fluid" id="app">
	<div class="card rounded-0">
		<div class="card-body">
			<div class="row">
	            <!-- Listado de correos -->
	            <div class="col-md-3 email-list">
	            	<div class="tree">
				        <ul>
				            <li>
				                <h4><i class="bi bi-inbox"></i> Bandeja de entrada</h4>
		                        <ul v-for="data_recibido in recibido">
		                            <li><i class="bi bi-file-earmark mr-1"></i>
		                            	<a href="" @click.prevent = "vista_previa(data_recibido.id_kardex)">
		                            		{{data_recibido.id_kardex}} - {{data_recibido.hospital}}
		                            	</a>
		                            	<br>
		                            	<small class="m-0"><strong>Asunto: </strong>{{data_recibido.comentarios}}</small>
		                            </li>
		                        </ul>
				            </li>
				        </ul>
				    </div>
	            </div>

	            <!-- Vista previa del correo -->
	            <div class="col-md-9 email-details">
	            	<div v-if="vista_defecto == 1" class="card" v-for = "kardex in primer_kardex">
	                    <div class="card-header d-flex justify-content-between">
	                        <strong><i class="bi bi-envelope-fill me-2"></i>{{kardex.hospital}}</strong>
	                        <button class="btn btn-primary btn-sm rounded-0"><span class="bi bi-send" @click = "abrir_modal_lista(kardex.id_kardex)"></span></button>
	                    </div>
	                    <div class="card-body">
		                	<h6 class="mt-0"><span class="badge badge-danger">{{kardex.tipo_txt}}</span></h6>
	                        <h6><i class="bi bi-person-circle me-2"></i>De: {{kardex.generado_nombre}}</h6>
	                        <p class="d-none" ref="kardex">{{kardex.id_kardex}}</p>
	                        <h6><i class="bi bi-send me-2"></i>Para: 
	                        	<span>{{kardex.atendido_nombre}}</span>
	                        </h6>
	                        <h6><i class="bi bi-calendar-date me-2"></i>
	                        	<span>{{new Date(kardex.created_at).toLocaleDateString('es-Es',{day:'numeric',month:'long', year:'numeric'})}}</span>
	                        </h6>
	                        <h6><strong>Asunto: </strong>{{kardex.comentarios}}</h6>
	                        <hr>
	                        <h6><strong>Kardex #: </strong>{{kardex.id_kardex}}</h6>
	                        <table class="table table-bordered">
			                    <thead class="thead-dark">
			                        <tr>
			                            <th>#</th>
			                            <th>Equipo</th>
			                            <th>Marca</th>
			                            <th>Modelo</th>
			                            <th>No.Serie</th>
			                            <th>No. Inventario</th>
			                        </tr>
			                    </thead>
			                    <tbody v-for="kdx in kardex_detalle">
			                        <tr>
			                            <td>{{kdx.id_kardex}}</td>
			                            <td>{{kdx.nombre}}</td>
			                            <td>{{kdx.marca}}</td>
			                            <td>{{kdx.modelo}}</td>
			                            <td>{{kdx.serie}}</td>
			                            <td>{{kdx.inventario}}</td>
			                        </tr>
			                        <tr>
			                            <td colspan="5"><strong>Descripción del problema: </strong>{{kdx.falla}}</td>
			                        </tr>
			                    </tbody>                    
			                </table>
	                    </div>
	                    <div class="card-footer text-muted">
	                        <i class="bi bi-clock me-2"></i>Hace {{calcularDiferenciaDias(kardex.created_at)}}  días
	                        <a :href='"/kardex/"+kardex.slug' class="float-right">Ver el Kardex</a>
	                    </div>
	                </div>
	                <!-- seccion de panel lateral de kardex -->
	                <div class="card" v-for = "data_kardex in kardex_lateral">
	                    <div class="card-header d-flex justify-content-between">
	                        <strong><i class="bi bi-envelope-fill me-2"></i>{{data_kardex.hospital}}</strong>
	                        <button class="btn btn-primary btn-sm rounded-0"><span class="bi bi-send" @click = "abrir_modal_lista(data_kardex.id_kardex)"></span></button>
	                    </div>
	                    <div class="card-body">
		                	<h6 class="mt-0"><span class="badge badge-danger">{{data_kardex.tipo_txt}}</span></h6>
	                        <h6><i class="bi bi-person-circle me-2"></i>De: {{data_kardex.remitente_nombre}}</h6>
	                        <p class="d-none" ref="kardex">{{data_kardex.id_kardex}}</p>
	                        <h6><i class="bi bi-send me-2"></i>Para: 
	                        	<span>{{data_kardex.destinatario_nombre}}</span>
	                        </h6>
	                        <h6><i class="bi bi-calendar-date me-2"></i>
	                        	<span>{{new Date(data_kardex.created_at).toLocaleDateString('es-Es',{day:'numeric',month:'long', year:'numeric'})}}</span>
	                        </h6>
	                        <h6><strong>Asunto:</strong>{{data_kardex.asunto}}</h6>
	                        <hr>
	                        <h6><strong>Tipo de Solicitud: </strong>{{data_kardex.tipo_txt}}</h6>
	                        <table class="table table-bordered">
			                    <thead class="thead-dark">
			                        <tr>
			                            <th>#</th>
			                            <th>Equipo</th>
			                            <th>Marca</th>
			                            <th>Modelo</th>
			                            <th>No.Serie</th>
			                            <th>No. Inventario</th>
			                        </tr>
			                    </thead>
			                    <tbody v-for="kdx in kardex_detalle">
			                        <tr>
			                            <td>{{kdx.id_kardex}}</td>
			                            <td>{{kdx.nombre}}</td>
			                            <td>{{kdx.marca}}</td>
			                            <td>{{kdx.modelo}}</td>
			                            <td>{{kdx.serie}}</td>
			                            <td>{{kdx.inventario}}</td>
			                        </tr>
			                        <tr>
			                            <td colspan="5"><strong>Descripción del problema: </strong>{{kdx.falla}}</td>
			                        </tr>
			                    </tbody>                    
			                </table>
	                    </div>
	                    <div class="card-footer text-muted">
	                        <i class="bi bi-clock me-2"></i>Hace {{calcularDiferenciaDias(data_kardex.created_at)}}  días
	                        <a :href='"/kardex/"+data_kardex.slug' class="float-right">Ver el Kardex</a>
	                    </div>
	                </div>
	            </div>
        	</div>
		</div>
	</div>
	<!-- modal usuario para enviar -->
	<div class="modal fade" id="modal_enviar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	            <label for="recipient-name" class="col-form-label">Recipient:</label>
	            <select  id="selectUsuario" class="form-control" v-model="usuario">
	            	<option disabled value="defecto" selected>Selecciona una opción...</option>
	            	<?php foreach ($usuario as $user): ?>
	            	<option value="<?php echo $user['id_usuario'] ?>"><?php echo $user['nombre']." ".$user['apellidos'] ?></option>
	            	<?php endforeach ?>
	            </select>
	          </div>
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">Message:</label>
	            <textarea class="form-control" id="message-text" v-model="asunto"></textarea>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary btn-sm rounded-0" @click = "enviar_form"><span class="bi bi-send"></span> Enviar</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/js/inbox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<?php echo $this->endSection()?>