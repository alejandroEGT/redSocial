<template>
    <div>
        <el-row>
            <el-col :span="3">
                <div v-loading="loading"><img :src="amigo.avatar" class="img-thumbnail avatar_amigo"></div>
            </el-col>
            <el-col :span="10">
                    <div v-loading="loading">{{ amigo.nombres+' '+amigo.apellidos }}</div>
            </el-col>
        </el-row>  

        <el-row>
            <el-col :span="24">
              <div>
                  <div class="box-chat" >
                      <div class="chat-body" v-chat-scroll >
                          <chat-messages :messages="messages"></chat-messages >
                   
                      </div>
              
               <div class="chat-foot">           
                   <chat-form v-on:messagesent="addMessage" :user="nameAuth" :load="btn_load"></chat-form>
                   <form method="POST" id="form1" enctype="multipart/form-data">
                    <input type="hidden" name="id_recibe" v-model="id_recibe" >
                    <input type="file" name="fotos[]" @change="sendFoto">
                </form>
                </div>
                  </div>
              </div>
            </el-col>
        </el-row> 
    </div>
</template>




<script type="text/javascript">
    
    export default{
        data(){
            return{
                loading: true,
                id: this.$route.params.id,
                amigo:{
                    nombres:'',
                    apellidos:'',
                    avatar:''
                },

                btn_load: false,
                nameAuth: this.$auth.user(),
                messages:[],
                newMessage: '',
                id_recibe: this.$route.params.id,
            }
        },
        mounted(){
            this.getAmigo();

        },
        created(){
             this.listen();
            this.fetchMessages();
        },
        methods:{
            getAmigo(){
                axios.get('api/auth/amigo/'+this.id).then((response)=>{
                        this.amigo = response.data;
                        this.loading = false;
                })
            },
            listen() {
          
          Echo.private('chat.'+this.nameAuth.id+'.'+this.id).listen('MessageSentEvent', (e) => {

                      var audio = new Audio('http://soundbible.com/mp3/Elevator Ding-SoundBible.com-685385892.mp3');
                      audio.play();
                        this.messages.push({
                          mensaje: e.message.mensaje,
                          archivo: e.message.archivo,
                          foto_user_2: e.user.avatar,
                          use_2: e.user.nombres,
                          created_at: e.user.created_at
                        });
                        
                      });      
                      
        },
        sendMessage() {
           
                this.$emit('messagesent', {
                    nameAuth: this.nameAuth,
                    message: this.newMessage
                });

                this.newMessage = ''
        },
        fetchMessages() {
            axios.get('api/auth/messages/'+this.id).then(response => {
                this.messages = response.data;
                //console.log(response.data);
            });
        },

        addMessage(message) {
          //console.log(this.newMessage)
          console.log(this.nameAuth.nombres)
            this.messages.push({
                          
                          //created_at: '192'
                          archivo: message.archivo,
                          mensaje: message.mensaje,
                          foto_user_1: this.nameAuth.avatar,
                          use_1: this.nameAuth.nombres,
                          id_user_envia: this.nameAuth.id,
                          //created_at: e.user.created_at

                        });
            this.btn_load = true;
            var datos={}  
            datos.message = message;
            datos.id_recibe = this.id;
            //console.log(datos);
            axios.post('api/auth/messages', datos).then(response => {
              //this.fetchMessages();
              this.btn_load = false;
            });
        },
        sendFoto(){
                 var datos={} 
                 var form = document.querySelector("#form1");
                

                axios.post('api/auth/fotoChat', new FormData(form),{
                    headers:{
                        'content-Type': 'miltipart/form-data'
                    }
                }).then((response) =>{
                    
                    console.log(response.data)
                    this.fetchMessages();
                    
                })
            }
      }
    }
</script>

<style type="text/css">
    .avatar_amigo{
        border-radius: 50px;
        height: 70px;
        width: 70px;
    }
    .box-chat{
        position: relative;
        height: 500px;
        width: 100%;
        
    }
    .chat-body{

        height: 450px;
        width: 100%;
        overflow: auto;
    }
    .chat-foot{
          position: absolute;
          right: 0;
          bottom: 0;
          left: 0;
          padding: 1rem;
          text-align: center;
          background: #ECF0F1;
    }
</style>