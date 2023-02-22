<template>
    <div class="container">
        <div class="form-group-new">
            <div class="my-form-group">
                <label for="">Asignar nombre a la categoría</label>
                <input type="text"  class="form-control" v-model="categorie" placeholder="Nombre de Categoría">
                <small class="m-0 text-danger" v-if="categorie_error">{{categorie_error}}</small>
                <small class="m-0 text-danger" v-if="main_error">{{main_error}}</small>
            </div>
            <div class="my-form-group">
                <label for="">Selecione sub-categoría</label>
                <select class="form-control" v-model="child">
                    <option value="0" v-model="child">Principal</option>
                    <option :value="item.idCategorie" v-for="(item,index) in list" v-model="child">{{item.name}}</option>
                </select>
            </div>
            <div class="my-form-group">
                <button class="btn btn-danger" @click="add_category()"><span class="bi bi-save"></span> Guardar</button>
            </div>
        </div>
        <div class="card-box-std p-3">
            <div class="alert alert-danger" role="alert" v-if="error">
              {{error}}
            </div>
            <div class="card-container" v-for="item in list">
                <div class="card-list-item" >
                    <div class="dialog-text">
                        <p class="m-0">{{item.idCategorie}} - {{item.name}}</p>
                    </div>
                    
                    <div class="list-action">
                        <a href="#" @click.prevent="delete_categorie(1,item.idCategorie)"><span class="bi bi-trash text-danger"></span></a>
                        <a :href="'#'+item.slug" data-bs-toggle="collapse"><span class="bi bi-pencil text-primary"></span></a>
                    </div>
                </div>
                <!-- update toggle -->
                <div class="card-list-toggle collapse close_toggle" :id='item.slug'>
                    <div class="my-form-group-inline">
                        <input type="text" id="" class="input-control" v-model="item.name" :ref="item.idCategorie">
                    </div>                            
                    <button class="btn btn-sm btn-danger" @click.prevent="update(item.idCategorie)"><span class="bi bi-check"></span></button>
                </div>
                <!-- Lista de sub-categorias -->
                <div class="card-list-child" v-for="child in children" v-if="child.main==item.idCategorie">
                    <div class="list-child">
                        <p class="m-0">{{child.idCategorie}} - {{child.name}}</p>
                        <div class="list-action">
                            <input type="checkbox" class="m-0">
                            <a href="#"><span class="bi bi-trash" @click.prevent="delete_categorie(2,child.idCategorie)"></span></a>
                            <a :href="'#'+child.slug" data-bs-toggle="collapse"><span class="bi bi-pencil text-primary"></span></a>
                        </div>
                    </div>
                    <!-- update toggle -->
                    <div class="card-list-toggle collapse close_toggle" :id='child.slug'>
                        <div class="my-form-group-inline">
                            <input type="text" id="" class="input-control" v-model="child.name" :ref="child.idCategorie">
                            <select class="input-control" v-model="child_update" :ref="'int'+child.idCategorie">
                                <option value="0">Sin cambio</option>
                                <option :value="item_update.idCategorie" v-for="(item_update,index) in list">{{item_update.name}}</option>
                            </select>
                            <button class="btn btn-sm btn-danger" @click="update_child(child.idCategorie)"><span class="bi bi-check"></span></button>
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal advertencia -->
        <div class="modal fade" id="warning" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <div class="body-warning">
                    <span class="warning-icon bi bi-exclamation-triangle"></span>
                    <p class="warning-title">¡Advertencia!</p> 
                    <p class="warning-text" v-if="warning=='1'">Si eliminas esta categoría, eliminas a sus sub-categorias y los artículos pasarán a formar parte de la categoría principal</p>
                    <p class="warning-text" v-else-if="warning=='2'">Si eliminas esta categoría, los artículos dependientes pasaran a la categoria principal</p>
                </div>  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info rounded-0 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger rounded-0 btn-sm" @click="delete_confirm()">Confirmar</button>
              </div>
            </div>
          </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        data(){
            return{
                csrf:document.querySelector('#csrf').getAttribute('content'),
                categorie:"",
                child:"",
                list:[],
                categorie_error:"",
                main_error:"",
                children:[],
                delete_id:"",
                warning:"",
                view:"d-none",
                update_name:"",
                child_update:"",
                error:""  
            }
        },
        methods:{
            get_data(){
                var me = this;
                var url = 'get_categories';
                axios.get(url).then(function(response){
                    me.list = response.data[0];
                    me.children = response.data[1];
                });
            },
            get_child(){
                var me = this;
                console.log($refs);
            },
            add_category(){
                var me = this;
                var url = '/add_categorie';
                axios.post(url,{
                    'name':me.categorie,
                    'main':me.child,
                    '_token':me.csrf,
                    'slug':me.categorie
                }).then(function(response){
                    me.categorie_error = "";
                    me.main_error = "";
                    me.categorie = "";
                    me.child = "";
                    var title = "Felicidades";
                    var message = "Has creado un catálogo";
                    toaster(title,message);
                    me.get_data();
                }).catch(function(errors){
                    if (errors.response.data.errors.name) {
                        me.categorie_error = errors.response.data.errors.name[0];
                    }else{
                        me.categorie_error = "";
                    }
                    if (errors.response.data.errors.main) {
                        me.main_error = errors.response.data.errors.main[0];
                    }else{
                        me.main_error = "";
                    }
                    
                });
            },
            delete_categorie(data, item){
                if (data==1) {
                    this.delete_id = item;
                    this.warning = data;
                    $('#warning').modal('show');
                }else if (data==2) {
                    this.delete_id = item;
                    this.warning = data;
                    $('#warning').modal('show');
                }
            },
            delete_confirm(){
                var me = this;
                var id = this.delete_id;
                var url = "delete_categorie/"+id
                axios.get(url).then(function(response){
                    me.get_data();
                    $('#warning').modal('hide');
                    var title = "Felicidades";
                    var message = "Has eliminado la categoría";
                    toaster(title,message);
                })
            },
            update(data){
                var name = this.$refs[data][0].value;
                var slug = name.replace(/ /g,'_').toLowerCase();
                var me = this;
                var url = "/update_categorie/"+ data;
                axios.post(url,{
                    'name':name,
                    'slug':slug
                }).then(function(response){
                    $('.close_toggle').collapse('hide');
                    var title = "Felicidades";
                    var message = "Categoría Actualizada";
                    toaster(title,message);
                    me.get_data();
                    me.error = "";
                }).catch(
                    function(errors){
                        me.error = errors.response.data.errors.name[0];
                    }
                );

            },
            update_child(data){
                var name = this.$refs[data][0].value;
                var nick = 'int'+data;
                var sub_categorie = this.$refs[nick][0].value;
                var slug = name.replace(/ /g,'_').toLowerCase();
                var me = this;
                var url = "/update_child/"+ data;
                axios.post(url,{
                    'name':name,
                    'slug':slug,
                    'main':sub_categorie,
                    'is_parent':0
                }).then(function(response){
                    $('.close_toggle').collapse('hide');
                    var title = "Felicidades";
                    var message = "Categoría Actualizada";
                    toaster(title,message);
                    me.get_data();
                    me.error = "";
                }).catch(
                    function(errors){
                        me.error = errors.response.data.errors.name[0];
                    }
                );
            }
        },
        mounted() {
            this.get_data();
        }
    }
</script>
