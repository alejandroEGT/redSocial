<template>
<div>
    <br>
    <b-row>
		<b-col xs="12" md="12">
            <h5><label style="color:#ABB2B9">Inicio</label> 
            <label style="color:#EB984E"> > </label> 
            Nuevos emprendimientos de este mes.  </h5>
           
            <b-card class="mi-card">
                        <b-navbar class="mi-card"  style="background: rgb(176,58,46);
        background: linear-gradient(90deg, rgba(176,58,46,1) 0%, rgba(155,89,182,1) 31%, rgba(155,89,182,1) 31%, rgba(236,112,99,1) 86%, rgba(231,76,60,1) 99%);" toggleable="lg" >
                                    <b-navbar-brand href="#">.</b-navbar-brand>

                                    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                                    <b-collapse id="nav-collapse" is-nav>
                                    <b-navbar-nav>
                                        <b-nav-item @click="select('all')" >
                                            <small style="color:white">Todo</small>
                                        </b-nav-item>
                                        <b-nav-item v-for="c in categorias" 
                                        :key="c.id" @click="select(c.id)">
                                        <small style="color:white">{{c.text}}</small>
                                        </b-nav-item>
                                    
                                        
                                    </b-navbar-nav>

                                    
                                    </b-collapse>
                            </b-navbar>
                        <b-card class="mi-card">
                            <autocomplete
                                id="cat"
                                url="/api/todos_emprendedores"
                                anchor="nombre"
                                :filterByAnchor="false"
                                label="email"
                                :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
                                placeholder="Buscar emprendedor.."
                                :onShouldRenderChild="renderChild2"
                                :on-select="getData">
                            </autocomplete>

                            <!-- <autocomplete
                                id="cat"
                                                        url="/users/categorias"
                                                        anchor="text"
                                :filterByAnchor="false"
                                                        label="email"
                                                        :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
                                                            placeholder="Buscar categoría.."
                                                        :onShouldRenderChild="renderChild"
                                :on-select="getData"
                                
                                                        >
                                                    </autocomplete> -->
                        </b-card>
                <br>
                <center v-if="!load">
                    <b-spinner variant="warning" label="Spinning"></b-spinner>
                </center>
                <div v-if="load" style="width: 100%;
                height: 500px;
                overflow-y: scroll;
                scrollbar-width: thin;">
                    <div v-for="d in e_mes" :key="d.user_id" class="product-image-wrapper">
                                            
                            <div style="padding:5px;">
                            
                                    <div class="text-center">
                                        <img style="width:80px; height:80px;" :src="d.avatar" alt="" />
                                        <h6>{{d.nombre}}</h6>
                                        <b-badge class="badgex">{{d.categoria}}</b-badge><br>
                                        <p>{{d.contacto}}</p>
                                                            
                                                            
                                        <b-button @click="conocer(d.user_id)" class="float-center btn-fw" size="sm" variant="outline-dark">Conocer</b-button>
                                    </div>
                                        
                            </div>
                                                
                    </div>
                </div>
                </b-card>
		</b-col>

    </b-row>
    </div>
</template>

<script>
import Autocomplete from 'vue2-autocomplete-js'
    export default {
        components: {
        Autocomplete,
        // VFacebookLogin,VFacebookLoginScope
        
		    // LinkPrevue
		},
        data(){
            return{
                load:false,
                e_mes:{},
                categorias:{},
                search:'',
                emprendedor_id:'',
            }
        },
        created(){
            this.get_emprendedores_mes();
            this.get_categorias();
        },
        methods:{
            get_emprendedores_mes(){
                this.load=false;
                var cant='ALL';
				axios.get('api/emprendimientos_mes/'+cant).then((res)=>{
					if(res.data.estado == 'success'){
                        this.load=true;
						this.e_mes = res.data.response;
					}
				});
            },
            get_categorias(){
				axios.get('users/categorias').then((res)=>{
					
						this.categorias = res.data;
					
				});
            },
            conocer(id){

                if(this.$auth.check()){

                    this.url_params('pm_emprendimiento',{id:id});

                }else{

                    this.url_params('emprendimiento',{id:id});

                }
            },
            buscar(){

            },
            getData($this) {
                
          
                this.emprendedor_id = $this.user_id
                // console.log(this.emprendedor_id)
                this.conocer(this.emprendedor_id)

            },
            renderChild(data) {
                    return `
                        <label>
                            
                            <span>${data.text}</span>	
                    </label>
                    
                    `
            },
            renderChild2(data) {
                    return `
                        <label>
                        <img style="width:40px;" src="${data.avatar}" >
                            <span>${data.nombre}</span>	
                    </label>
                    
                    `
            },
            select(dato){
                this.load=false;
                var categ=dato;
				axios.get('api/emprendimientos/'+categ).then((res)=>{
					if(res.data.estado == 'success'){
                        this.load=true;
						this.e_mes = res.data.response;
					}
				});
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
<style >
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
</style>