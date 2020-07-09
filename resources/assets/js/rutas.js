import Login from "./components/login";
import Registro from "./components/registro";
import Terminos from "./components/terminos";
import NotFound from './components/404.vue'
//loged
import Master from "./components/master";
import Home from "./components/Home/Home";
import Index from "./components/Home/Index";
import Chat from "./components/Home/chat";
import User from "./components/Home/user";
import Amigos from "./components/Home/amigos";
import Profile from "./components/Home/profile";

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
        { path: '/chat', component: Chat, name: 'Chat' },
        { path: '/search/:id', component: User, name:'User'},
        { path: '/amigos/:id', component: Amigos, name: 'Amigos'},
        { path: '/profile', component: Profile, name: 'Profile'},
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