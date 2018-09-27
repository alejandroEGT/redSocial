<template>
	<div style="margin-top:15px;">
		
		<el-row>
			<el-col :span="13">
				<el-row>
					<el-col :span="2" >
						<img  class="img-avatar pull-right"  :src="this.$auth.user().avatar">
					</el-col>
					<el-col :span="15">
						<form>
							<el-popover
							  ref="popover2"
							  placement="bottom"
							  title="Title"
							  width=""
							  trigger="click"
							  >
							  <picker :i18n="{ search: 'Buscar', categories: { search: 'Résultats de recherche', recent: 'Emojis' } }" set="facebook"  @click="add" />
							</el-popover>
							<el-popover
							  ref="popover3"
							  placement="bottom"
							  title="Title"
							  width=""
							  trigger="click"
							  >
							  <input type="url" class="form-control" v-model="laUrl" name="">
							  <hr>
							  <link-prevue :url="laUrl"></link-prevue>
							</el-popover>
							<textarea class="txtarea" placeholder="Que estas pensando?" v-model="emotic" ></textarea>
							<!--<div class="row"> 
								  <div class="span6">
								    <textarea  placeholder="Que estas pensando?"  class="txtarea" id="emojionearea1"></textarea>
								  </div>
							</div>-->
							<br>
							<button type="button" class="btn btn-sm btn-outline-success" v-popover:popover2>
								<i class="fas fa-smile" ></i> Emoji
							</button>
							<button type="button" class="btn btn-sm btn-outline-primary" v-popover:popover3>
								<i class="fas fa-link" ></i> Enlace
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
							
							
						</form>
					</el-col>
				</el-row>
				<br>

				<div class="boxuser" v-for="com in comments">
					<el-row >
						<el-col class="boxhead" :span="24">
							<p><img class="avatar_index" :src="com.avatar"> <a :href="'#/search/'+com.id_user">{{com.nickname}}</a> <small> {{com.created_at}}</small> </p>
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
					<el-row>
						<el-col class="boxfoot " :span="24">
							<el-row>
								<el-col :offset="10" :span="2">
									<i class="far fa-thumbs-up"></i> 20
								</el-col>

								<el-col :span="2">
									<a  data-toggle="collapse" :href="'#collapseExample.'+com.id" role="button" aria-expanded="false" :aria-controls="'collapseExample.'+com.id"><i class="far fa-comment"></i> 5</a>
								</el-col>
								<el-col :span="2">
									<a data-toggle="modal" :data-target="'#exampleModal.'+com.id">
									  <i class="fas fa-share-alt"></i>
									</a>

									<!-- Modal -->
									<div class="modal fade" :id="'exampleModal.'+com.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
											<autocomplete
											    url="/users/autocomplete"
											    anchor="nombres"
											    label="email"
											     :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
    												placeholder="placeholder"
											     :onShouldRenderChild="renderChild"
											    >
											  </autocomplete>
											  <link-prevue url="http://localhost:8000/#/index"></link-prevue>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									        <button type="button" class="btn btn-primary">Save changes</button>
									      </div>
									    </div>
									  </div>
									</div>
								</el-col>
							</el-row>
							
								<el-row >
								<el-col :span="24">
									<div class="collapse" :id="'collapseExample.'+com.id">
									  <div class="card card-body">
									  	<el-row>
									  		<el-col :offset="3" :span="20">
									  			<el-row class="burbuja" >
									  				<el-col :span="2">
									  					<img class="avatar_index" :src="com.avatar">
									  				</el-col>
									  				<el-col :span="22">
									  					esto es un comentario jajajaja
									  				</el-col>
									  			</el-row>

									  			<el-row class="burbuja" >
									  				<el-col :span="2">
									  					<img class="avatar_index" :src="yo.avatar">
									  				</el-col>
									  				<el-col :span="22">
									  					asi es soy un comentario XD
									  				</el-col>
									  			</el-row>
									  		</el-col>
									  	</el-row>
									  	<el-row>
									  		<el-col :span="2">
									  			<img class="avatar_index" :src="yo.avatar">
									  		</el-col>
									  		<el-col :span="22">
									    		<textarea class="ta_coment" placeholder="Comentar..." ></textarea>
									    	</el-col>
									    </el-row>	
									  </div>
									</div>
								</el-col>
							</el-row>
							
						</el-col>
					</el-row>
				</div>
			</el-col>
			<el-col :span="5">
				<div class="subox" >
					<el-card class="box-card">
                    <div slot="header" class="clearfix">
                      
                      <el-button style="float: left;" type="text">Operation button</el-button>
                    </div>
                    <div v-for="o in otros_usuarios" class="text item">
                        <img class="img-avatar" :src="o.avatar">
                        {{ ' '+o.nombres+' '+o.apellidos }}
                         <center>
                         <button style="margin-top:3px" type="button" class="btn btn-sm btn-block btn-outline-dark">Agregar</button>
                         </center>
                        <hr>
                    </div>
                  </el-card>
					<!-- <label v-loading="loc" style="font-size:12px" >
					<i class="fas fa-map-marker-alt"></i>	{{ locate }}
					</label> -->
				</div>
			</el-col>
		</el-row>	
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
        		otros_usuarios:{}
			}
		},
		 components: {
		    Autocomplete,
		    LinkPrevue
		  },
		created(){
			this.getComents();
			this.getUbicacion();
			this.amigos_encomun()
			//this.auto();
		},
		methods:{
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
				
				axios.get('api/auth/comment').then((response) =>{
					this.comments = response.data;
					console.log(response.data)

				})
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
</style>