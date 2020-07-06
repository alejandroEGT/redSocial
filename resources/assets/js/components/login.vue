<template>
	<div class="">
    
      <h3>Log in</h3>
      
          
            
                  <b-input
                    placeholder="Correo"
                    icon="fa fa-envelope-open"
                    v-model="form.email">
                  </b-input>

              
                  <b-input
                    type="password"
                    placeholder="Clave"
                    icon="fa fa-key"
                    v-model="form.password">
                  </b-input>
              

              <button class="btn-block" @click="login">Log in</button>
            
            <div class="row justify-content-md-center">
              <router-link :to="{name:'registro'}" class="nav-link">Crear una cuenta aqui</router-link>
            </div>  
         
          
    
	  
	</div>
</template>


<script>
  export default {
    data(){
      return{
        form:{},
      }
    },
    methods: {
      login(){
        var app = this
        this.$auth.login({
          data: app.form,
          redirect:'/home/',
          success: function(){
            //this.$router.push({ path: '/index' });
          },
          error: function(){},
          rememberMe: true,
          //redirect: '/index',
          //fetchUser: true,
        });
      }
    }
  }
</script>
