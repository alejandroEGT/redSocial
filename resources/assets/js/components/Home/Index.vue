<template>
	<div style=""><br><br><br>

	<b-row >
		<b-col xs="12" md="9">
			<b-row>
				<b-col md="12">
				<h5><label style="color:#ABB2B9">Inicio</label> <label style="color:#EB984E"> > </label> Nuevos emprendimientos de este mes.  <b-button v-if="!this.$auth.check()"  style="color:#DC7633" @click="ruta('ver_mas_emprendedores_mes')" variant="link">Ver mas..</b-button>

				<b-button v-if="this.$auth.check()"  style="color:#DC7633" @click="ruta('pm_ver_mas_emprendedores_mes')" variant="link">Ver mas..</b-button>
				</h5>
				 <b-card class="mi-card">	
					<div class="containerx inline">
						<div v-for="d in e_mes" :key="d.user_id" class="item inline-item">
							<div class="product-image-wrapper-scroll">
								<div class="single-products">
									<div class="productinfo text-center">
										<img  style="width:60px; height:50px; border-radius: 10px;" :src="d.avatar" alt="" />
										<h6>{{d.nombre+'kk'}}</h6>
										<b-badge class="badgex">{{d.categoria}}</b-badge><br>
										<p>{{d.contacto}}</p>
															
															
										<b-button @click="conocer(d.user_id)" class="float-center btn-fw" size="sm" variant="outline-dark">Conocer</b-button>
									</div>
																
								</div>
							</div>
						</div>
	
				 	</div>
				 </b-card>	
				</b-col>
			</b-row>
			<hr> 
			
			<h5 class="txt-linea-nada"><label style="color:#EB984E;"> > </label> Publicaciones de emprendedores 
			<b-button v-if="!this.$auth.check()" style="color:#DC7633" @click="ruta('ver_mas_emprendedores_mes')" variant="link">Ver mas..</b-button>
			
			<b-button v-if="this.$auth.check()" style="color:#DC7633" @click="ruta('pm_ver_mas_emprendedores_mes')" variant="link">Ver mas..</b-button>
			</h5>
			<!-- <hr> -->
			<b-row>
				<b-col md="3">
					<b-navbar class="mi-card"  style="background: rgb(176,58,46);
background: linear-gradient(90deg, rgba(176,58,46,1) 0%, rgba(155,89,182,1) 31%, rgba(155,89,182,1) 31%, rgba(236,112,99,1) 86%, rgba(231,76,60,1) 99%);" toggleable="lg" >
							<b-navbar-brand href="#"><small style="color:white">Publicaciones destacadas</small></b-navbar-brand>
					</b-navbar>
					<b-card class="mi-card" no-body>
						<b-card-img src="https://cdn.sitly.com/blogs/es/2018/08/manualidades-con-tubos-de-cart%C3%B3n-para-ni%C3%B1os-animales.jpg"></b-card-img>
						<b-card-text style="margin:5px;">
							Manualidades hechas a mano si o no raza
						</b-card-text>
					</b-card>
					<br>
					<b-card class="mi-card" no-body>
						<b-card-img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcT1o4ukpcKLFpH1y12Q-a8i5B6EbF1_kBIeew&usqp=CAU"></b-card-img>
						<b-card-text style="margin:5px;">
							Manualidades hechas a mano si o no raza 2.0
						</b-card-text>
					</b-card>
				</b-col>
				<b-col xs="12" md="9">
					<!-- aqui algo arriba -->
				<div id="mi-scroll" style="width: 100%;
							height: 600px;
							overflow-y: scroll;
							scrollbar-width: thin;" >
					
					<div v-if="d < pm_publicaciones.length" v-for="d in pm__publicaciones" :key="d.user_id">
						
								
								<div class="single-products">
									
									<b-card no-body class="overflow-hidden mi-card">
										<p style="margin:10px;"><b-avatar :src="pm_publicaciones[d].avatarback" size="2rem"></b-avatar> <small style="color:#A569BD">{{pm_publicaciones[d].nombre}}</small> - <small style="color:#ABB2B9" ><i class="far fa-clock"></i> {{ pm_publicaciones[d].created_at }}</small></p>
										<b-row no-gutters>
											<b-col md="6">
												<b-card-img :src="pm_publicaciones[d].foto" alt="Image" class="rounded-0"></b-card-img>
											</b-col>
											<b-col md="6">
												<b-card-body style="color:#4A235A" :title="pm_publicaciones[d].texto">
												<b-card-text>
													
													
													<b-button class="float-center btn-fw" size="sm" variant="outline-dark">Guardar</b-button>
												</b-card-text>
											    </b-card-body>
											</b-col>
										</b-row>
									</b-card>



									<!-- <b-card>
										<div class="text-center">
											<img style="width:80px; height:80px; border-radius: 10px;" :src="d.avatar" alt="" />
											<h6>{{d.nombre}}</h6>
											<b-badge class="badgex">{{d.categoria}}</b-badge><br>
											<p>{{d.contacto}}</p>
											
											
											<b-button class="float-center btn-fw" size="sm" variant="outline-dark">Conocer</b-button>
										</div>
									</b-card>			 -->
								</div>
						
						<br>
					</div>	
						<div v-if="pm__publicaciones < pm_publicaciones.length || pm_publicaciones.length > pm__publicaciones">
						<b-button @click="mostrar_mas">Ver mas.. <b-spinner v-if="more" small></b-spinner>  </b-button>
					</div>	
				</div>	
						
					
				</b-col>

				
			</b-row>

		</b-col>

		<b-col xs="12" md="3" class="mi-card" v-if="device==false">
			<img src="data:image/jpeg;base64,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" alt="">
			<hr>
			<h5><label style="color:#58D68D"> > </label> Publicaciones de usuarios</h5>
			

			<div style="width: 100%;
							height: 500px;
							overflow-y: scroll;
							scrollbar-width: thin;" >
				<div v-if="pu < publicaciones.length"  v-for="pu in commentsToShow" :key="pu">
					<b-card class="mi-card">
						<b-row>
							<b-col xs="2" md="3"><b-avatar :src="publicaciones[pu].avatar"></b-avatar></b-col>
							<b-col xs="10" md="9"><b>{{publicaciones[pu].nombre}}</b></b-col>
						</b-row>

						<b-row>
							<b-col xs="12" md="12"><br>
								{{publicaciones[pu].texto}}
							</b-col>
						</b-row>
						<small class="float-right" style="color:#B2BABB">{{pu.created_at}}</small>
					</b-card>
					<br>
				</div>
				<div v-if="commentsToShow < publicaciones.length || publicaciones.length > commentsToShow">
					<b-button @click="commentsToShow += 3">Ver mas..</b-button>
				</div>
			</div>
		</b-col>
		<!-- <b-col xs="12" md="1">
			<img src="https://i.ytimg.com/vi/8WyXhGUz0w8/maxresdefault.jpg" style="width:100%" alt="">
		</b-col> -->
	</b-row>

	

	

	</div>
</template>
<script type="text/javascript">

	//import Autocomplete from 'vuejs-auto-complete'
	import LinkPrevue from 'link-prevue'
	import Autocomplete from 'vue2-autocomplete-js'
	export default{
		data(){

			return{
				ver:false,
				loc:true,
				see:false,
				emotic:'',
				comments:{},
				locate:'',
				dialogImageUrl: '',
        		dialogVisible: false,
        		fileList:[],
        		fotoculia:'',
        		data: new FormData(),
        		imageUrl: '',
        		yo: this.$auth.user(),
        		laUrl:'',
        		otros_usuarios:{},
				btns:{},
				

				e_mes:{},
				categorias:{},

				publicaciones:{},
				pm_publicaciones:{},



				reviews: [
					{name: 'Derek', description: 'Some comment'}, 
					{name: 'Joe', description: 'Some comment'},
					{name: 'Mike', description: 'Some comment'}, 
					{name: 'Ron', description: 'Some comment'},
					{name: 'Dii', description: 'Some comment'}, 
					{name: 'Lonnie', description: 'Some comment'},
					{name: 'Paul', description: 'Some comment'}, 
					{name: 'Mike', description: 'Some comment'},
					{name: 'Jody', description: 'Some comment'}, 
					{name: 'Ryn', description: 'Some comment'},
					{name: 'Jord', description: 'Some comment'}, 
					{name: 'Milly', description: 'Some comment'},
					{name: 'Judy', description: 'Some comment'}, 
					{name: 'Vanilly', description: 'Some comment'},
					{name: 'Nolan', description: 'Some comment'}, 
					
					
					{name: 'Pino', description: 'Some comment'},
					{name: 'Ryne', description: 'Some comment'}, 
					{name: 'Scott', description: 'Some comment'},
					{name: 'Son', description: 'Some comment'}, 
					{name: 'Bann', description: 'Some comment'},
					],
				commentsToShow: 3,
				totalComments: 0,
				pm__publicaciones:5,
				more:false,
				device:false,
        		
			}
		},
		 components: {
		    Autocomplete,
		    LinkPrevue
		  },
		created(){
			// this.getComents();
			// this.getUbicacion();
			// this.amigos_encomun()
			this.get_emprendedores_mes();
			this.get_categorias();
			this.get_publicaciones();
			this.get_pm_publicaciones();
			//this.auto();
		},
		mounted(){
			console.log(document.getElementById('mi-scroll').scrollTop)

			Echo.private('notificar_solicitud.'+this.yo.id).listen('NotificarSolicitudEvent', (e) => { 
         		 
                 this.amigos_encomun();               
          	});
          	Echo.private('notificar_solicitud_cancel.'+this.yo.id).listen('NotificarSolicitudEvent', (e) => {
          		 this.amigos_encomun();  
			  });
			  
			  this.totalComments = this.reviews.length
			  if(this.isMobile()){
				  this.device = true;
			  }else{
				  this.device = false;
			  }
		},
		methods:{

			get_emprendedores_mes(){
				var cant = 7;
				axios.get('api/emprendimientos_mes/'+cant).then((res)=>{
					if(res.data.estado == 'success'){
						this.e_mes = res.data.response;
					}
				});
			},
			get_categorias(){
				axios.get('users/categorias').then((res)=>{
					
						this.categorias = res.data;
					
				});
			},

			add(even){
				console.log(even);
				this.emotic = this.emotic+''+even.native;
			},
			submit(){
				axios.post('api/auth/comment', {text:this.emotic, url: this.laUrl}).then((response) =>{
					this.getComents();
					this.emotic = '';
				})
			},
			getComents(){
				
				
				if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
					this.device = true;
					axios.get('api/auth/comment').then((response) =>{
						this.comments = response.data;
						console.log(response.data)

					})
				} 
				
					
			},
			getUbicacion(){
				axios.get('geoip/1').then((response) =>{
					var r = response.data;
					this.locate = "Conectado desde "+r.ciudad+', '+r.region+' de '+r.pais;
					console.log(response.data)
					this.loc = false;
				})	
			},
			handleRemove(file, fileList) {
		     
		        this.change(file, fileList);
		      },
		      handlePictureCardPreview(file) {
		        this.dialogImageUrl = file.url;
		        this.nombreFoto = file.url;
		        this.dialogVisible = true;
		        alert(this.dialogImageUrl)
		      },
		      getFotos(){
		      	
		      	var form = document.querySelector("#form1");
		    

		      	axios.post('api/auth/jsonfoto', new FormData(form),{
		      		headers:{
		      			'content-Type': 'miltipart/form-data'
		      		}
		      	}).then((response) =>{
					
					console.log(response.data)
					
				})
		      },
		      change(file, fileform){
					this.fotoculia = fileform;
		      },
		      
		      handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
	      beforeAvatarUpload(file) {
	        const isJPG = file.type === 'image/jpeg';
	        const isLt2M = file.size / 1024 / 1024 < 2;

	        if (!isJPG) {
	          this.$message.error('Avatar picture must be JPG format!');
	        }
	        if (!isLt2M) {
	          this.$message.error('Avatar picture size can not exceed 2MB!');
	        }
	        return isJPG && isLt2M;
	      },
	       amigos_encomun(){
	        axios.get('api/auth/get_amigos_en_comun').then((res)=>{
	          this.otros_usuarios = res.data;
	          
	        })
	      },
	      auto(){
	      	axios('api/auth/users/autocomplete').then((response)=>{
	      		console.log(response.data);
	      	})
	      },
	      renderChild(data) {
		    return `
		    	<el-row>
		      	<el-col :span="2">
		      		<img class="avatar_index" src="${data.avatar}" />
		      	</el-col>

		      	<el-col :span="22">
		      		<span>${data.nombres}</span>
		      	</el-col>
		      </el-row>
		      
		    `
		  },
		  seguir($id_user, $i, $nombre){
		  	//seguir al usuario

		  		axios.post('api/auth/solicitud', {num:1, id_acepta:$id_user}).then((response) =>{
		  			this.$notify({
			          title: 'Sigues ahora a',
			          message: 'h2'+$nombre+''
			        });
					this.amigos_encomun();
					
				})
		  		
		  	
		  	
		  	//this.verify[$i] = !this.verify[$i];
		  	//this.btns[$i] = "Cancelar"
		  	console.log($("#btns"+$i))
		  },


		  get_publicaciones(){
			  if(this.isMobile()){
				  this.device = true;
			  }else{
				  this.device = false;
				  axios.get('api/traer_publicaciones').then((res)=>{
					if(res.data.estado == 'success'){
						this.publicaciones = res.data.data;
					}
				})
			  }
				
		  },
		  get_pm_publicaciones(){
			
			
				var categ="todo";
				axios.get('api/traer_pm_publicaciones/'+categ).then((res)=>{
					if(res.data.estado == 'success'){
						this.pm_publicaciones = res.data.data;
					}
				})
			  
		  },

		  conocer(id){

			  if(this.$auth.check()){

				  this.url_params('pm_emprendimiento',{id:id});

			  }else{

				  this.url_params('emprendimiento',{id:id});

			  }
		  },

		  mostrar_mas(){
			  this.more=true;
			  this.pm__publicaciones += 3; 
			  this.more=false;
			//   console.log(document.getElementById('mi-scroll').scrollTop)
			//   document.getElementById('mi-scroll').scrollTop =1000;
			//   var element = document.getElementById('mi-scroll');
			//      element.scrollTop = element.scrollHeight - element.clientHeight;

			var ele   = $('#mi-scroll');
			var speed = 10, scroll = 50, scrolling;

		
				// ele.scrollTop(ele.scrollTop() + scroll);
				ele.scrollTop( ele.scrollTop() - scroll );
			

			
			  
			  
		  },
		  isMobile() {
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				return true
			} else {
				return false
			}
		},

		  ruta(ruta){
                this.$router.push('/'+ruta);
            },
            url_params(name, json){
                this.$router.push({name:name, params:json}).catch(error => {
                    if (error.name != "NavigationDuplicated") {
                        throw error;
                    }
                });
            }

	  }
	}
</script>

<style type="text/css">
	.txtarea{
		margin-left: 1%;
		width: 100%;
		height: 65px;
    	border-left: 0;
    	border-right: 0;
    	border-top: 1px solid #E5E8E8;
    	border-bottom: 1px solid #E5E8E8;
	}
	.boxuser{
		border: 1px solid #D5DBDB;
		margin-right: 5%;
		margin-top: 3%;
		border-radius: 5px;
	}
	.boxhead{
		padding: 5px;
		background: #FBFCFC;
		border-bottom: 1px solid #D6DBDF;
	}
	.boxcontent{
		padding: 20px;
	}
	.boxfoot{
		padding: 5px;
		background: white;
		border-top: 1px solid #D6DBDF;
	}
	.avatar_index{
		height: 25px;width: 25px; border-radius: 30px;
	}
	.subox{
		background: #F8F9F9;
		padding: 5px;
		border-radius: 5px;
	}
	.image-upload > input
	{
	    display: none;
	}
	.fotoindex{
		height: 100%;
		width: 100%;
	}

	.span6 {
	  float: left;
	  width: 100%;
	  padding-left: 10%;
	}
	.emojionearea-editor:not(.inline) {
	  min-height: 8em!important;
	}
	.ta_coment{
		width: 100%;
	    	border-left: 0;
	    	border-right: 0;
	    	border-top: 1px solid #E5E8E8;
	    	border-bottom: 1px solid #E5E8E8;
	}
	.burbuja{
		padding: 5px;
		margin-top: 2px;margin-bottom: 2px;
		background: #F2F3F4;
		border-radius: 12px;
	}
	.txtarea{
		position: absolute;
		margin-left: 5px;
		width: 70%;
		height: 65px;
    	border-left: 0;
    	border-right: 0;
    	border-top: 1px solid #E5E8E8;
    	border-bottom: 1px solid #E5E8E8;
	}

	@media (min-width: 991px) {
		.product-image-wrapper-scroll{
			background: white;
			width: 100%;
			float:left;
			/* border:2px solid #E5E8E8; */
			overflow: hidden;
			margin:2px;
		
		}

		.product-image-wrapper{
			background: white;
			width: 25%;
			float:left;
			border:1px solid #E5E8E8;
			overflow: hidden;
			
		}
	}

    
	.single-products {
	position: relative;
	}

  /* General */
/* .main {
  border: 3px solid #236AB9;
  background-color: #D4E4F7;
  height: 400px;
  width: 400px;
} */

.containerx {
  
  width: 100%;
  height: 220px;
  /* border: 2px solid #341C09; */
  white-space: nowrap;
}

.item {
  /* border: 2px solid #B85B14;
  background-color: #FC7307;
  width: auto; */
}

/* Inline-block */
.inline {
  vertical-align: middle;
  overflow-x: scroll; 
   line-height: 1em;
}
.inline::-webkit-scrollbar {
    -webkit-appearance: none;
}
.inline::-webkit-scrollbar:vertical {
    width: 11px;
}

.inline::-webkit-scrollbar:horizontal {
    height: 11px;
}

.inline::-webkit-scrollbar-thumb {
    border-radius: 8px;
    border: 2px solid white; /* should match background, can't be transparent */
    background-color: rgba(0, 0, 0, .5);
}

.inline-item {
  display: inline-block;
  vertical-align: middle;
  border: 1px solid #EAECEE;
  margin:3px;
  /* height: 96px;
  margin-right: -4px; */
}


/* Flex */
.flex {
  display: flex;
  flex-wrap: nowrap; 
  overflow: auto;
}
.flex-item {
  flex: 0 0 auto;
}



.btn-fw{
	background: #A569BD;
	color:white;
	margin-bottom: 3px;
	border: 1px solid #EB984E;
}
.btn-fw:hover{
	background: #EC7063;
	border: 1px solid #EB984E;
	
}
.txt-linea{
	text-decoration: underline;
  -webkit-text-decoration-color:  #E18728;
  text-decoration-color: #E18728;
  line-height: 2.2;
  
}

.productinfo.text-center {
    padding: 7px;
}

.badgex{
	background: #EB984E;
}
 hr {
    background-image: linear-gradient(90deg,#ff8a00,#e52e71);
    border: 0;
    display: block;
    width: 100%;
    height: 4px;
    border-radius: 4px;
    
}







</style>