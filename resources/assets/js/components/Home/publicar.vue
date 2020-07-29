<template>
	<div style=""><br><br><br>

	<b-row >
		<b-col xs="12" md="12">
			<b-row>
				<b-col md="12">
				<h5><label style="color:#ABB2B9">Inicio</label> <label style="color:#EB984E"> > </label> Publicar en un post
				</h5>
                <b-row class="justify-content-center">
                    <b-col md="6">
                        <b-card class="mi-card">
                           <b-row>
                               <b-col md="9">
                                   <p>Cuando envies tu publicación sera aceptada por los administradores, para mejor comunicación, deje un medio de contacto</p>
                               </b-col>
                               <b-col md="3">
                                   <img style="width:50px" src="https://upload.wikimedia.org/wikipedia/commons/0/0c/Message_%28Send%29.png" alt="">
                               </b-col>
                           </b-row>
                           <hr>
                          <b-row>
                               <b-col md="2">
                                   <img style="width:45px" :src="yo.avatar" alt="">
                               </b-col>
                               <b-col md="10">
                                    <b-form-select 
                                        v-model="selected_publicador" 
                                        :options="select_publicador" 
                                        @change="cambio_user"
                                        value-field="id"
                                        text-field="text"
                                        size="sm" class="mt-3"></b-form-select>
                               </b-col>
                           </b-row>
                            <br>
                           <b-form-textarea
                            id="textarea"
                            v-model="texto"
                            placeholder="Ingrese su publicación..."
                            rows="3"
                            max-rows="6"
                            ></b-form-textarea>
                            <br>
                            <div v-if="empresa">
                                <label for="">Logo (png, jpg):</label>
						    <b-form-file size="sm" ref="cony" id="cony" @change="captar_foto"   placeholder="Seleccione un logo"></b-form-file>

                            </div>
                            <br>
                            <b-button @click="publicar" class="float-center btn-fw" size="sm" variant="outline-dark">Publicar</b-button>
                        </b-card>

                         
                    </b-col>
                </b-row>
				</b-col>
			</b-row>
		</b-col>
	</b-row>
	</div>

</template>

<script>
export default{
    data(){
        return{
            yo: this.$auth.user(),
            texto:'',
            selected_publicador:'1',
            select_publicador:{},
            img_empresa:null,
            empresa:false
        }
    },
    created(){
        
        this.publicador()
    },
    methods:{
        publicar(){
            if(this.empresa == true){
                var data1 = new FormData();
                data1.append('empresa', ""+this.empresa+"");
                data1.append('texto', this.texto);
                data1.append('foto', this.img_empresa);
                axios.post('api/publicar_post_empresa', data1).then((res)=>{
                    if(res.data.estado == 'success'){
                        alert(res.data.mensaje)
                    }else{
                        alert(res.data.mensaje)
                        console.log(res.data);
                    }
                });
            }else{
                const data={
                    texto: this.texto
                }
                axios.post('api/publicar_post_user', data).then((res)=>{

                });
            }
                
        },
        publicador(){
            console.log("pura kk")
            axios.get('api/publicador').then((res)=>{
                this.select_publicador = res.data;
            });
        },
        cambio_user(){
            //si es empresa
            if(this.selected_publicador == '2'){
                this.img_empresa=null;
                this.empresa = true;
            }else{
                this.img_empresa=null;
                this.empresa = false;
            }
        },
        captar_foto(event){
				
			this.img_empresa = event.target.files[0];
		},
    }
}
</script>