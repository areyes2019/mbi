<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app">
    <?php foreach ($cotizacion as $item): ?>        
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url('/inicio'); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('/cotizaciones'); ?>">Cotizaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cotización <?php echo $item['id_cotizacion'] ?></li>
        </ol>
    </nav>
    <!-- Mostrar el mensaje de éxito -->
    <?php if (session()->has('mensaje')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4 rounded-0">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between rounded-0">
        <h6 class="m-0 font-weight-bold text-primary">Cotización <span ref="id_cotizacion"><?php echo $item['id_cotizacion'] ?></span></h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                
                <div class="dropdown-header"></div>
                <a class="dropdown-item" href="<?php echo base_url('descargar_cotizacion/'.$item['id_cotizacion']); ?>"><span class="bi bi-download"></span> Descargar</a>
                <a class="dropdown-item" href="" @click.prevent = "enviar_cotizacion(<?php  echo $item['id_cotizacion'] ?>)"><span class="bi bi-send"></span> Enviar</a>

                <?php if ($item['estatus']==10): ?>
                <a class="dropdown-item" href="" @click.prevent = "accion(<?php echo $item['id_cotizacion'] ?>,1)"><span class="bi bi-check"></span> Marcar Aceptado</a>

                <a class="dropdown-item" href="" @click.prevent = "accion(<?php echo $item['id_cotizacion'] ?>,2)"><span class="bi bi-x-lg"></span> Marcar Rechazado</a>
                <?php endif ?>

                <!-- Facturar -->
                <?php if ($item['estatus']==11): ?>
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#modalForm"><span class="bi bi-file-earmark-text"></span> Facturar</a>
                <?php endif ?>
                <?php if ($item['estatus']!= 11): ?>
                <a class="dropdown-item" href="" @click.prevent = "eliminar_cotizacion(<?php echo $item['id_cotizacion']?>)"><span class="bi bi-trash3"></span> Eliminar Cotización</a>
                <?php endif ?>
            </div>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body rounded-0">
        <div class="row">
            <div class="col-md-8">
                <?php 
                    $estatus = asignar_estatus($item['estatus']);
                    if ($estatus): ?>
                    <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                <?php endif ?>   
                <p class="m-0"><strong>Para:</strong></p>
                <p class="m-0"><?php echo $item['hospital'] ?></p>
                <p class="m-0">Att: <?php echo $item['responsable'] ?></p>
                <p class="m-0">Tel: <?php echo $item['telefono'] ?></p>
                <p class="m-0"><?php echo $item['correo'] ?></p>
                <p class="m-0"><strong>Kardex asociado: </strong><a href="<?php echo base_url('kardex/').$id_kardex."/".$slug?>"><?php echo $item['id_kardex'] ?></a></p>
                <p class="m-0"><strong>Condiciones de pago:</strong> <?php echo $item['condiciones'] ?></p>
                <p class="m-0"><strong>Entrega:</strong> <?php echo $item['entrega'] ?> días</p>
                <p class="m-0" v-if="<?php echo $item['garantia']?>== 1"><strong>Garantia:</strong> 3 meses por servicio</p>
                <p class="m-0" v-if="<?php echo $item['garantia']?>== 2"><strong>Garantia:</strong> 12 meses por equipo</p>
                <p class="m-0"><strong>Moneda:</strong> <?php echo $item['moneda'] ?></p>
            </div>
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <td>
                            <h5><strong>Sub-total</strong></h5>
                        </td>
                        <td>
                            <h5 class="text-primary">$5200</h5>
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <h5><strong>IVA</strong></h5>
                        </td>
                        <td>
                            <h5 class="text-primary">$890</h5>
                        </td>
                    </tr>
                     <tr class="bg-dark">
                        <td>
                            <h5 class="text-white"><strong>Pago Total</strong></h5>
                        </td>
                        <td>
                            <h5 class="text-white">$456</h5>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</div>
<div class="card shadow mb-4 rounded-0">
    <div class="card-body d-flex align-items-center">
         <button class="btn btn-primary btn-icon-split ml-2 rounded-0" data-toggle="modal" data-target="#condiciones">
            <span class="icon text-white-50">
                <i class="bi bi-list-check"></i>
            </span>
            <span class="text">Condiciones</span>
        </button>
        <button class="btn btn-danger btn-icon-split ml-2 rounded-0" data-toggle="modal" data-target="#agregar_articulo" @click = "agregar_diagnostico_modal(<?php echo $item['id_cotizacion'] ?>)">
            <span class="icon text-white-50">
                <i class="bi bi-list-check"></i>
            </span>
            <span class="text">Agregar Conceptos</span>
        </button>
        <div class="w-25 d-flex ml-2 align-items-center">
            <label for="moneda">Selecciona una moneda:</label>
            <select class="form-control select-with-flags" id="moneda" @change="cambiar_moneda(<?php echo $item['id_cotizacion'] ?>)" v-model="moneda">
                <option value="MXM">Pesos Mexicanos (MXM)</option>
                <option value="USD">Dolar (USD)</option>
            </select>
        </div>
        <!--  Modal agregar diagnosticos  -->  
        <div class="modal fade" id="agregar_articulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Selecione un diagnóstico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-for = "diag in diagnostico">
                        <table class="table w-100" id="articulos">
                            <thead>
                                <tr>
                                    <th>Diagnóstico</th>
                                    <th>Reparacion sugerida</th>
                                    <th>Precio estimado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{diag.diagnostico}}</td>
                                    <td>{{diag.reparacion}}</td>
                                    <td>${{total = diag.precio_estimado}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table w-100" id="articulos">
                            <thead>
                                <tr>
                                    <th>Refacciones</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "refa in refacciones">
                                    <td>{{refa.refaccion}}</td>
                                    <td>${{costo = refa.precio}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Gran Total ${{(Number(total)+Number(costo)).toFixed(2)}}</p>
                        <div v-if="diag.agregado != 1">
                            <form @submit.prevent="submitForm">
                                <div class="editor-container">
                                    <div class="toolbar">
                                      <button class="btn_editor" @click.prevent="formatText('bold')"><b>B</b></button>
                                      <button class="btn_editor" @click.prevent="formatText('italic')"><i>Italica</i></button>
                                      <button class="btn_editor" @click.prevent="formatText('insertUnorderedList')">• Lista</button>
                                    </div>
                                    <div 
                                      ref="editor" 
                                      contenteditable="true" 
                                      class="editor"
                                    >
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <input type="number" v-model="form.partida" class="form-control rounded-0 shadow-none" placeholder="Partida">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" v-model="form.cantidad" class="form-control rounded-0 shadow-none" placeholder="Cantidad">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" v-model="form.precio" class="form-control rounded-0 shadow-none" placeholder="Precio Unt.">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Enviar</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-icon-split" data-dismiss="modal">
                            <span class="icon text-white-50">
                                <i class="bi bi-box-arrow-right"></i>
                            </span>
                            <span class="text">Cerrar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Agregar condiciones -->
        <div class="modal fade" id="condiciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Condicones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="miFormulario">
                            <div class="form-group">
                                <label for="condicionesPago">Condiciones de Pago:</label>
                                <input type="text" class="form-control rounded-0 shadow-none" v-model="condiciones">
                            </div>

                            <div class="form-group">
                                <label for="tiempoEntrega">Tiempo de Entrega:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control rounded-0 shadow-none" id="tiempoEntrega" min="1" v-model="entrega">
                                    <div class="input-group-append">
                                        <span class="input-group-text rounded-0">Días</span>
                                    </div>
                                </div>
                                <div id="tiempoEntregaError" class="error-message"></div>
                            </div>

                            <div class="form-group">
                                <label for="garantia">Garantía:</label>
                                <select class="form-control" id="garantia" v-model="garantia">
                                    <option value="" selected>Selecciona una opción</option>
                                    <option value="1">3 meses (Servicio)</option>
                                    <option value="2">12 meses (Equipo)</option>
                                    <option value="3">Sin garantía</option>
                                </select>
                                <div id="garantiaError" class="error-message"></div>
                            </div>
                            <button type="submit" class="btn btn-primary" @click.prevent = "agregar_condiciones('<?php echo $item['id_cotizacion'] ?>')">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4 rounded-0">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Cant.</th>
                <th>Partida</th>
                <th>Descripción</th>
                <th>P/U</th>
                <th>Importe</th>
                <td></td>
            </tr>
            <tr v-for = "dato in detalles">
                <td>{{dato.cantidad}}</td>
                <td>{{dato.partida}}</td>
                <td v-html="dato.descripcion"></td>
                <td>${{dato.total}}</td>
                <td>${{total = dato.total * dato.cantidad}}</td>
                <td>
                    <button class="btn btn-danger btn-sm rounded-0 mr-1"><span class="bi bi-x-lg" @click = "borrar_linea_detalle(dato.id_cotizacion_detalle)"></span></button>
                    <button class="btn btn-primary btn-sm rounded-0"><span class="bi bi-pencil" @click = "editar_detalle(dato.id_cotizacion_detalle)" data-toggle="modal" data-target="#editar_detalle"></span></button>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Modal editar detalle -->
<div class="modal fade" id="editar_detalle" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Encabezado del modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Editar Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <form @submit.prevent="submitFormEdit">
            <div class="editor-container">
                <div class="toolbar">
                  <button class="btn_editor" @click.prevent="formatText('bold')"><b>B</b></button>
                  <button class="btn_editor" @click.prevent="formatText('italic')"><i>Italica</i></button>
                  <button class="btn_editor" @click.prevent="formatText('insertUnorderedList')">• Lista</button>
                </div>
                <div v-html="formEdit.descripcion"
                  ref="editor" 
                  contenteditable="true" 
                  class="editor"
                >
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <input type="number" v-model="formEdit.partida" class="form-control rounded-0 shadow-none" placeholder="Partida">
                </div>
                <div class="col-md-4">
                    <input type="number" v-model="formEdit.cantidad" class="form-control rounded-0 shadow-none" placeholder="Cantidad">
                </div>
                <div class="col-md-4">
                    <input type="text" v-model="formEdit.precio_unitario" class="form-control rounded-0 shadow-none" placeholder="Precio Unt.">
                </div>
                <p ref="id_detalle" class="d-none">{{formEdit.id_cotizacion_detalle}}</p>
            </div>
            <button type="submit" class="btn btn-success mt-3 btn-sm rounded-0 shadow-none">Enviar</button>
        </form>
      </div>

      <!-- Footer del modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm rounded-0 shadow-none" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Encabezado del modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Seleccione opciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <form>
            <!-- Forma de pago -->
            <div class="form-group">
                <label for="">Forma de pago</label>
                <select class="selectpicker form-control" id="picker_agregar" data-live-search="true" v-model="metodo_pago" style="width: 100%;">
                    <option disabled selected value=""> Selecciona el régimen... </option>
                    <option v-for="(metodo, index) in listaMetodosPago ">{{ metodo.clave }} - {{ metodo.descripcion }}</option>
                </select>
            </div>
            <!-- Uso -->
            <div class="form-group">
                <label for="">Uso de CFDI</label>
                <select class="selectpicker form-control" id="picker_agregar" data-live-search="true" v-model="usoCFDI" style="width: 100%;">
                    <option disabled selected value=""> Selecciona el régimen... </option>
                    <option v-for="(uso, index) in listaConceptos">{{ uso.clave }} - {{ uso.descripcion }}</option>
                </select>
            </div>
            <!-- Clave de producto-->
            <div class="form-group">
                <label for="entidad">Clave del producto</label>
                <input type="text" class="form-control rounded-0 shadow-none" v-model="clave_prod">
            </div>
            <!-- Entidad -->
            <div class="form-group">
                <label for="entidad">Entidad</label>
                <select class="form-control rounded-0 shadow-none" id="entidad" v-model="entidad">
                    <option value="">Seleccione...</option>
                    <option v-for="entidad in entidades" :value="entidad.id_entidad">{{entidad.razon_social}}</option>
                </select>
            </div>
        </form>
      </div>

      <!-- Footer del modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click = "generar_factura(<?= $item['id_cotizacion'] ?>,<?= $item['id_cliente'] ?>)">Generar</button>
      </div>

    </div>
  </div>
</div>
<?php endforeach ?>
</div>
<script type="text/javascript">
    // Función para capturar el contenido del editor antes de enviar el formulario
    function capturarContenido() {
        const editor = document.getElementById('editor');
        const textarea = document.getElementById('contenido');
        textarea.value = editor.innerHTML; // Copiar el contenido del editor al textarea
    }
</script>
<script src="<?php echo base_url('public/js/cotizacion.js');?>"></script> 
<?php echo $this->endSection()?>