<template>
	<div>
		<div id="menu">
			<div class="menu-body d-flex align-items-center">
				<div class="menu-item">
					<a href="#" @click.prevent="contact = !contact, show_menu(1)"><span class="ti-user"></span> Contactos</a>
					<div class="menu-collapse" v-if="contact">
						<ul class="m-0 p-0">
							<li><span class="ti-angle-right"></span><a :href="/contacts_page/+ 1">Lista de Clientes</a></li>
							<li><span class="ti-angle-right"></span><a :href="/contacts_page/+ 2">Lista de Proveedores</a></li>
							<li><span class="ti-angle-right"></span><a :href="/contacts_page/+ 3">Lista de Contactos</a></li>
						</ul>
					</div>
				</div>
				<div class="menu-item">
					<a href="#quotation" @click.prevent="quotation = !quotation ,show_menu(2)"><span class="ti-files"></span> Cotizaciones</a>
					<div class="menu-collapse" v-if="quotation">
						<ul class="m-0 p-0">
							<li><span class="bi bi-circle"></span><a href="/quotations">Ver lista</a></li>
							<li><span class="ti-angle-right"></span><a href="">Crear cotización</a></li>
						</ul>
					</div>
				</div>
				<div class="menu-item">
					<a href="#invoice"  @click.prevent="invoice = !invoice ,show_menu(3)"><span class="ti-files"></span> Facturas</a>
					<div class="menu-collapse" id="invoice" v-if="invoice">
						<ul class="m-0 p-0">
							<li><span class="ti-angle-right"></span><a href="">Ver lista</a></li>
							<li><span class="ti-angle-right"></span><a href="">Crear factura</a></li>
						</ul>
					</div>
				</div>
				<div class="menu-item">
					<a href="#invoice" @click.prevent="work = !work ,show_menu(4)"><span class="ti-stamp"></span> Ordenes de Trabajo</a>
					<div class="menu-collapse" id="invoice" v-if="work">
						<ul class="m-0 p-0">
							<li><span class="ti-angle-right"></span><a href="">Ver lista</a></li>
							<li><span class="ti-angle-right"></span><a href="">Crear</a></li>
						</ul>
					</div>
				</div>
				<div class="menu-item">
					<a href="#store" @click.prevent="store = !store ,show_menu(5)"><span class="bi bi-box-seam"></span> Shop</a>
					<div class="menu-collapse" id="store" v-if="store">
						<ul class="m-0 p-0">
							<li><span class="ti-angle-right"></span><a href="/articles">Artículos</a></li>
							<li><span class="ti-angle-right"></span><a href="/cataloges">Catalogos</a></li>
							<li><span class="ti-angle-right"></span><a href="/categories">Categorías</a></li>
						</ul>
					</div>
				</div>
				<!-- <div class="menu-item">
					<a href="#invoice" @click.prevent="store = !store ,show_menu(5)" ><span class="ti-gift"></span> Tiendas</a>
					<div class="menu-collapse" id="invoice" v-if="store">
						<ul class="m-0 p-0">
							<li><span class="ti-angle-right"></span><a href="/woocommerce">Ver lista</a></li>
							<li><span class="ti-angle-right"></span><a href="">Crear</a></li>
						</ul>
					</div>
				</div>-->
				
			</div>
	 	</div>
	</div>
</template>
<script>
	export default{
		props:['user'],
		data(){
			return{
				contact:false,
				quotation:false,
				invoice:false,
				work:false,
				store:false,
				login:false,
				articles:false,
			}
		},
		methods:{
			show_menu(data){
				if (data==1) {
					this.quotation = false;
					this.invoice = false;
					this.work = false;
					this.store = false;
				}else if (data==2) {
					this.contact = false;
					this.invoice = false;
					this.work = false;
					this.store = false;
				}else if(data==3){
					this.store = false;
					this.contact = false;
					this.quotation = false;
					this.work = false;
				}else if (data==4) {
					this.store=false;
					this.contact=false;
					this.quotation=false;
					this.invoice=false;
				}else if (data==5) {
					this.contact = false;
					this.quotation = false;
					this.invoice = false;
					this.work = false;
				}
			}
		},
		mounted(){

		}
	}
</script>