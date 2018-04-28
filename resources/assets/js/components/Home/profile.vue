<template>
	<div>
		<h4>perfil</h4>

		
			<el-row>
				<el-col :span="4" >
					<form method="POST" id="form1" enctype="multipart/form-data">
						<div class="file-upload" v-loading="img_load">
						 	<img accept="image/*" :src=" foto " class="update_foto"  >
						    <label for="upload" v-loading="load_upload" class="file-upload__label">Cambiar foto</label>
						    <input  @change="handlePreview" id="upload" name="foto"  class="file-upload__input" type="file"  >
						</div>
					</form>	
				</el-col>
				<el-col :span="10">
					
					<form id="form2">
						<label>Nombre</label>
						<el-row>
							<el-col :span="15">
								<input type="hidden" name="id_projecto" :value="$route.params.id" >
								<!--<input type="" name="nombre" :value="name">-->
								<el-input @change="changeValue" placeholder="Nombre" name="nombre" v-model="name"></el-input>
							</el-col>
							<el-col :span="2" v-if="seeBtn" >
								<el-button @click="onSubmitName">Update</el-button>
							</el-col>
						</el-row>
					</form>	
					
				</el-col>
			</el-row>

			
		
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
				
			}
		},
		created(){
			
		},
		methods:{
		
			
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
  color: #fff;
  background: #222;
  border-radius: .4em;
  transition: background .3s;
  
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

}
</style>