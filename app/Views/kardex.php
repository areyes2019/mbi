<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container-fluid" id="app">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in rounded-0" aria-labelledby="dropdownMenuLink" style="">
                    <a class="dropdown-item" href="#" data-toggle = "modal" data-target="#enviar_cardex" ><span class="bi bi-send"></span> Enviar</a>
                    <a class="dropdown-item" href="#"><span class="bi bi-filetype-pdf"></span> Descargar</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- Información de la Empresa -->
        <div class="row">
            <?php foreach ($kardex as $key): ?>
            <div class="col-md-6">
                <h3 v-if="<?php echo $key['tipo'] ?>=='1'"><span class="badge badge-success">Diagnóstico</span></h3>
                <h3 v-else-if="<?php echo $key['tipo'] ?>=='2'"><span  class="badge badge-warning">Refacciones</span></h3>
                <h3 v-else-if="<?php echo $key['tipo'] ?>=='3'"><span  class="badge badge-warning">Mtto. Prev.</span></h3>
                <h3 v-else-if="<?php echo $key['tipo'] ?>=='4'"><span  class="badge badge-warning">Garantía</span></h3>
                <h5><strong>Kardex # <?php echo $key['id_kardex'] ?> </strong></h5>
                <p class="d-none" ref="kardex"><?php echo $key['id_kardex'] ?></p>
                <p class="mb-1"><strong>Clave: </strong><?php echo $key['slug'] ?></p>
                <p class="mb-1"><strong>Fecha de Emisión: </strong><?php echo $key['created_at'] ?></p>
                <p class="mb-1"><strong>Fecha de Vencimiento: </strong>Pendiente</p>
            </div>
            <?php endforeach ?>

            <?php foreach ($vendedor as $vendedor_data): ?>
            <div class="col-md-6">
                <h5><strong>Vendedor # <?php echo $vendedor_data['no_empleado'] ?></strong></h5>
                <p class="mb-1"><strong>Nombre:</strong> <?php echo $vendedor_data['nombre'].' ';  echo $vendedor_data['apellidos'] ?></p>
                <?php
                    $numero = $vendedor_data['mobil'];
                    $numero_formateado = substr($numero, 0, 3) . ' ' . substr($numero, 3, 3) . ' ' . substr($numero, 6);
                ?>
                <p class="mb-1"><strong>Celular:</strong> <?php echo $numero_formateado ?> </p>
                <p class="mb-1"><strong>Correo:</strong>  <?php echo $vendedor_data['correo'] ?></p>
            </div>
            <?php endforeach ?>
        </div>

        <!-- Datos del Cliente -->
        <div class="row mt-4">
            <?php foreach ($cliente as $cliente_data): ?>
            <div class="col-md-6">
                <h5><strong>Titular</strong></h5>
                <p class="mb-1"><strong>Nombre:</strong> <?php echo $cliente_data['titular']?></p>
                <h5 class="mt-3"><strong>Responsable</strong></h5>
                <p class="mb-1"><strong>Nombre:</strong> <?php echo $cliente_data['responsable']?></p>
                <p class="mb-1"><strong>Teléfono:</strong> <?php echo $cliente_data['telefono']?></p>
                <p class="mb-1"><strong>Celular:</strong> <?php echo $cliente_data['movil']?></p>
            </div>
            
            <div class="col-md-6">
                <h5><strong>Datos del Ubicación</strong></h5>
                <p class="mb-1"><strong>Dirección:</strong> <?php echo $cliente_data['direccion']?></p>
                <p class="mb-1"><strong>Laboratorio:</strong> <?php echo $cliente_data['laboratorio']?></p>
                <p class="mb-1"><strong>Piso:</strong> <?php echo $cliente_data['piso']?></p>
                <h5 class="mt-2"><strong>Horarios de Atención</strong></h5>
                <ul>
                    <?php foreach ($horario as $horarios): ?>
                    <?php
                        $tiempo_inicio = strtotime($horarios['hora_inicio']);
                        $formato_inicio = date('h:i A',$tiempo_inicio);
                        $tiempo_fin = strtotime($horarios['hora_fin']);
                        $formato_fin = date('h:i A',$tiempo_fin);
                    ?>
                    <li><?php echo $horarios['dia'] ?> <span><?php echo $formato_inicio?> a <?php echo $formato_fin ?></span></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endforeach ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control rounded-0 shadow-none" @input="limpiar_error($event,'nombre')" v-model="formulario.nombre" id="equipo" placeholder="Ingrese el nombre del equipo">
                    <small class="text-danger">{{errores.nombre}}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control rounded-0 shadow-none" @input="limpiar_error($event,'marca')" v-model="formulario.marca" id="marca" placeholder="Ingrese la marca">
                    <small class="text-danger">{{errores.marca}}</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control rounded-0 shadow-none" @input="limpiar_error($event,'modelo')" v-model="formulario.modelo" id="modelo" placeholder="Ingrese el modelo">
                    <small class="text-danger">{{errores.modelo}}</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control rounded-0 shadow-none" @input="limpiar_error($event,'serie')" v-model="formulario.serie" id="serie" placeholder="Núm. de serie">
                    <small class="text-danger">{{errores.serie}}</small>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <input type="text" class="form-control rounded-0 shadow-none" @input="limpiar_error($event,'inventario')" v-model="formulario.inventario" id="inventario" placeholder="Inv.">
                    <small class="text-danger">{{errores.inventario}}</small>
                </div>
            </div>

            <div class="form-group">
                <textarea class="form-control rounded-0 shadow-none" id="problema" @input="limpiar_error($event,'falla')" v-model="formulario.falla" rows="2" placeholder="Describa el problema"></textarea>
                <small class="text-danger">{{errores.falla}}</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm rounded-0" @click="insertar">Agregar</button>
        <!-- Tabla de productos/servicios -->
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>No.Serie</th>
                            <th>No. Inventario</th>
                        </tr>
                    </thead>
                    <tbody v-for="kdx in lista">
                        <tr>
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
                    <!--  <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Subtotal:</th>
                            <th>$447.50</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Impuesto (IVA 21%):</th>
                            <th>$93.98</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Total:</th>
                            <th>$541.48</th>
                        </tr>
                    </tfoot>-->
                    
                </table>
            </div>
        </div>

        <!-- Métodos de Pago -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Métodos de Pago</h4>
                <p>Puedes realizar tu pago a través de los siguientes métodos:</p>
                <ul>
                    <li>Transferencia Bancaria</li>
                    <li>Tarjeta de Crédito/Débito</li>
                    <li>PayPal</li>
                </ul>
            </div>

            <!-- Información de la cuenta bancaria -->
            <div class="col-md-6">
                <h4>Detalles de la Cuenta Bancaria</h4>
                <p><strong>Banco:</strong> Banco Ejemplo</p>
                <p><strong>IBAN:</strong> ES91 2100 0418 4502 0005 1332</p>
                <p><strong>BIC/SWIFT:</strong> CAIXESBBXXX</p>
            </div>
        </div>

        <!-- Términos y Condiciones -->
        <div class="row mt-4">
            <div class="col-12">
                <h4>Términos y Condiciones</h4>
                <p>
                    El pago debe realizarse dentro de los 15 días a partir de la fecha de emisión de la factura. En caso de retraso en el pago, se aplicará un interés por demora del 5% mensual sobre el saldo pendiente. Para cualquier consulta, por favor contáctenos a través del correo electrónico proporcionado.
                </p>
            </div>
        </div>
        
        <!-- Información adicional de pago -->
        <div class="row mt-4">
            <div class="col-12 text-right">
                <p><strong>¡Gracias por su compra!</strong></p>
            </div>
        </div>
        <div class="modal fade" id="enviar_cardex" tabindex="-1" aria-labelledby="exampleModalSmLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalSmLabel">Título del Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <select name="" id="" class="form-control">
                    <option value="">Escoge una opción</option>
                    <option value="">Alejandro Alvarez</option>
                    <option value="">Diana Pacheco</option>
                    <option value="">Oloinda Mata</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm rounded-0">Enviar</button>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/kardex.js');?>"></script>
<?php echo $this->endSection() ?>