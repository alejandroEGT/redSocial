<template>

<div>
        <b-card no-body class="overflow-hidden" style="background:#F4F6F6; width: 100%;">
          <b-row no-gutters>
            <b-col md="4">
              <b-card-img style="height:80%; width:80%;" src="https://i.pinimg.com/originals/0e/0a/54/0e0a54a90658ba6995488a35585642ee.gif" alt="Image" class="rounded-0"></b-card-img>
            </b-col>
            <b-col md="8">
              <b-card-body title="Publica tu emprendimiento, hoy, facil y sencillo">
                <b-card-text>
                  En este apartado te damos dos opciones, un registro de tu emprendimiento y un inicio a tu cuenta, comencemos!
                  <br><br>
                 
                  <b-button v-b-modal.inicio size="lg" variant="outline-primary">Iniciar sesion</b-button>
                  <b-modal id="inicio" title="Log in" hide-footer ok-only>
                    <div>
                     
                      <!-- <div class = "fb-login-button" data-size = "large" data-button-type = "continue_with" data-layout = "default" data-auto-logout-link = "false" data-use-continue-as = "false" data-width = "" > </div>    -->
                         <v-facebook-login 
                         text-class="Entrar con facebook"
                         v-model="mi_fb"
                          app-id="2711739702480818" 
                          @sdk-init="handleSdkInit"
                          @login="handlelogin"
                          @click="fb_click"
                          
                          :use-alt-logo="true"
                        >
                        <span slot="login">Entrar con facebook</span>
                        </v-facebook-login>
                       <!-- <button class="button" @click="logInWithFacebook"> Login with Facebook</button> -->
                      <!-- <button @click="AuthProvider('facebook')">auth Facebook</button> -->
                      <hr>
                       <b-input
                          placeholder="Correo"
                          
                          v-model="form.email">
                        </b-input>

                        <br>
                    
                        <b-input
                          type="password"
                          placeholder="Clave"
                          
                          v-model="form.password">
                        </b-input>
                    <br>

                    <button class="btn-block" @click="loginx">Log in</button>
                    </div>
                  </b-modal>








                  <b-button v-b-modal.registro size="lg" variant="outline-success">Crear cuenta</b-button>
                  <b-modal id="registro" title="Crear cuenta" hide-footer ok-only>
                    <div>
                     <b-alert show variant="success"> <small> <i class="far fa-save"></i> Creat tu cuenta ahora, es gratis!</small></b-alert>
                     <hr>
                     <label for="">Nombre completo o nick</label>
                     <b-input v-model="nombre_nick"></b-input>
                     <br>
                     <label for="">Nombre de tu negocio o emprendimiento</label>
                     <b-input v-model="pyme"></b-input>
                     <br>
                     <label for="">Tipo de negocio o emprendimiento</label>
                     <!-- <b-form-select v-model="selected" :options="options">

                     </b-form-select> -->

                     <autocomplete
                          id="cat"
											    url="/users/categorias"
											    anchor="text"
                          :filterByAnchor="false"
											    label="email"
											     :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
    												placeholder="Buscar categoría.."
											     :onShouldRenderChild="renderChild"
                           :on-select="getData"
                           :onFocus="onInput"
											    >
											  </autocomplete>
                        <br>
                        <label for="">Correo electrónico</label>
                        <b-input v-model="email"></b-input>

                        <br>
                        <label for="">Clave provisoria (Antes de registrarse apunte esta clave)</label>
                        <b-input disabled v-model="pass"></b-input>
                        <br>
                        <b-button @click="registrar">Registrarme</b-button>
                    </div>
                  </b-modal>
                </b-card-text>
              </b-card-body>
            </b-col>
          </b-row>
        </b-card>

        <b-card no-body class="overflow-hidden" style="background:#5D6D7E; color:white; width: 100%;">
          <b-row no-gutters>
            <b-col md="8">
              <b-card-body title="Red de clientes">
                <b-card-text>
                  Comparte tu enlace de perfil que crearemos para que tus clientes puedan ver tus publicaciones
                </b-card-text>
              </b-card-body>
            </b-col>
            <b-col md="4">
              <b-card-img style="height:80%; width:80%;" src="https://www.pngmart.com/files/11/Eye-Contact-PNG-Image.png" alt="Image" class="rounded-0"></b-card-img>
            </b-col>
          </b-row>
        </b-card>

        <b-card no-body class="overflow-hidden" style="background:#5499C7;color:white; width: 100%;">
          <b-row no-gutters>
            <b-col md="4">
              <b-card-img style="height:80%; width:80%;" src="https://lh3.googleusercontent.com/proxy/04FgtZ6o3q9bPMOa7lSCHX83CzarZFzYvLxpPN56v1hA5oIat2xPFxHe2gE1L_PopdskLAPnSILjMLvJ1THocNOCQ5pISjCrfv61BIF_fCXrl2VkAkhOT3q6UTdjL3SeBmdMGxIBFQ" alt="Image" class="rounded-0"></b-card-img>
            </b-col>
            <b-col md="8">
              <b-card-body title="Público">
                <b-card-text>
                  Existiran personas viendo los emprendimientos de esta plataforma, podran contactarte al instante!
                </b-card-text>
              </b-card-body>
            </b-col>
          </b-row>
        </b-card>
        <!-- <b-card style="background:#F4F6F6" img-src="https://i.pinimg.com/originals/0e/0a/54/0e0a54a90658ba6995488a35585642ee.gif" img-alt="Card image" img-left class="mb-3">
          <b-card-text >
            Some quick example text to build on the card and make up the bulk of the card's content.
          </b-card-text>
        </b-card> -->
          <!-- <b-row>
              <b-col xs="12" sm="8" md="8" lg="8" xl="8">
                <b-img-lazy :src="'https://i.pinimg.com/originals/0e/0a/54/0e0a54a90658ba6995488a35585642ee.gif'" alt="Image 1"></b-img-lazy>
                
              </b-col>
              <el-col xs="12" sm="4" md="4" lg="4" xl="4">
                <router-view></router-view>  
              </el-col>
          </b-row> -->
       
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

      login_fb(email){
        var app = this
        this.$auth.login({
          url:'api/auth/login_fb',
          data: {'email':email},
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

              axios.post('api/validar_si_existe_email_en_sistema',res.data).then((ress)=>{
                  if(ress.data.estado == "failed"){
                    alert(ress.data.mensaje);
                    // this.ruta('login');
                    location.reload();
                  }else{
                    this.login_fb(data.authResponse.email);
                  }
              });

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