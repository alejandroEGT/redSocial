<template>
   <div @click="quite">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top" style=" background-color:#17202A">
        <a class="navbar-brand" data-toggle=".containers" id="sidebar-toggle" >
          <img src="logo/logowhite.png" height="30" width="40" >
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                  <router-link style="color:white" :to="{path:'/index'}" class="nav-link active color">Inicio</router-link>
            </li>
            <li class="nav-item">
                <router-link style="color:white" :to="{name:'Chat'}"class="nav-link"><i class="fas fa-user"></i></router-link>
            </li>
            <li class="nav-item">
                 
                  <el-dropdown trigger="click" class="nav-link">

                       <h5 style="color:white"><i class="fas fa-comment-alt"></i> <span class="badge badge-danger">{{notif_sms}}</span></h5>
                    <el-dropdown-menu slot="dropdown">
                        <div style="width:330px" v-for="n in notif_context">
                          <el-dropdown-item >
                             <div class="container" style="border-bottom: 1px solid #D5DBDB;">
                                <div class="row">
                                  <div class="col-md-2">
                                    <img style="margin-top:3px" class="img-avatar" :src="n.avatar">
                                  </div>
                                  <div class="col-md-9">
                                    <strong>{{ ' '+n.nick }}</strong>
                                    <label style="color:#7F8C8D;display:block;line-height: 1.2;">
                                      {{ n.mensaje }}
                                    </label>
                                  </div>
                                </div>
                             </div>
                          </el-dropdown-item>
                        </div>
                      <el-dropdown-item v-if="notif_context == 'null'" >
                        <span>No Hay mensajes..</span>
                      </el-dropdown-item>
                      
                    </el-dropdown-menu>
                  </el-dropdown>
                
                </li>
          </ul>
          <span class="navbar-text">
            <!-- <el-input size="small"       
                      icon="fa fa-search"
                      @change="search"
                      placeholder="Buscar persona" 
                      v-model="buscar">
                                      
                    </el-input> -->
                    <autocomplete
                          url="/users/autocomplete"
                          id="id_auto"
                          anchor="nombres"
                          label="email"
                           :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
                            placeholder="placeholder"
                           :onShouldRenderChild="renderChild"
                           :on-select="getData"
                          >
                    </autocomplete>
          </span>
        </div>
      </nav>
      
      <div class="containers">
        <div id="sidebar">
            <div style="position: fixed; width:200px; margin-left:5px">
              <div class="mnu" style="background-color: #F2F3F4">
              <div class="row" style="margin-top:25px">
                <div class="col-md-2">
                    <router-link :to="{name:'Profile'}"> <img height="45" class="img-avatar"  :src="this.$auth.user().avatar"></router-link>
                </div>

                <div class="col-md-8">
                    <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ nick }}
                            </a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" >Mi cuenta</a>
                            <a class="dropdown-item" @click="logout" href="#" >Salir</a>
                          </div>
                    </div>
                     <p class="nombre">{{name+' '+lastname}}</p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <a href="#"><i class="fa fa-user"></i> Amigos</a>
                    <div class="boxfriends" v-loading="loadfriend"  >
                              <div v-for="am in friends">
                                <el-row>
                                  <el-col :span="20">
                                    <p @mouseover="mouseOver(am.id)" style="font-size:12px; color:black" >
                                       
                                      <router-link style="color:black" :to="{path:'/amigos/'+am.id}">
                                        <img style="height:25px; width:25px; border-radius:25px; margin-right:4px" :src="am.avatar" />
                                      {{ (am.nombres+' '+am.apellidos).substr(0, 17) }}
                                    </router-link>
                                      
                                    </p>
                                        
                                  
                                  </el-col>
                                  <el-col :span="3">
                                    <div v-if="am.active == 1"><img src="http://3.bp.blogspot.com/-XqF09AkxbIw/VmbGVUHSCNI/AAAAAAAAH48/YqKi_0fpFMk/s1600/1437492872628.png" height="10"></div>
                                  </el-col>
                                </el-row>
                              </div>
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12" style="overflow: scroll; height:300px; margin-top:5px; padding-top: 5px; border-top:1px solid gris">
                    <el-input        
                        icon="fa fa-search"
                        @change="getVideo"
                        placeholder="Buscar videos" 
                        v-model="q">           
                    </el-input>
                    <hr>
                    <div v-if="videoCon">
                      <center style="color:#BDBDBD">
                        <label>Extension de youtube </label>
                        <p><i class="fab fa-youtube fa-3x"></i></p>
                      </center>
                    </div>
                    <div v-if="!videoCon">
                      <div v-for="v in videos">        
                         <youtube style="border-radius:10px" :video-id=" ''+v.id.videoId+'' " player-width="200" player-height="100" :player-vars="{autoplay: 0}"></youtube>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            </div>
        </div>
        
          <div class="main-content" style="margin-top:60px">
            
              <div class="">
                <div class="row justify-content-md-center">
                  <div class="col-md-12">
                    <router-view :key="$route.path"></router-view>  
                  </div>
                 
                </div>

              </div>
          </div>
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
        nick: this.$auth.user().nickname,
        name: this.$auth.user().nombres,
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
        notif_context:{}
      }
    },
    mounted(){
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
      //}.bind(this), 3000); 
      Echo.private('chat.'+this.$auth.user().id).listen('MessageSentEvent', (e) => {

          if(e.message.id_user_recibe == this.$auth.user().id){
            var audio = new Audio('http://soundbible.com/mp3/Elevator Ding-SoundBible.com-685385892.mp3');
            audio.play();

            this.notif_sms++;
            this.get_notix_mensaje();

          }
                        
      });     
    },
    methods:{
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
                this.$confirm('Seguro que quieres salir ?', 'Confirmation', {
                }).then(() => {
                    this.$auth.logout({
                        makeRequest: true,
                        redirect: '/'
                    });
                });
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

</style>