<template>
    <div>
        <br>
        <br>
        <br>
        <h5><label style="color:#EB984E"> > </label> Publicaciones de usuarios</h5>

        <b-card class="mi-card">
                <b-row class="justify-content-center">
                    <b-co xs="12" md="9">
                        <div v-if="pu < publicaciones.length"  v-for="pu in commentsToShow" :key="pu">
                            <b-card class="mi-card">
                                <b-row>
                                    
                                    <b-col xs="10" md="9"><b><b-avatar :src="publicaciones[pu-1].avatar"></b-avatar> {{publicaciones[pu-1].nombre}}</b></b-col>
                                </b-row>

                                <b-row>
                                    <b-col xs="12" md="12"><br>
                                        {{publicaciones[pu-1].texto}}
                                    </b-col>
                                </b-row>
                                <small class="float-right" style="color:#B2BABB">{{publicaciones[pu-1].created_at}}</small>
                            </b-card>
                            <br>
                        </div>
                        <div v-if="commentsToShow < publicaciones.length || publicaciones.length > commentsToShow">
                            <b-button @click="commentsToShow += 3">Ver mas..</b-button>
                        </div>
                    </b-co>
                </b-row>
        </b-card>
    </div>
</template>

<script>
export default {
    data(){
        return{
            publicaciones:{},
            commentsToShow: 10,
        }
    },
    created(){
        this.get_publicaciones();
    },
    methods:{
        get_publicaciones(){
			  
				  this.device = false;
				  axios.get('api/traer_publicaciones').then((res)=>{
					if(res.data.estado == 'success'){
						this.publicaciones = res.data.data;
					}
				})
			  
				
		  },
    }
}
</script>