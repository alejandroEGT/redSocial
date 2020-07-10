<template>
  <div>
    <b-nav style="background: rgb(176,58,46);
background: linear-gradient(90deg, rgba(176,58,46,1) 0%, rgba(155,89,182,1) 31%, rgba(155,89,182,1) 31%, rgba(236,112,99,1) 86%, rgba(231,76,60,1) 99%);" small>
        <b-nav-item active @click="ruta('pm_index')">Inicio</b-nav-item>
        <b-nav-item v-if="this.$auth.check()" @click="ruta('profile')">Mi perfil</b-nav-item>
        <b-nav-item>Link</b-nav-item>
        <b-nav-item>Another Link</b-nav-item>
        <b-nav-item @click="logout">Salir</b-nav-item>
      </b-nav>

       <div style="background:#F4F6F6">
         <b-container fluid>
         <router-view></router-view>
         </b-container>
       </div>
  </div>
</template>

<script type="text/javascript">

  import Autocomplete from 'vue2-autocomplete-js'
  export default{
    components: {
        Autocomplete,
      },
    data(){
      return{
        loadSearch: false,
        loadfriend:true,
        exist:false,
        yo: this.$auth.user(),
        lastname: this.$auth.user().apellidos,
        activeName: 'first',
        tabPosition:'bottom',
        buscar:'',
        usuarios:{},
        friends:{},
        credential:'',
        q:'',
        videos:{},
        videoId: '',
        videoCon:true,
        see_search:false,
        izq:true,
        autocompleto:'',
        notif_sms: 0,
        notif_context:{},
        notif_solicitud:0,
        solicitudes:{}
      }
    },
    mounted(){

      console.log(this.$auth.check())

      $(function () {
        $('[data-toggle="popover"]').popover({});
        $("[data-toggle]").click(function() {
          var toggle_el = $(this).data("toggle");
          $(toggle_el).toggleClass("open-sidebar");
        });
      })

      //this.interval = setInterval(function () {
        this.amigos();
        this.amigos_encomun();
        this.get_notix_mensaje();
        this.ver_solicitudes();
      //}.bind(this), 3000); 
        Echo.private('chat.'+this.$auth.user().id).listen('MessageSentEvent', (e) => {
            if(e.message.id_user_recibe == this.$auth.user().id){
              var audio = new Audio('http://soundbible.com/mp3/Elevator Ding-SoundBible.com-685385892.mp3');
              audio.play();

              this.notif_sms++;
              this.get_notix_mensaje();

            }
                          
        });   
         Echo.private('notificar_solicitud.'+this.yo.id).listen('NotificarSolicitudEvent', (e) => {this.notif_solicitud++; this.ver_solicitudes(); });

         Echo.private('notificar_solicitud_return.'+this.yo.id).listen('NotificarSolicitudEvent', (e) => {this.amigos(); });


    },
    methods:{
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
      ,
      quite(){
        this.exist = false;
      },
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      },
      logout: function () {
                // this.$confirm('Seguro que quieres salir ?', 'Confirmation', {
                // }).then(() => {
                    this.$auth.logout({
                        makeRequest: true,
                        redirect: '/index',
                        success: function(){
                          location.reload();
                        },
                    });
                // });
      },
       handleClick(tab, event) {
        console.log(tab, event);
      },
      redirect_user($id){
        this.exist = false;
        this.$router.push({name: 'User', params: {id:$id }});
      },
      search(){
       this.loadSearch = true
       this.exist = true
        axios.get('api/auth/getUserNews/'+this.buscar).then((response) => {
          this.usuarios = response.data;
          this.loadSearch = false;
          this.see_search = true;
          if (this.buscar == ''){
            this.exist = false
            this.see_search = false;
          } 
        })
        .catch((error) => {
          console.log(error);
        });
      },
      redirect(){
        alert("redirect")
      },
      amigos(){
         
            axios.get('api/auth/amigos').then((response) =>{
              this.friends = response.data;
              this.loadfriend = false;
            
            })  
          
      },

      mouseOver($id){
          //alert("acive "+$id);
      },
      amigos_encomun(){
        axios.get('api/auth/get_amigos_en_comun').then((res)=>{
          this.otros_usuarios = res.data;
        })
      },
        getVideo(){
          this.credential="kkck";
          if (this.q=="") {
            this.videoCon=true;
          }
          
          if(this.q != ""){
            this.videoCon=false;
           axios.get('https://www.googleapis.com/youtube/v3/search?part=snippet&q='+this.q+'&key=AIzaSyByl0mknurTuu1ybN1aF7WY5bNMoZz1J00',{ headers: false }).then(
              (response) =>{
                this.videos=response.data.items;
                this.videoCon=false;
               // alert(this.videos)
              }
            )
          }else{
            this.videoCon=true;
               
          }

        },
      renderChild(data) {
        return `
          <el-row>
            <el-col :span="2">
              <img class="avatar_indexx" src="${data.avatar}" />
            </el-col>

            <el-col :span="22">
              <span>${data.nombres}</span>
            </el-col>
          </el-row>
          
        `
      },
      getData($this) {
          
          this.redirect_user($this.id)

      },
      get_notix_mensaje(){
        axios.get('api/auth/notifi_mensajes/'+this.$auth.user().id).then((res)=>{
            this.notif_context = res.data;
        })
        
      },
      select_mensaje($envia, $recibe){
        var id = 0;
        if ($envia == this.yo.id){id=$recibe}else{ id=$envia}
        //alert(id);
        this.$router.push({name: 'Amigos', params: {id:id }});
      },
      ver_solicitudes(){
        axios.get('api/auth/solicitud',{id:this.yo.id}).then((res)=>{
            this.solicitudes = res.data;
        })
      },
      cancelarSolicitud($num){
        axios.post('api/auth/solicitud', {num:$num, id_acepta: this.yo.id}).then((response) =>{
          
          this.getuser()
          
        })
      },
      aceptarSolicitud($num){
        axios.post('api/auth/aceptarSolicitud', {num:$num, id_acepta: this.id_mio, id_solicita: this.id}).then((response) =>{
          console.log(response.data)
          
        })  
      },
   }
    
  }
</script>

<style type="text/css">
   /* .menu-lateral{
     margin-top: 5%;
     margin-left: 3%;
    }*/
    .mnu{
     
      position: fixed; /* Set the navbar to fixed position */
     /* Position the navbar at the top of the page */
      width: 200px; /* Full width */
    }
    .mi-contenedor{
      margin:5%;
    }
    .img-avatar{
      height:40px; 
      width:40px;
      border-radius: 50px;
    }
    .nombre{
      font-size: 80%;
      line-height:13px;
    }
    li {
      list-style:none;
    }
    #right {
      position:fixed;
      right:0px;
      left:920px;
      height:400px;
      overflow-y:auto;
    }
  .boxfriends{
    padding: 5px;
    border: 1px solid #4423;
    overflow: scroll; 
    height:auto;
    margin-right: 5px;
  }
  .txt_public{
    font-size: 23px;
  }





   body, html {
    background-color:white;
      height: 100%;
      margin: 0;
      /*overflow:hidden;*/
      font-family: helvetica;
      font-weight: 100;
  }
  .containers {
      position: relative;
     /* height: 100%;
      width: 100%;*/
      left: 0;
      -webkit-transition:  left 0.4s ease-in-out;
      -moz-transition:  left 0.4s ease-in-out;
      -ms-transition:  left 0.4s ease-in-out;
      -o-transition:  left 0.4s ease-in-out;
      transition:  left 0.4s ease-in-out;
  }
   
  .containers.open-sidebar {
      left: 220px;
  }
   
  #sidebar {
      position: absolute;
      left: -220px;
      background: #F2F3F4;
      width: 220px;
      height: 100%;
      box-sizing: border-box;
  }
  #sidebar ul {
      margin: 0;
      padding: 0;
      list-style: none;
  }
  #sidebar ul li {
      margin: 0;
  }
  #sidebar ul li a {
      padding: 15px 20px;
      font-size: 16px;
      font-weight: 100;
      color: white;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid #C9223D;
      -webkit-transition:  background 0.3s ease-in-out;
      -moz-transition:  background 0.3s ease-in-out;
      -ms-transition:  background 0.3s ease-in-out;
      -o-transition:  background 0.3s ease-in-out;
      transition:  background 0.3s ease-in-out;
  }
  #sidebar ul li:hover a {
      background: #C9223D;
  }
  .main-content {
    /*  width: 100%;
      height: 100%;*/
      padding: 10px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      position: relative;
  }
  .main-content .content{
      box-sizing: border-box;
      -moz-box-sizing: border-box;
  padding-left: 60px;
  width: 100%;
  }
  .main-content .content h1{
      font-weight: 100;
  }
  .main-content .content p{
      width: 100%;
      line-height: 160%;
  }
  .main-content #sidebar-toggle {
      background: #DF314D;
      border-radius: 3px;
      display: block;
      position: relative;
      padding: 10px 7px;
      float: left;
  }
  .main-content #sidebar-toggle .bar{
       display: block;
      width: 18px;
      margin-bottom: 3px;
      height: 2px;
      background-color: #fff;
      border-radius: 1px;   
  }
  .main-content #sidebar-toggle .bar:last-child{
       margin-bottom: 0;   
  }
  .avatar_indexx{
      height: 35px;width: 35px; border-radius: 30px;
    }

    .nav-link {
    display: block;
    padding: 0.5rem 1rem;
    color: white;
}

</style>