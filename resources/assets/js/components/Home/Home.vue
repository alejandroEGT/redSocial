<template>
   <div>
      <nav class="navbar navbar-light fixed-top" style=" height:43px; background-color: #4068AD;">
        <ul class="nav">
          <li class="nav-item" >
            <img src="logo/logowhite.png" height="30" width="40" >
          </li>
          <li class="nav-item">
            <router-link style="color:white" :to="{path:'/index'}" class="nav-link active color">Inicio</router-link>
          </li>
          <li class="nav-item">
            <router-link style="color:white" :to="{name:'Chat'}"class="nav-link"><i class="fas fa-user"></i></router-link>
          </li>
          <li class="nav-item">
            <router-link style="color:white" :to="{name:'terminos'}" class="nav-link"><i class="fas fa-bell"></i></router-link>
          </li>
        
        </ul>	
         <li class="nav-item">
           <el-input        
              icon="fa fa-search"
              @change="search"
              placeholder="Buscar persona" 
              v-model="buscar">
                              
          </el-input>
         </li>
      </nav>

      <div style="margin-top: 4%;" >	
          <el-row >
              <el-col style="position:fixed;"  :md="4" :sm='4' :xs='4'>
                  <div class="menu-lateral">
                    <el-row>
                      <el-col :span="7">
                       <router-link :to="{name:'Profile'}"> <img height="45" class="img-avatar"  :src="this.$auth.user().avatar"></router-link>
                      </el-col>
                      <el-col :span="15">
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
                      </el-col>
                    </el-row>
                    <el-row>
                      <el-col :span="22">
                          <li><a href="#"><i class="fa fa-user"></i> Amigos</a></li>
                      </el-col>
                    </el-row>
                    <el-row>
                      <el-col :span="24" v-loading="loadfriend" >
                        <div class="boxfriends"  ><!--overflow: scroll; height:400px;-->
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
                      </el-col>
                    </el-row>

                    <el-row >
                      <el-col :span="22" style="overflow: scroll; height:300px; margin-top:5px; padding-top: 5px; border-top:1px solid black" >
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
                      </el-col>
                    </el-row>
                   
                  </div>
              </el-col>

              <el-col :offset="4" :xs="10" :sm="15" :md="16" style="background-color:white; border: 1px solid #E5E8E8;">
                <router-view class="mi-contenedor" :key="$route.path"></router-view> 
              </el-col>

              <el-col style="position:fixed" :offset="19" :xs="2" :sm="3" :md="5">
                <el-row>
                  <el-col :offset="5" :span="19">
                      
                            <div v-if="exist == false">
                              <p style="color:#CCD1D1" >Lista de buscados..</p>
                            </div>
                            <div v-if="exist == true" >
                              
                                <div v-loading="loadSearch" v-for="item in usuarios">
                                <el-row>
                                  <el-col :span="6">
                                    <img :src="item.avatar" class="img-avatar">
                                  </el-col>
                                  <el-col :span="16" style="font-size:13px">
                                    <p><router-link style="color:black"  :to="{name: 'User', params: {id:item.id }}">
                                      {{ item.nombres+' '+item.apellidos }}
                                    </router-link> 
                                      <strong>{{ item.email }}</strong></p>

                                  </el-col>
                                </el-row>
                                <hr>
                              </div>

                            </div>
                  </el-col>
                </el-row>           
              </el-col>
          </el-row> 
        </div>
      </div>
   </div>
</template>

<script type="text/javascript">
  export default{
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
      }
    },
    mounted(){
      $(function () {
        $('[data-toggle="popover"]').popover({});
      })
      //this.interval = setInterval(function () {
        this.amigos();
      //}.bind(this), 3000); 
      console.log(this.$auth.user().nombres);
    },
    methods:{
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
      search(){
       this.loadSearch = true
       this.exist = true
        axios.get('api/auth/getUserNews/'+this.buscar).then((response) => {
          this.usuarios = response.data;
          this.loadSearch = false
          if (this.buscar == '') this.exist = false
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

        }
        
    },
    
  }
</script>

<style type="text/css">
  .menu-lateral{
   margin-top: 5%;
   margin-left: 3%;
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

</style>