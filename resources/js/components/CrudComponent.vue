<template>
	<div class="container">
		<form @submit.prevent="save">
			<input type="text" v-model="save.name">
			<button class="btn" type="submit">Guardar</button>
		</form>
		<table>
			<tr>
				<th>#</th>
				<th>Data</th>
				<th>Data</th>
				<th>Data</th>
				<th></th>
			</tr>
			<tr v-for="item in data ">
				<td>{{item.name}}</td>
				<td>{{item.name}}</td>
				<td>{{item.name}}</td>
				<td>
					<button @click="show_single_date(item.id)">Update</button>
					<button @click="delete_data(item.id)">Delete</button>
				</td>
			</tr>
		</table>
		<div class="modal">
			<form @submit.prevent v-for="unique in single">
				<input type="text" v-model="unique.data">
				<button @click="update_data(unique.id)">Save</button>
			</form>
		</div>
	</div>
</template>
<script>
	export default{
		data(){
			return{
				save:[],
				data:[],
				single:[],
			}
		},
		methods:{
			show_data(){
				var me = this;
				var url = 'url';
				axios.get(url).then(function(response){
					me.data = response.data
				})
			},
			show_single_data(data){
				var me = this;
				var url = '/url/'+data;
				axios.get(url).then(function(response){
					me.single = response.data;
				})	
			},
			save_data(){
				var me = this;
				var url = 'url';
				axios.save(url,{
					'data': data,
				}).then(function(response){
					me.data = response.data
				})
			},
			update_data(data){
				var me = this;
				var url = 'url/'+data;
				axios.post(url,{
					'data': data,
				}).then(function(response){
					//succes
				})
			},
			delete_data(data){
				var me = this;
				var url = 'url'+data;
				axios.get(url).then(function(response){
					//succes
				})
			}
		},
		mounted(){
			this.show_data();
		}
	}
</script>