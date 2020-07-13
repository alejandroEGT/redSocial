<template>
	<div style="background:#F4F6F6">
		<p>inicio <label style="color:#58D68D">></label> perfil</p>
		
		<b-row>
			<b-col md="7">
				<b-card bg-variant="light" >
					<b-button v-b-modal.modal-1 size="sm" class="float-right" variant="outline-dark">Editar</b-button>
					<b-modal hide-footer id="modal-1" title="Editar perfil">
						<label for="">Logo (png, jpg):</label>
						<b-form-file size="sm" ref="cony" id="cony" @change="captar_logo"   placeholder="Seleccione un logo"></b-form-file>
						<label for="">Nombre completo:</label>
						<b-input size="sm" v-model="nombre_nick" ></b-input>
						<label for="">Nombre pyme:</label>
						<b-input size="sm" v-model="nombre_pyme" ></b-input>
						<label for="">Email:</label>
						<b-input size="sm" v-model="email" ></b-input>
						<label for="">Contacto:</label>
						<b-input size="sm" v-model="contact" ></b-input>
						<label for="">Dirección</label>
						<b-input size="sm" v-model="direccion" ></b-input>
						<label for="">Enlace de mi web</label>
						<b-input size="sm" v-model="url_web"></b-input>
						<label for="">Enlace de facebook</label>
						<b-input size="sm" v-model="url_facebook" ></b-input>
						<label for="">Enlace instagram</label>
						<b-input size="sm" v-model="url_instagram" ></b-input>
						<br>
						<label for="">Descripción de tu pyme o emprendimiento:</label>
						<b-form-textarea
							id="textarea"
							v-model="descripcion"
							placeholder="Detallar..."
							rows="3"
							max-rows="6"
							></b-form-textarea>
						<br>
						<b-button @click="editar_perfil">Editar información</b-button>
					</b-modal>
					<el-row>
					<el-col xs="3" md="3">
						<!-- <b-avatar :src="data_p.avatar" size="6em"></b-avatar> -->
						<img :src="data_p.avatarback" style="width:20%" alt="">
						
					</el-col>
					<el-col xs="9" md="9">
						
						<b style="font-size:27px; margin-left:25px; " > {{data_p.nombre_pyme}}</b>
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
									<label><b>{{ data_p.nombre_nick }}</b></label>
									<br>
									<label for="">Email:</label>
									<label><b>{{ data_p.email }}</b></label>
									<br>
									<label for="">Dirección:</label>
									<label for=""><b>{{direccion}}</b></label>
								</b-col>

								<b-col xs="6" md="6" >
									<p>{{ contact }}</p>
									<a target="_blank" :href="url_web">{{url_web}}</a>

									<label v-if="url_facebook!=''"><a target="_blank" :href="url_facebook"><i class="fab fa-facebook-square fa-2x"></i></a>  <label v-if="url_instagram!=''"><a target="_blank" :href="url_instagram"><i class="fab fa-instagram fa-2x"></i></a></label></label>

									
								</b-col>
							</b-row>
							<br>
							<h5 style="color:#AEB6BF; text-decoration-line: underline;">Descripción de la pyme o emprendimiento</h5>
							<b-row>
								<b-col xs="12" md="12">
									<p>{{descripcion}}</p>
								</b-col>
							</b-row>
						</b-card-text>
						</b-card>
					
					</b-card-text>
					
				</b-card>
			</b-col>
		</b-row>
		
		
			
			
		
	</div>
</template>

<script type="text/javascript">

	export default{
		data(){
			return {
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
				nombre_pyme: this.$auth.user().nombre_pyme,
				nombre_nick: this.$auth.user().nombre_nick,
				direccion:'',
				descripcion:'',
				logo:null,
				url_web:''


				
			}
		},
		created(){
			this.contacto();
		},
		methods:{
			captar_logo(event){
				
				this.logo = event.target.files[0];
			},
			contacto(){
				axios.get('api/auth/contacto').then((res)=>{
					this.contact = res.data.contact;
					this.url_facebook = res.data.url_facebook;
					this.url_instagram = res.data.url_instagram;
					this.direccion = res.data.direccion;
					this.descripcion = res.data.descripcion;
					this.url_web = res.data.url_web;
				});
			},

			editar_perfil(){

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
  
  &:hover {
     cursor: pointer;
     background: #000;
  }
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
</style>