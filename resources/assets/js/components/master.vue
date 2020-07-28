<template>

<div>
      <b-nav style="background: rgb(176,58,46);
background: linear-gradient(90deg, rgba(176,58,46,1) 0%, rgba(155,89,182,1) 31%, rgba(155,89,182,1) 31%, rgba(236,112,99,1) 86%, rgba(231,76,60,1) 99%);" small v-if="this.$auth.check()">
        <b-nav-item>{{yo.nombre_nick}}</b-nav-item>
      </b-nav>
      <nav class="fixed-top">
  
      <!-- <b-nav style="background: rgb(176,58,46);background: linear-gradient(90deg, rgba(176,58,46,1) 0%, rgba(155,89,182,1) 31%, rgba(155,89,182,1) 31%, rgba(236,112,99,1) 86%, rgba(231,76,60,1) 99%);" small >
        <b-nav-item v-if="!this.$auth.check()" @click="ruta('index')" >Inicio</b-nav-item>
        <b-nav-item v-if="this.$auth.check()" @click="ruta('pm_index')" >Inicio</b-nav-item>
        <b-nav-item v-if="!this.$auth.check()" @click="ruta('login')">Cuenta</b-nav-item>
        <b-nav-item v-if="!this.$auth.check()">Entrar como usuario</b-nav-item>
       
      </b-nav> -->
      <b-navbar toggleable="lg" style="background: rgb(176,58,46);background: linear-gradient(90deg, rgba(176,58,46,1) 0%, rgba(155,89,182,1) 31%, rgba(155,89,182,1) 31%, rgba(236,112,99,1) 86%, rgba(231,76,60,1) 99%); border-bottom: 5px solid #E67E22;">
        <!-- <b-navbar-brand href="#">NavBar</b-navbar-brand> -->

        <b-navbar-toggle target="nav-collapse1"></b-navbar-toggle>

        <b-collapse id="nav-collapse1" is-nav>
          <b-navbar-nav>
            <b-nav-item v-if="!this.$auth.check()" @click="ruta('index')" >
                <small style="color:white">Inicio</small>
            </b-nav-item>
            <b-nav-item v-if="!this.$auth.check()">
                <small style="color:white">Emprendedores</small>
              </b-nav-item>
              <!-- <b-nav-item v-if="this.$auth.check()" @click="ruta('pm_index')" >Inicio</b-nav-item> -->
            <b-nav-item v-if="!this.$auth.check()" @click="ruta('login')">
              <small style="color:white">Cuenta</small>
            </b-nav-item>
              
          </b-navbar-nav>

          <!-- Right aligned nav items -->
          <!--  -->
        </b-collapse>
      </b-navbar>
      </nav>

      
      
        <div style="background:white; margin-top:25px;">
         <b-container fluid>
          <router-view></router-view>
         </b-container>
        </div>  
</div>   

</template>

<script type="text/javascript">
import Autocomplete from 'vue2-autocomplete-js'
import VFacebookLogin from 'vue-facebook-login-component'
import { VFBLoginScope as VFacebookLoginScope } from 'vue-facebook-login-component'
  export default{
    components: {
        Autocomplete,
        VFacebookLogin,VFacebookLoginScope
        
		    // LinkPrevue
		},
    data(){
      return{
        yo: this.$auth.user(),
        tipo:'',
        nombre_nick:'',
        pyme:'',
        email:'',
        
        selected:'',
        options: [
          { value: '', text: 'Seleccione..' },
          { value: '1', text: 'Gastronómico' },
          { value: '2', text: 'Turístico' },
          { value: '3', text: 'Cuidado personal' },
          { value: '4', text: 'Entretenimiento y Ocio' },
          { value: '5', text: 'tecnológico' },
          { value: '6', text: 'Deporte' },
          { value: '7', text: 'Artesanía' },
          { value: '8', text: 'Belleza' }
          
        ],pass:'',

        form:{},
        mi_fb:null
      }
    },
    created(){
      var a = Math.floor(100000 + Math.random() * 900000);   
      a = String(a);
      a = a.substring(0,4);
      this.pass = a;
    },

    methods:{
      ruta(ruta){
            this.$router.push('/'+ruta);
        },
      renderChild(data) {
		    return `
		    	<label>
		      		<span>${data.text}</span>	
		      </label>
		      
		    `
      },
      getData($this) {
          
          
         this.tipo = $this.id

      },

      onInput (){ 
        // console.log("cat")
        
       
        
       
        // $(this).keydown();
    
      },
      loginx(){
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
      },

      registrar() {

        if($("#cat").val() == ''){
          this.tipo = '';
        }

        var data = new FormData();
        data.append('nombre', this.nombre_nick);
        data.append('pyme', this.pyme);
        data.append('tipo', this.tipo);
        data.append('email', this.email);
        data.append('pass', this.pass)

        console.log(this.nombre_nick, this.pyme, this.tipo)

           axios.post('api/registro_pyme', data).then((res)=>{

           });
      },


       logInWithFacebook() {
         this.loadFacebookSDK(document, "script", "facebook-jssdk");
         this.initFacebook();
         console.log("login with fb")
         console.log(FB)
          console.log(this.mi_fb)
        
        // window.FB.login(function(response) {
        //   if (response.authResponse) {
        //     alert("You are logged in &amp; cookie set!");
            
        //   } else {
        //     alert("User cancelled login or did not fully authorize.");
        //   }
        // });
        // return false;
    },
     initFacebook() {
      window.fbAsyncInit = function() {
        window.FB.init({
          appId      : '2711739702480818',
          cookie     : true,
          xfbml      : true,
          version    : 'v7.0'
        });

        FB.AppEvents.logPageView();  
        console.log("initFB")
         console.log(this.mi_fb)

        // (function(d, s, id){
        //   var js, fjs = d.getElementsByTagName(s)[0];
        //   if (d.getElementById(id)) {return;}
        //   js = d.createElement(s); js.id = id;
        //   js.src = "https://connect.facebook.net/en_US/sdk.js";
        //   fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));
      };
    },
    async loadFacebookSDK(d, s, id) {
      var js,
        fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
      //  console.log(this.mi_fb)
    },

    handleSdkInit({ FB, scope }) {
        this.FB = FB
        this.scope = scope
        console.log("handleSdkInit")
        console.log(this.scope);
        console.log(this.FB);
        console.log(this.mi_fb)
      },
      handlelogin(data){
        console.log("el-login")
        console.log(data)
        if(data.status == "connected"){
          var token = data.authResponse.accessToken;
          var user_id = data.authResponse.userID;
            console.log("iduser", user_id, 'token',token)
            axios.get("https://graph.facebook.com/"+user_id+"?fields=id,name,email,picture&access_token="+token).then((res)=>{

            });
        }
      },
      fb_click(){
        console.log("fb_click")
        console.log(this.scope);
        console.log(this.FB);
        console.log(this.mi_fb);

        // if(this.mi_fb.status == "connected"){
        //   token = this.mi_fb.authResponse.accessToken;
        //   user_id = this.mi_fb.authResponse.userID;
        //     console.log("iduser", user_id)
        //     axios.get("https://graph.facebook.com/"+user_id+"?fields=id,name,email,picture&access_token="+token).then((res)=>{

        //     });
        // }
        
        
        
      }
            
    }
    
  }
</script>
<!--#34495E;-->

<style>
a.nav-link {
    color: white;
}


.mi-card{
	border-radius: 15px 15px 15px 15px;
	-moz-border-radius: 15px 15px 15px 15px;
	-webkit-border-radius: 15px 15px 15px 15px;
	border: 0px solid #000000;


	-webkit-box-shadow: 0px 7px 14px -6px rgba(0,0,0,0.75);
	-moz-box-shadow: 0px 7px 14px -6px rgba(0,0,0,0.75);
	box-shadow: 0px 7px 14px -6px rgba(0,0,0,0.75);
}

 hr {
    background-image: linear-gradient(90deg,#ff8a00,#e52e71);
    border: 0;
    display: block;
    width: 100%;
    height: 4px;
    border-radius: 4px;
    
}

.btn-fw{
	background: #A569BD;
	color:white;
	margin-bottom: 3px;
	border: 1px solid #EB984E;
}
.btn-fw:hover{
	background: #EC7063;
	border: 1px solid #EB984E;
	
}
</style>