<template>
    <!-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        
        <div class="container">
            <router-link class="navbar-brand" to="/">IntelliRehab</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    
                    <template>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                {{ currentUser.firstname }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav> -->
    <div>
        <div>    
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <h1>IntelliRehab</h1>
                    </div>
                    <hr>
                    <div class="d-flex flex-column text-muted"> 
            
                        <div>{{ currentUser.firstname }} {{ currentUser.lastname }}</div>
                        <div>{{ currentUser.level }}</div>
                        
                    </div>      
                </div>
            </nav>
        </div> 
        <div id="test" class= "sidebar-container">';
            <div class="w3-sidebar w3-bar-block w3-small  w3-center "  style="width:8%">
    
             <div > 
            <router-link to="/" class="w3-bar-item w3-button w3-padding-large"> 
            <i class="fa fa-home w3-xlarge"></i>
            <p>HOME</p>
            </router-link>
            </div>  
            
            <a href="#" class="w3-bar-item w3-button w3-padding-large w3-hover-black" >
            <i class="fa fa-wheelchair w3-xlarge"></i>
            <p>PATIENT</p>
            </a>

            <router-link to="/admin" class="w3-bar-item w3-button w3-padding-large w3-hover-black">    
            <!-- <a  href="#" class="w3-bar-item w3-button w3-padding-large w3-hover-black" > -->
            <i class="fa fa-cogs w3-xlarge"></i>
            <p>Admin</p>
            </router-link>   
            
             <a  href="#!" @click.prevent="logout" class="w3-bar-item w3-button w3-padding-large w3-hover-black" >
            <i class="fa fa-sign-out w3-xlarge"></i>
            <p>LOGOUT</p>
            </a>
            </div>				
        </div>
        <!-- <h1>test</h1> -->
    </div>
    
</template>

<script>
import Event from '../app.js'; 
    export default {
        name: 'app-header',
        methods: {
            logout() {
                Event.$emit('loggedOut');
                this.$store.commit('logout');
                this.$router.push('/login');
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }
    }
</script>