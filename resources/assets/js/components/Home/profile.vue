<template>
	<div style="background:white;">
		<br><br><br>
		
		
		<b-row class="justify-content-center">
			<b-col md="8" xs="12">
				<!-- <h5><label style="color:#ABB2B9">Inicio</label> <label style="color:#EB984E"> > </label> Perfil.</h5> -->
				<b-card v-if="datos.rol_id==2" class="mi-card">
					<b-button  v-b-modal.modal-2 variant="light"><i class="fas fa-lightbulb"></i> Crear emprendimiento</b-button>
					<b-modal hide-footer id="modal-2" title="Crear mi emprendimiento">
							<label for="">Nombre de emprendimiento:</label>
							<b-input size="sm" v-model="nombre_empre" ></b-input>
							<label for="">Categoría:</label>
							<b-form-select v-model="categoria" :options="categorias" value-field="id" text-field="text">
								<template v-slot:first>
									<b-form-select-option :value="''" disabled>-- Seleccione categoria --</b-form-select-option>
								</template>
							</b-form-select>
							<label for="">Contacto:</label>
							<b-input size="sm" v-model="contact" ></b-input>
							<label for="">Dirección:</label>
							<b-input size="sm" v-model="direccion" ></b-input>
							<label for="">Enlace de mi web:</label>
							<b-input size="sm" v-model="url_web"></b-input>
							<label for="">Enlace de facebook:</label>
							<b-input size="sm" v-model="url_facebook" ></b-input>
							<label for="">Enlace instagram:</label>
							<b-input size="sm" v-model="url_instagram" ></b-input>
							<br>
							<label for="">Descripción de tu pyme o emprendimiento (Obligatorio):</label>
							<b-form-textarea
								id="textarea"
								v-model="descripcion"
								placeholder="Detallar..."
								rows="3"
								max-rows="6"
								></b-form-textarea>
							<br>
							
							<b-button  @click="crear_mi_emprendimiento">Crear mi emprendimiento</b-button>
					
					</b-modal>
				</b-card>
				<br>
				<b-card class="mi-card">
					<b-button v-b-modal.modal-1 size="sm" class="float-right" variant="outline-dark">Editar</b-button>
					<b-modal hide-footer id="modal-1" title="Editar perfil">
						<label for="">Logo (png, jpg):</label>
						<b-form-file size="sm" ref="cony" id="cony" @change="captar_logo"   placeholder="Seleccione un logo"></b-form-file>
						<label for="">Nombre completo:</label>
						<b-input size="sm" v-model="nombre_nick" ></b-input>
						<label v-if="datos.rol_id==1" for="">Nombre pyme:</label>
						<b-input v-if="datos.rol_id==1" size="sm" v-model="nombre_pyme" ></b-input>
						<label for="">Email:</label>
						<b-input size="sm" v-model="email" ></b-input>
						<label for="" v-if="datos.rol_id==1">Contacto:</label>
						<b-input v-if="datos.rol_id==1" size="sm" v-model="contact" ></b-input>
						<label v-if="datos.rol_id==1" for="">Dirección</label>
						<b-input v-if="datos.rol_id==1" size="sm" v-model="direccion" ></b-input>
						<label v-if="datos.rol_id==1" for="">Enlace de mi web</label>
						<b-input v-if="datos.rol_id==1" size="sm" v-model="url_web"></b-input>
						<label for="" v-if="datos.rol_id==1">Enlace de facebook</label>
						<b-input size="sm" v-if="datos.rol_id==1" v-model="url_facebook" ></b-input>
						<label for="" v-if="datos.rol_id==1">Enlace instagram</label>
						<b-input size="sm" v-if="datos.rol_id==1" v-model="url_instagram" ></b-input>
						<br>
						<label for="" v-if="datos.rol_id==1">Descripción de tu pyme o emprendimiento:</label>
						<b-form-textarea v-if="datos.rol_id==1"
							id="textarea"
							v-model="descripcion"
							placeholder="Detallar..."
							rows="3"
							max-rows="6"
							></b-form-textarea>
						<br>
						<b-button @click="editar_perfil(datos.rol_id)">Editar información</b-button>
					</b-modal>
					<el-row>
					<el-col xs="3" md="3">
						<!-- <b-avatar :src="data_p.avatar" size="6em"></b-avatar> -->
						<img :src="datos.avatarback" style="width:15%" alt="">
						
					</el-col>
					<el-col xs="9" md="9">
						
						<b style="font-size:27px; margin-left:25px; " > {{datos.nombre_emprendimiento}}</b>
						<!--  -->
					</el-col>
				</el-row>
					<br><br>
					<b-card-text>
						<b-card>
							<h5 style="color:#AEB6BF; text-decoration-line: underline;">Datos de contacto</h5>
						<b-card-text>
							<b-row>
								<b-col xs="6" md="6" >
									<label for="">Nombre:</label>
									<label><b>{{ datos.nombre_user }}</b></label>
									<br>
									<label for="">Email:</label>
									<label><b>{{ datos.email }}</b></label>
									<br>
									<label for="">Dirección:</label>
									<label for=""><b>{{datos.direccion}}</b></label>
								</b-col>

								<b-col xs="6" md="6" >
									<p>{{ datos.contacto }}</p>
									<a target="_blank" :href="datos.url_web">{{datos.url_web}}</a>

									<label v-if="datos.url_facebook!=''"><a target="_blank" :href="datos.url_facebook"><i class="fab fa-facebook-square fa-2x"></i></a>  <label v-if="url_instagram!=''"><a target="_blank" :href="url_instagram"><i class="fab fa-instagram fa-2x"></i></a></label></label>

									
								</b-col>
							</b-row>
							<br>
							<h5 style="color:#AEB6BF; text-decoration-line: underline;">Descripción de la pyme o emprendimiento</h5>
							<b-row>
								<b-col xs="12" md="12">
									<p>{{ datos.descripcion }}</p>
								</b-col>
							</b-row>
						</b-card-text>
						</b-card>
					
					</b-card-text>
					
				</b-card>
			</b-col>
		</b-row>

		
		<!-- <div v-viewer="viewerOptions">
			<slot>asdasdasda</slot>
			<img style="margin:10px;" v-for="image in images" :src="image.src" :key="image.src" :data-href="image.href" :alt="image.alt">
		</div> -->
		
			<!-- <b-card class="mi-card" v-for="g in gallery" :key="g.publicacion_id">
				<b-img :src="g.foto" alt="Image 1"></b-img>
				</b-card>
				<b-modal hide-header hide-footer id="modal-1" title="BootstrapVue">
					<p class="my-4">Hello from modal!</p>
				</b-modal> -->

				<br>
			<b-row class="justify-content-center">
			<b-col md="8" xs="12">

				<b-card class="mi-card">

				

							<div v-for="(d,i) in gallery" :key="d.publicacion_id" class="product-image-wrapper">
								
								<div class="single-products2">
									
											<!-- <h6>{{d.texto}}</h6> -->
											<img v-b-modal="'lol'+i" class="mi-img" :src="d.foto" alt="" />
											<div class="caption" >
												<div class="blur2"></div>
												<div class="caption-text2">
													<!-- <h1>Text</h1> -->
													<p style="margin-left:3px;"><i class="far fa-clock"></i> {{d.created_at}}</p>
													<b-modal size="lg" 
													header-bg-variant="dark"
													header-text-variant="white"
													hide-footer 
													hide-header
													:id="'lol'+i" 
													title="Certificado de conyuge">
															<b-card no-body class="overflow-hidden mi-card">
																<b-row no-gutters>
																<b-col md="6">
																	<b-card-img :src="d.foto" alt="Image" class="rounded-0"></b-card-img>
																</b-col>
																<b-col md="6">
																	<b-card-body :title="d.texto">
																	<b-card-text>
																		<i class="far fa-clock"></i> {{ d.created_at }}
																		<hr>
																		<b-button class="float-center btn-fw" size="sm" variant="outline-dark">Guardar</b-button>
																	</b-card-text>
																	</b-card-body>
																</b-col>
																</b-row>
															</b-card>
														</b-modal>
												</div>
											</div>
												
								</div>
								
								
							</div>
				</b-card>
			
			</b-col>
			</b-row>
		
		
			
			
		
	</div>
</template>

<script type="text/javascript">
	
	export default{
		data(){
			return {
				datos:{},
				img_load:false,
				load_upload: false,
				seeBtn:false,
				name:'',
				foto: this.$auth.user().avatar ,
				data_p: this.$auth.user(),

				url_facebook:'',
				url_instagram:'',
				contact:'',
				email: this.$auth.user().email,
				nombre_pyme: '',
				nombre_nick: this.$auth.user().nombre,
				direccion:'',
				descripcion:'',
				logo:null,
				url_web:'',
				nombre_empre:'',
				categoria:'',
				categorias:{},
				gallery:{},


				viewerOptions: {
					movable: false,
					rotatable: false,
					scalable: false,
					url: 'data-href',
					title(image, imageData) {
					// if want to show blank title, must use alt=" "
					return image.alt
					},
				},
				images: [
					{ src: 'https://picsum.photos/id/1/150/150', href: 'https://picsum.photos/id/1/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/2/150/150', href: 'https://picsum.photos/id/2/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/3/150/150', href: 'https://picsum.photos/id/3/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/4/150/150', href: 'https://picsum.photos/id/4/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/5/150/150', href: 'https://picsum.photos/id/5/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/6/150/150', href: 'https://picsum.photos/id/6/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/6/150/150', href: 'https://picsum.photos/id/6/800/800', alt: ' ' },
					{ src: 'https://picsum.photos/id/6/150/150', href: 'https://picsum.photos/id/6/800/800', alt: ' ' }
				]
				


				
			}
		},
		created(){
			this.galeria();
			this.contacto();
			this.datos_profile();
			this.get_categ();
		},
		methods:{
			galeria(){
				axios.get('api/galeria').then((res)=>{
					if(res.data.estado =='success'){
						this.gallery = res.data.data
					}
				});
			},
			get_categ(){
				axios.get('users/categorias').then((res)=>{
					this.categorias = res.data;
				})
			},
			crear_mi_emprendimiento(){
				var data = new FormData();

				data.append("nombre", this.nombre_empre);
				data.append("contacto", this.contact);
				data.append("direccion", this.direccion);
				data.append("url_facebook", this.url_facebook);
				data.append("url_instagram", this.url_instagram);
				data.append("descripcion", this.descripcion);
				data.append("categoria", this.categoria);
				// data.append("logo", this.logo);
				data.append("url_web", this.url_web);
				

				axios.post('api/auth/crear_mi_emprendimiento', data).then((res)=>{

				});
			},

			datos_profile(){
				axios.get('api/auth/datos_perfil').then((res)=>{
					this.datos = res.data.data[0];
				});
			},
			captar_logo(event){
				
				this.logo = event.target.files[0];
			},
			contacto(){
				axios.get('api/auth/contacto').then((res)=>{
					this.nombre_pyme = res.data.nombre;
					this.contact = res.data.contact;
					this.url_facebook = res.data.url_facebook;
					this.url_instagram = res.data.url_instagram;
					this.direccion = res.data.direccion;
					this.descripcion = res.data.descripcion;
					this.url_web = res.data.url_web;
				});
			},

			editar_perfil(rol_id){

				var data = new FormData();

				data.append("email", this.email);
				data.append("nombre_pyme", this.nombre_pyme);
				data.append("nombre_nick", this.nombre_nick);
				data.append("contacto", this.contact);
				data.append("direccion", this.direccion);
				data.append("url_facebook", this.url_facebook);
				data.append("url_instagram", this.url_instagram);
				data.append("descripcion", this.descripcion);
				data.append("logo", this.logo);
				data.append("url_web", this.url_web);
				data.append("rol", rol_id);
				

				axios.post('api/auth/editar_perfil', data).then((res)=>{

				});
			},
		
			
		      handlePreview(event) {
		        	this.onSubmitFoto();
		      },
		      changeValue(){
		      		this.seeBtn = true;
		      },

		      onSubmitFoto(){

		      	this.load_upload = true;
		      	var form = document.querySelector("#form1");

		      	axios.post('api/auth/user/updatefoto', new FormData(form)).then((res)=>{
		      		this.$message({
                      message: res.data,
                      type: 'success'
                    });
                    	this.foto = res.data;
		      			this.load_upload = false;
		      			
		      	}).catch((res)=>{
		      			 this.$message.error(res.response.data.message);
		      			 this.load_upload = false;
		      	});
		      },
		      onSubmitName(){
		      	var form2 = document.querySelector("#form2");
		      	axios.post('frontend/updateNameProject', new FormData(form2)).then((res)=>{

		      		console.log(res.data);
		      		this.$message({
                      message: res.data,
                      type: 'success'
                    });
		      		
		      			
		      	}).catch((res)=>{
		      			this.$message.error(res.response.data.message);
		      	});
		      }
		}
	}
</script>

<style type="text/css">
	.file-upload {
	position: relative;
	display: inline-block;
}

.file-upload__label {
	display: block;
    line-height: 2.2em;
    padding: 0 0.62em;
    border: 1px solid #666;
    border-radius: 0.25em;
    background-image: linear-gradient( to bottom, black, black );
    box-shadow: inset 0 0 0.1em #fff, 0.2em 0.2em 0.2em rgba( 0, 0, 0, 0.3 );
    font-family: arial, sans-serif;
    font-size: 0.8em;
	color:white;
  /* display: block;
  color: #fff; */
  /* background: #222;
  border-radius: .9em;
  transition: background .3s; */
  
  /* &:hover {
     cursor: pointer;
     background: #000;
  } */
}
    
.file-upload__input {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    font-size: 1;
    width:0;
    height: 100%;
    opacity: 0;
}
.update_foto{
	height: 80px;
	width:80px;
	border:4px solid rgb(56, 11, 11);

}

.nombre_text{
		margin-left:25px; 
		-webkit-text-fill-color: white;
		text-shadow: -1px -1px 1px #000, 1px 1px 1px #000, -1px 1px 1px #000, 1px -1px 1px #000;
}











	 .caption-style-3{
		height: 12rem;
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		
	}

	.caption-style-3 li{
		float: left;
		padding: 0px;
		position: relative;
		overflow: hidden;
	}

	.caption-style-3 li:hover .caption{
		opacity: 1;
		transform: translateY(-100px);
		-webkit-transform:translateY(-100px);
		-moz-transform:translateY(-100px);
		-ms-transform:translateY(-100px);
		-o-transform:translateY(-100px);
	}
	.single-products2{
		float: left;
		padding: 0px;
		position: relative;
		overflow: hidden;
	}

	.single-products2:hover .caption{
		width: 100%;
		opacity: 1;
		transform: translateY(-100px);
		-webkit-transform:translateY(-100px);
		-moz-transform:translateY(-100px);
		-ms-transform:translateY(-100px);
		-o-transform:translateY(-100px);
	} 
/* 
	.caption-style-3 li:hover img{
	
		opacity: 1;
		transform: translateY(-40px);
		-webkit-transform:translateY(-40px);
		-moz-transform:translateY(-40px);
		-ms-transform:translateY(-40px);
		-o-transform:translateY(-40px);

	} */


	/* .caption-style-3 img{
		margin: 0px;
		padding: 0px;
		float: left;
		z-index: 0;
	} */


	/* en este se ve el texto  */
	.caption-style-3 .caption{
		
		cursor: pointer;
		position: absolute;
		opacity: 0;
		top:200px;
		-webkit-transition:all 0.15s ease-in-out;
		-moz-transition:all 0.15s ease-in-out;
		-o-transition:all 0.15s ease-in-out;
		-ms-transition:all 0.15s ease-in-out;
		transition:all 0.15s ease-in-out;

	}
	.single-products .caption{
		
		cursor: pointer;
		position: absolute;
		opacity: 0;
		top:200px;
		-webkit-transition:all 0.15s ease-in-out;
		-moz-transition:all 0.15s ease-in-out;
		-o-transition:all 0.15s ease-in-out;
		-ms-transition:all 0.15s ease-in-out;
		transition:all 0.15s ease-in-out;

	}

	.caption-style-3 img{
		-webkit-transition:all 0.15s ease-in-out;
		-moz-transition:all 0.15s ease-in-out;
		-o-transition:all 0.15s ease-in-out;
		-ms-transition:all 0.15s ease-in-out;
		transition:all 0.15s ease-in-out;

	}
	.caption-style-3 .blur{
		background-color: rgba(0,0,0,0.7);
		height: 300px;
		width: 400px;
		z-index: 5;
		position: absolute;
	}

	.blur2{
		background-color: rgba(0,0,0,0.7);
		height: 300px;
		width: 400px;
		z-index: 5;
		position: absolute;
	}

	.caption-style-3 .caption-text h1{
		text-transform: uppercase;
		font-size: 18px;
	}
	.caption-style-3 .caption-text{
		z-index: 10;
		color: #fff;
		position: absolute;
		width: 400px;
		height: 300px;
		text-align: center;
		top:20px;
	}
	.caption-text2 h1{
		margin-left:3px;
		text-transform: uppercase;
		font-size: 18px;
	}
	.caption-text2{
		z-index: 10;
		color: #fff;
		position: absolute;
		/* width: 400px;
		height: 300px; */
		/* text-align: center; */
		/* top:20px; */
	}


	/** Nav Menu */
	ul.nav-menu{
		padding: 0px;
		margin: 0px;
		list-style-type: none;
		width: 490px;
		margin: 60px auto;
	}

	ul.nav-menu li{
		display: inline;
		margin-right: 10px;
		padding:10px;
		border: 1px solid #ddd;
	}

	ul.nav-menu li a{
		color: #eee;
		text-decoration: none;
		text-transform: uppercase;
	}

	ul.nav-menu li a:hover, ul.nav-menu li a.active{
		color: #2c3e50;
	} 
	/** content **/
	.content{
		margin-top: 100px;
		margin-left: 100px;
		width: 700px;
	}
	.content h1, .content h2{
		font-family: "Source Sans Pro",sans-serif;
		color: #ecf0f1;
		padding: 0px;
		margin: 0px;
		font-weight: normal;
	}

	.content h1{
		font-weight: 900;
		font-size: 64px;
	}

	.content h2{
		font-size:26px;
	}

	.content p{
		color: #ecf0f1;
		font-family: "Lato";
		line-height: 28px;
		font-size: 15px;
		padding-top: 50px;
	}

	p.credit{
		padding-top: 20px;
		font-size: 12px;
	}

	p a{
		color: #ecf0f1;
	}

	/** fork icon**/
	.fork{
		position: absolute;
		top:0px;
		left: 0px;
	}




	

	/* / Móviles en horizontal o tablets en vertical
   ------------------------------------------------------------------------- / */
	@media (min-width: 768px) {
		.mi-img{
			width:12rem; height:10rem; border-radius: 10px;
		}
	 }

	/* Móviles en vertical
   ------------------------------------------------------------------------- */
	 @media (max-width: 480px) {
		 .mi-img{
			width:100%; height:12rem; border-radius: 10px;
		}
	  }
	
	/* / Tablets en horizonal y escritorios normales
	------------------------------------------------------------------------- / */
	@media (min-width: 1024px) {
		.mi-img{
			width:13rem; height:12rem; border-radius: 10px;
		}
	 }
	
	/* / Escritorios muy anchos
	------------------------------------------------------------------------- */ 
	@media (min-width: 1200px) { 
		.mi-img{
			width:13rem; height:12rem; border-radius: 10px;
		}
	}


</style>