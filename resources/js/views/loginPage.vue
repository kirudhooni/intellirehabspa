<template>
    <div>
        <div class="text-center display-1" > <h1>IntelliRehab</h1></div> <hr>
            <div class="row justify-content-center">
                <img src="/img/avatar.png" height="300px" width="300px">
            </div>
            <div class="row justify-content-center">
                <form @submit.prevent="authenticate" class="col-md-8">
                    <div class="form-group row">
                        <!-- <label for="username" class="col-md-4 col-form-label text-md-left">Username:</label> -->

                        <div class="col-md-12 ">
                            <input id="username" type="username" class="form-control" placeholder="Username" v-model="form.username" @keydown="errorClear">
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- <label for="password" class="col-md-4 col-form-label text-md-left">Password:</label> -->

                        <div class="col-md-12 ">
                            <input id="password" type="password" class="form-control" placeholder="Password" v-model="form.password" @keydown="errorClear">
                        </div>
                    </div>
                    <span class="help is-danger" style="color:red;" v-text="form.errors"></span>
                    

                    <div class="form-group row">
                        <div class="col-md-12 ">
                            <input class=" btn btn-success" type="submit" value="login" style="width:100%;">
                        </div>
                   </div>
                </form>
                  
            
        </div>
    </div>
    
</template>

<script>

    import {login} from '../helpers/auth';
    import Event from '../app.js'
    //import store from '../store';
    export default {
        mounted() {
            console.log('Login Component mounted.')
        },

        name: "loginPage",

        computed: {
            welcome() {
                return this.$store.getters.welcome;
            }
        },
        data() {

            return {
                form: {
                    username: '',
                    password: '',
                    errors: ''
                },
                error: null
            };
        },

        methods:{
            authenticate(){
                this.$store.dispatch('login');

                login(this.$data.form)
                    .then((res) => {
                        
                        Event.$emit('loggedIn');
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: './'});
                    })
                    .catch((error) => {
                        this.form.errors = error;
                        this.$store.commit("loginFailed", {error});
                    })
            },
            
            errorClear(){
                this.form.errors ='';
            }
        }
    }
</script>
