<template>

<div>
      <b-nav small v-if="this.$auth.check()">
        <b-nav-item>{{yo.nombre_nick}}</b-nav-item>
      </b-nav>
      <b-nav small>
        <b-nav-item>Inicio</b-nav-item>
        <b-nav-item v-if="!this.$auth.check()">Entrar como pyme</b-nav-item>
        <b-nav-item v-if="!this.$auth.check()">Entrar como usuario</b-nav-item>
        <!-- <b-nav-item>Another Link</b-nav-item>
        <b-nav-item disabled>Disabled</b-nav-item> -->
      </b-nav>
      
        <div style="background:#F4F6F6">
          <router-view></router-view>
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