<template>
   <div>
      <nav class="navbar navbar-light" style="background-color: #5DADE2">
        <ul class="nav">
          <li class="nav-item" >
            <img height="70" width="150" src="logo/milogo.png">
          </li>
          <li class="nav-item">
            <router-link style="color:white" :to="{name:'login'}" class="nav-link active color">Login</router-link>
          </li>
          <li class="nav-item">
            <router-link style="color:white" :to="{name:'registro'}"class="nav-link">Registro</router-link>
          </li>
          <li class="nav-item">
            <router-link style="color:white" :to="{name:'terminos'}" class="nav-link">Terminos</router-link>
          </li>
        </ul>	
      </nav>	
      
          <div class="row justify-content-md-center">
              <div class="col-md-5 ">
                <img height="350" width="500" src="https://d3sq5bmi4w5uj1.cloudfront.net/images/brochure/apps/devices.png?1513786503">
              </div>
              <div class="col-md-4">
                <router-view></router-view>  
              </div> 
          </div>
          
      </div>
   </div>
</template>

<!--#34495E;-->