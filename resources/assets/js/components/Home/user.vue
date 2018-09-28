<template class="animated bounceOutLeft">
	<div class="row">
		<div class="col-md-10">
			<div v-loading="load_amigos">
				<el-row class="box_perfil" :style="{backgroundImage: 'url('+user.avatarback+')'}" >
					<el-col :span="4" :xs="12" v-loading="present">
						<img style="margin-left:20px" :src="user.avatar" class="img-thumbnail size">
					</el-col>
					<el-col :span="13" v-loading="present">
						<h4 class="nombre_text">
							{{ user.nom }} <small>{{ user.nick }}</small>
						</h4>
						<h5 class="nombre_text" >
							{{ user.email }}
						</h5>
					</el-col>
					<el-col :span="2" v-loading="load" >
						<div v-if="id != id_mio" >
							<div v-if="'3' != id_estado_solicitud">
								<div v-if="'1'!= id_estado_solicitud">
									<div v-if="txt == 'Aceptada'">
										<button type="button" class="btn btn-primary">{{eliminar}}</button>
									</div>
									<div v-if="txt == 'Agregar'">
										<button type="button" @click="sendSolicitud('3')" class="btn btn-success">{{txt}}</button>
									</div>
									<div v-if="txt == 'Enviada'">
										<button type="button" @click="sendSolicitud('2')" class="btn btn-danger">{{cancelar}}</button>
									</div>
									<div v-if="txt == 'Cancelada'">
										<button type="button" @click="sendSolicitud('3')" class="btn btn-success">{{agregar}}</button>
									</div>
								</div>	
								<div v-if="'1' == id_estado_solicitud">
									<button type="button" class="btn btn-primary">{{eliminar}}</button>
								</div>
							</div>	
							<div v-if="'3'== id_estado_solicitud">
								<button type="button" @click="aceptarSolicitud('1')" class="btn btn-warning">{{aceptar}}</button>
							</div>

						</div>	
					</el-col>
					<el-col :offset="4" :span="1">
						<el-tooltip v-if="id_mio == id" class="item" effect="dark" content="Cambiar foto de fondo" placement="bottom" data-toggle="modal" data-target="#exampleModalLong">
							<el-button type="text" style="color:black"><i class="fas fa-camera fa-2x"></i></el-button>
						</el-tooltip>	
					</el-col>
				</el-row>
				
				<el-tabs type="">
					  <el-tab-pane label="Muro">
					  	<el-row>
							<el-col :span="24">
								<div v-if="id != id_mio"  class="boxuser" >
									<div class="boxcontent">
										<el-row>
											<el-col :span="2" >
												<img  class="img-avatar pull-right"  :src="this.$auth.user().avatar">
											</el-col>
											<el-col :span="12">
												<form>
											<textarea class="txtarea" :placeholder="'Escribele algo a '+ user.nom " v-model="emotic" ></textarea>
											<br>
											<button type="button" class="btn btn-sm btn-outline-success" @click="ver = !ver;">
												<i class="fas fa-smile" ></i> Emoji
											</button>
											<button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#exampleModal" >
												<i class="fas fa-camera-retro"></i> Foto
											</button>

											<!-- Modal -->
											<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											  <div class="modal-dialog" role="document">
											  	<form method="POST" id="form1" enctype="multipart/form-data">
											    <div class="modal-content">
											      <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">
											        	<input type="hidden" name="id_projecto" value="1" >
											        	<textarea name="texto" class="txtarea" placeholder="Que estas pensando?" v-model="emotic" ></textarea>
														<br>
														
														<div class="image-upload">
															<input type="file" id="file-input" multiple  name="fotos[]">
														    <label for="file-input">
														        <i class="fas fa-camera-retro"></i>
														    </label>
														</div>
											        	

											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											        <button type="button" @click="getFotos" class="btn btn-primary">Publicar</button>
											      </div>
											    </div>
											</form>
											  </div>
											</div>


											<button @click="submit" type="button" class="btn  btn-outline-primary">
												<i class="fa fa-chevron-circle-right" ></i> Publicar
											</button>
											<div v-if="ver">
												<picker :i18n="{ search: 'Buscar', categories: { search: 'Résultats de recherche', recent: 'Emojis' } }" @click="add" />
											</div>
											
										</form>
											</el-col>
										</el-row>
									</div>
								</div>
							</el-col>
						</el-row>
				
					<el-row>
						<el-col :span="14">
							
							<div v-for="com in orderedCommens">
								

								<div v-if="com.id_user_envia == id_mio " class="boxuser" ><!--otro usuario-->

									<el-row>
										<el-col class="boxhead" :span="24">

											<p><img class="avatar_index" :src="com.avatarEnvia"> <strong>{{com.usuario_envia}}</strong>
											<i class="far fa-hand-point-right"></i>
											 <strong>{{com.usuario_recibe}}</strong></p>
										</el-col>
									</el-row>
									
									<el-row>
											<el-col class="boxcontent" :span="24">
												
												<p class="txt_public">{{ com.texto }}</p>
												<div v-if="com.foto">
													<img class="fotoindex" :src="com.foto">
												</div>

												<div v-if="com.url">
													<link-prevue cardWidth="100%" :url="com.url"></link-prevue>
												</div>
											
											</el-col>
										</el-row>
								</div>	





								<div v-if="com.id_user_envia != id_mio " class="boxuser" ><!-- si este usuario soy yo -->
									<div v-if="com.id_user">
										<el-row>
											<el-col class="boxhead" :span="24">
												<p><img class="avatar_index" :src="com.avatar"> <strong>{{com.nombres}}</strong>
												</p>
											</el-col>
										</el-row>
										
										<el-row>
												<el-col class="boxcontent" :span="24">
													
													<p v-if="!com.foto" class="txt_public">{{ com.texto }}</p>
													<p v-if="com.foto">{{ com.texto }}</p>
													<div v-if="com.foto">
														<img class="fotoindex" :src="com.foto">
													</div>
													<div v-if="com.url">
														<link-prevue cardWidth="100%" :url="com.url"></link-prevue>
													</div>

												
												</el-col>
										</el-row>
									</div>

									<div v-if="!com.id_user" >
										<el-row>
											<el-col class="boxhead" :span="24">
												<p><img class="avatar_index" :src="com.avatarEnvia"> <strong>{{com.usuario_envia}}</strong>
												<i class="far fa-hand-point-right"></i>
												 <strong>{{com.usuario_recibe}}</strong></p>
											</el-col>
										</el-row>
										
										<el-row>
												<el-col class="boxcontent" :span="24">
													
													<p class="txt_public">{{ com.texto }}</p>
													<div v-if="com.foto">
														<img class="fotoindex" :src="com.foto">
													</div>
													<div v-if="com.url">
														<link-prevue cardWidth="100%" :url="com.url"></link-prevue>
													</div>
												
												</el-col>
										</el-row>
									</div>	
								</div>
								<!--<div v-if="com.id_padre">
									<div class="boxuser">
										<el-row >
											<el-col class="boxhead" :span="24">
												<p><img class="avatar_index" :src="com.avatar"> {{com.nickname}} </p>
											</el-col>
										</el-row>
										<el-row>
											<el-col class="boxcontent" :span="24">
												
												<p>{{ com.texto }}</p>
												<div v-if="com.foto">
													<img class="fotoindex" :src="com.foto">
												</div>
											
											</el-col>
										</el-row>
										<el-row>
											<el-col class="boxfoot" :span="24">
												<el-row>
													<el-col :span="2">
														<i class="far fa-thumbs-up"></i> XX
													</el-col>

													<el-col :span="2">
														<i class="far fa-comment"></i> XX
													</el-col>
												</el-row>
											</el-col>
										</el-row>
									</div>
								</div>	-->
							</div>	
						</el-col>

						<el-col :span="9" >
							<center><h4>Información prsonal</h4></center>
							<el-card>
								
								<div style="margin:12px">
									<center>
											<img :src="usuario.avatar" class="img-avatar img-thumbnai">
											<p>{{ usuario.nombres+' '+usuario.apellidos }}</p>
											<p>{{usuario.nacimiento}}</p>
									</center>
								</div>
								
								
							</el-card>

							<center><h4>Amigos({{ amigos.length }})</h4></center>
							<el-card>
								<div v-for="a in amigos">
									<div style="margin:12px">
											<center>
												<img style="float: left" :src="a.avatar" class="img-avatar img-thumbnai">
											<!-- <p>{{ a.nombres+' '+a.apellidos }}</p> -->
											</center>
										</div>
								</div>
								<center ><p><a href="">Ver todos.....</a></p></center>
							</el-card>


							<center><h4>Fotos</h4></center>
							<div>
								<el-card>
									<img class="img img-thumbnail" style="float: left; height:100px" src="https://scontent.fscl13-1.fna.fbcdn.net/v/t1.0-9/10273497_716538648392293_5053026506898113399_n.jpg?_nc_cat=102&oh=b58f92ec01fddba5f0c7808470c3a239&oe=5C34BFB1">


									<img class="img img-thumbnail" style="float: left; height:100px" src="https://scontent.fscl13-1.fna.fbcdn.net/v/t1.0-9/s960x960/30715793_1777929625586518_814810494970888192_o.jpg?_nc_cat=100&oh=18f91ba31443c39f8c5b7aa00fb39da2&oe=5C197B00">

									<img class="img img-thumbnail" style="float: left; height:100px" src="https://scontent.fscl13-1.fna.fbcdn.net/v/t1.0-9/15727260_1298025420243610_7960077383706047310_n.jpg?_nc_cat=107&oh=40fdf2144e836aa2aee42ed5a7dcaa1d&oe=5C196F2A">

									<img class="img img-thumbnail" style="float: left; height:100px" src="https://scontent.fscl13-1.fna.fbcdn.net/v/t1.0-9/15622404_1294408573938628_175703704610286964_n.jpg?_nc_cat=104&oh=2de425760dedbed6b0c296c95275a1d5&oe=5C199A45">
							</el-card>
							</div>
						</el-col>
					</el-row>
			    </el-tab-pane>

		  			  <el-tab-pane label="Posteos dirigidos">
		  			  		<div v-for="com in dirigido" class="boxuser" >
								<el-row>
									<el-col class="boxhead" :span="24">
										<p><img class="avatar_index" :src="com.avatarEnvia"> <strong>{{com.usuario_envia}}</strong>
										<i class="far fa-hand-point-right"></i>
										 <strong>{{com.usuario_recibe}}</strong></p>
									</el-col>
								</el-row>
								
								<el-row>
										<el-col class="boxcontent" :span="24">
											
											<p>{{ com.texto }}</p>
											<div v-if="com.foto">
												<img class="fotoindex" :src="com.foto">
											</div>
										
										</el-col>
									</el-row>
							</div>
		  			  </el-tab-pane>
		  			  <el-tab-pane :label="amigos.length +' Amigos'">
					
							<div class="row justify-content-md-center">
								<div class="col-md-8">
									<div v-for="a in amigos">
										<div style="float: left; margin:30px">
											<center>
												<img :src="a.avatar" class="img-avatar">
											<p>{{ a.nombres+' '+a.apellidos }}</p>
											</center>
										</div>
									</div>
								</div>
							</div>
						
		  			  </el-tab-pane>
		 
				</el-tabs>


					<!-- Modal -->
					<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					       <form method="POST" id="formback" enctype="multipart/form-data">
					       		 <input type="file" name="foto"  class="file-upload__input">
					       		 <button type="button" @click="onSubmitFoto">Subir</button>
					       </form>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" class="btn btn-primary">Save changes</button>
					      </div>
					    </div>
					  </div>
					</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	
	import LinkPrevue from 'link-prevue'
	export default{
		data(){
			return{
				present: false,
				load: true,
				load_amigos:true,
				id: this.$route.params.id,
				id_mio: this.$auth.user().id,
				usuario:{},
				user:{},
				txt:'',
				cancelar : "Cancelar solicitud",
				eliminar :"Eliminar de mis amigos",
				agregar : "Agregar",
				aceptar: "Aceptar solicitud",
				comments:{},
				dirigido:{},
				emotic:'',
				ver:false,
				color: 'yellow',
				id_estado_solicitud:'',
				amigos:{},


			}
		},
		components: {
		  
		    LinkPrevue
		  },
		mounted(){
			this.getuser();
			this.getComment();
			this.getCommentTo();
			this.getDirigido();
			this.get_amigos();
			this.get_us();
		},
		computed: {
		  orderedCommens: function () {
		    return  _.orderBy(this.comments, 'created_at').reverse()
		    
		  }
		},
		methods:{
			add(even){
				this.emotic = this.emotic+''+even.native;
			},
			getuser(){
				this.present = true;
				axios.post('api/auth/getUserNews', {id: this.id}).then((response) =>{
					var r = response.data.user;
					this.user.nom = r.nombres+' '+r.apellidos;
					this.user.avatar = r.avatar;
					this.user.avatarback = r.avatarback;
					this.user.email = r.email;
					this.user.nick = "("+r.nickname+")";
					this.txt = response.data.verify;
					this.id_estado_solicitud=response.data.id_estado_solicitud;
					this.present =false;
					this.load = false;

				})
			},
			getComment(){

				axios.get('api/auth/comment/'+this.id).then((response)=>{
					this.comments = response.data;
				})
			},
			getCommentTo(){
				axios.get('api/auth/commentTo/'+this.id).then((response)=>{
					this.comments = response.data;
					console.log(response.data);
				})
			},
			getDirigido(){
				axios.get('api/auth/dirigido/'+this.id).then((response)=>{
					this.dirigido = response.data;
					console.log(response.data);
				})
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
		    submit(){
		    	var array={
					id_user_recibe: this.id,
					texto: this.emotic,
				}
				axios.post('api/auth/commentTo', array).then((response) =>{
					console.log(response.data)
					this.getComment();
				})
			},
			sendSolicitud($num){
				axios.post('api/auth/solicitud', {num:$num, id_acepta: this.id}).then((response) =>{
					console.log(response.data)
					this.getuser()
					
				})
			},
			aceptarSolicitud($num){
				axios.post('api/auth/aceptarSolicitud', {num:$num, id_acepta: this.id_mio, id_solicita: this.id}).then((response) =>{
					console.log(response.data)
					
				})	
			},
			get_amigos(){
				axios.get('api/auth/get_amigos/'+this.id).then((res)=>{
					this.amigos = res.data;
					this.load_amigos = false;
				});
			},
			 onSubmitFoto(){

		      	var form = document.querySelector("#formback");

		      	axios.post('api/auth/user/updatefotoback', new FormData(form)).then((res)=>{
		      		this.getuser()
		      			
		      	}).catch((res)=>{
		      			 
		      	});
		      },
		      get_us(){
		      	axios.get('api/auth/get_user/'+this.id).then((res)=>{
					this.usuario = res.data;
					
				});
		      }
		}
	}


</script>
<style type="text/css">
	.avatar{
		height: 120px;
		width: 100px;
	}
	.boxuser{
		border: 1px solid #D5DBDB;
	
		margin: 3%;
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
	.fotoindex{
		height: 100%;
		width: 100%;
	}
	.txtarea{
		margin-left: 5px;
		width: 350px;
		height: 65px;
    	border-left: 0;
    	border-right: 0;
    	border-top: 1px solid #E5E8E8;
    	border-bottom: 1px solid #E5E8E8;
	}
	.box_perfil{
		height: 370px;
		background-repeat: no-repeat;
		background-size: 100% 100%;
		padding-top: 15px;
		padding-bottom:200px;
	}
	.size{
		height:100% ;width:100%; 
	}
	.nombre_text{
		margin-left:25px; 
		-webkit-text-fill-color: white;
		text-shadow: -1px -1px 1px #000, 1px 1px 1px #000, -1px 1px 1px #000, 1px -1px 1px #000;
	}

</style>