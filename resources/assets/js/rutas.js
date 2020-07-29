import Login from "./components/login";
import Registro from "./components/registro";
import Terminos from "./components/terminos";
import NotFound from './components/404.vue'
import ver_mas_emprendedores_mes from './components/Home/ver_mas_emprendedores_mes.vue'
//loged
import Master from "./components/master";
import Home from "./components/Home/Home";
import Index from "./components/Home/Index";
import Chat from "./components/Home/chat";
import User from "./components/Home/user";
import Amigos from "./components/Home/amigos";
import Profile from "./components/Home/profile";
import Publicar from "./components/Home/publicar";
import Emprendimiento from "./components/Home/emprendedor_perfil";
import publicacion_usuarios from "./components/Home/publicacion_usuarios"

let routes = [

    //usuario pasajero
{
    path: '/',
    component: Master,
    name:'Admin',
    redirect:'index',
    iconCls:'el-icon-message',
    meta:{auth:false},
    children:[
        {path: '/index', component: Index, name: 'index' },
        { path: '/ver_mas_emprendedores_mes', component: ver_mas_emprendedores_mes, name: 'ver_mas_emprendedores_mes' },
        { path: '/emprendimiento/:id', component: Emprendimiento, name: 'emprendimiento' },
        { path: '/publicacion_usuarios', component: publicacion_usuarios, name: 'publicacion_usuarios' },
        
        {path: '/login',name: 'login',component: Login,meta: { auth: false }},
        {path: '/registro',name: 'registro',component: Registro,meta: { auth: false}},
        {path: '/terminos',name: 'terminos',component: Terminos,meta: { auth: false }},
    ]   
},

//usuario pasajero
{
    path: '/home/',
    component: Home,
    name: 'Administration',
    redirect:'pm_index',
    iconCls: 'el-icon-message',
    meta: {auth: true},
    children: [
        { path: '/pm_index', component: Index, name: 'pm_index' },
        { path: '/pm_ver_mas_emprendedores_mes', component: ver_mas_emprendedores_mes, name: 'pm_ver_mas_emprendedores_mes' },
        { path: '/chat', component: Chat, name: 'Chat' },
        { path: '/search/:id', component: User, name:'User'},
        { path: '/amigos/:id', component: Amigos, name: 'Amigos'},
        { path: '/profile', component: Profile, name: 'Profile'},
        { path: '/publicar', component: Publicar, name: 'Publicar' },
        { path: '/pm_emprendimiento/:id', component: Emprendimiento, name: 'pm_emprendimiento' },
        { path: '/pm_publicacion_usuarios', component: publicacion_usuarios, name: 'publicacion_usuarios' },
    ]
},
{
        path: '/404',
        component: NotFound,
        name: '',
        hidden: true
    },
    {
        path: '*',
        hidden: true,
        redirect: { path: '/404' }
    }     


];

export default routes;