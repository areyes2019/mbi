<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container-fluid">
	<!-- Información de la Empresa -->
        <div class="row">
            <div class="col-md-6">
                <h5><strong>Kardex #12345</strong></h5>
                <p class="mb-1"><strong>Fecha de Emisión: </strong>29/08/2024</p>
                <p class="mb-1"><strong>Fecha de Vencimiento: </strong>15/09/2024</p>
            </div>
            <div class="col-md-6">
                <h5><strong>Vendedor #12345</strong></h5>
                <p class="mb-1"><strong>Nombre:</strong> Juan Pérez</p>
                <p class="mb-1"><strong>Celular:</strong> 987-654-321</p>
                <p class="mb-1"><strong>Correo:</strong>mariana@email.com</p>
            </div>
        </div>

        <!-- Datos del Cliente -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h5><strong>Titular</strong></h5>
                <p class="mb-1"><strong>Nombre:</strong> Juan Pérez</p>
                <h5 class="mt-3"><strong>Responsable</strong></h5>
                <p class="mb-1"><strong>Nombre:</strong> Juan Pérez</p>
                <p class="mb-1"><strong>Teléfono:</strong> 987-654-321</p>
                <p class="mb-1"><strong>Celular:</strong> 987-654-321</p>
            </div>
            
            <div class="col-md-6">
                <h5><strong>Datos del Ubicación</strong></h5>
                <p class="mb-1"><strong>Dirección:</strong> Avenida Real 456, Ciudad, País</p>
                <p class="mb-1"><strong>Ubicación:</strong> María López</p>
                <p class="mb-1"><strong>Laboratorio:</strong> maria.lopez@email.com</p>
                <p class="mb-1"><strong>Piso:</strong> maria.lopez@email.com</p>
                <h5 class="mt-2"><strong>Horarios de Atención</strong></h5>
                <ul>
                	<li>Viernes <span>2:30 a.m. a 5:30 p.m.</span></li>
                	<li>Jueves <span>2:30 a.m. a 5:30 p.m.</span></li>
                </ul>
            </div>
        </div>
        
        <!-- Tabla de productos/servicios -->
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Descuento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Producto 1</td>
                            <td>2</td>
                            <td>$50.00</td>
                            <td>5%</td>
                            <td>$95.00</td>
                        </tr>
                        <tr>
                            <td>Producto 2</td>
                            <td>1</td>
                            <td>$150.00</td>
                            <td>0%</td>
                            <td>$150.00</td>
                        </tr>
                        <tr>
                            <td>Servicio 1</td>
                            <td>3</td>
                            <td>$75.00</td>
                            <td>10%</td>
                            <td>$202.50</td>
                        </tr>
                    </tbody>
                    <tfoot>
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
                    </tfoot>
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
</div>

<?php echo $this->endSection() ?>