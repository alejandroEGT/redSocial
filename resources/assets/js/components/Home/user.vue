<template class="animated bounceOutLeft">
	<div >
		<el-row class="box_perfil" :style="{backgroundImage: 'url('+user.avatarback+')'}" >
			<el-col :span="4" v-loading="present">
				<img :src="user.avatar" class="img-thumbnail size">
			</el-col>
			<el-col :span="10" v-loading="present">
				<h4 style="margin-left:10px">{{ user.nom }} <small>{{ user.nick }}</small></h4>
				<h5 style="margin-left:10px" >{{ user.email }}</h5>
			</el-col>
			<el-col :span="2" v-loading="load" >
				<div v-if="id != id_mio" >
					<div v-if="'3' != id_estado_solicitud">
						<div v-if="'1'!= id_estado_solicitud">
							<div v-if="txt == 'Aceptada'">
								<button type="button" class="btn btn-outline-primary">{{eliminar}}</button>
							</div>
							<div v-if="txt == 'Agregar'">
								<button type="button" @click="sendSolicitud('3')" class="btn btn-outline-primary">{{txt}}</button>
							</div>
							<div v-if="txt == 'Enviada'">
								<button type="button" @click="sendSolicitud('2')" class="btn btn-outline-primary">{{cancelar}}</button>
							</div>
							<div v-if="txt == 'Cancelada'">
								<button type="button" @click="sendSolicitud('3')" class="btn btn-outline-primary">{{agregar}}</button>
							</div>
						</div>	
						<div v-if="'1' == id_estado_solicitud">
							<button type="button" class="btn btn-outline-primary">{{eliminar}}</button>
						</div>
					</div>	
					<div v-if="'3'== id_estado_solicitud">
						<button type="button" @click="aceptarSolicitud('1')" class="btn btn-outline-primary">{{aceptar}}</button>
					</div>

				</div>	
			</el-col>
			<el-col :offset="7" :span="1">
				<el-tooltip class="item" effect="dark" content="Cambiar foto de fondo" placement="bottom">
					<el-button type="text" style="color:black"><i class="fas fa-camera fa-2x"></i></el-button>
				</el-tooltip>	
			</el-col>
		</el-row>
		
		<el-tabs type="border-card">
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
			<el-col :span="24">
				<hr>
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
									
									<p>{{ com.texto }}</p>
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
										
										<p>{{ com.texto }}</p>
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
										
										<p>{{ com.texto }}</p>
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
 
		</el-tabs>
	</div>
</template>

<script type="text/javascript">
	
	import LinkPrevue from 'link-prevue'
	export default{
		data(){
			return{
				present: false,
				load: true,
				id: this.$route.params.id,
				id_mio: this.$auth.user().id,
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
				id_estado_solicitud:''

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
	.fotoindex{
		height: 380px;
		width: 470px;
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
		background-repeat: no-repeat;
		background-size: 100% 100%;
		padding-top: 15px;
		padding-bottom:200px;
	}
	.size{
		height:100px ;width:180px; 
	}

</style>