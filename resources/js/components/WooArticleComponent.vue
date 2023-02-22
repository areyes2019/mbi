<template>
	<div class="container">
		<p>Esta es la vista para el articulo {{article}}</p>
	</div>
</template>
<script>
	export default{
		props:['article'],
		data(){
			return{
				article_data:[],
			}
		},
		methods:{
			get_article(){
				var me = this;
				var url = '/woo_get_article/'+this.article;
				axios.get(url).then(function(response){
					me.article_data = response.data;
				})
			}
		},
		mounted(){
			//this.get_article();
		}
	}
</script>