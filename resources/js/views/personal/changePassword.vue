<template>
<div class="container">
    <form @submit.prevent="submitForm" @keydown="errors.clear($event.target.name)">
     <div class="row border py-4">
        <label class="col-form-label col-md-2" for="oldPassword">Old Password</label>
        <input type="password"  name="oldPassword" id="oldPassword" class="form-control col-md-9" v-model="form.oldPassword">
        
        <span class="help is-danger" v-text="errors.get('oldPassword')"></span>

    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="newPassword">New Password</label>
        <input type="password" value="" name="newPassword" id="newPassword" class="form-control col-md-9" v-model="form.newPassword">

        <span class="help is-danger" v-text="errors.get('newPassword')"></span>
    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="confirmPassword">Confirm Password</label>
        <input type="password" value="" name="confirmPassword" id="confirmPassword" class="form-control col-md-9" v-model="form.confirmPassword">

        <span class="help is-danger" v-text="errors.get('confirmPassword')"></span>
    </div>
    
    <div class="row border py-4">
        <button type="submit" class="btn btn-success col-md-5">Sumbit</button>
        <div class="col-md-2"></div>
        <router-link class="btn btn-danger  col-md-5" role="button" to="/admin">Cancel</router-link>
        
    </div>

    </form>
    </div>
</template>

<script>

    class Errors{

        constructor(){
            this.errors = {}
        }
        get(field){
            if (this.errors[field]){
                return this.errors[field][0];
            }
        }

        record(errors){
            this.errors = errors;
        }

        clear(field){
            delete this.errors[field];
        }
    }

    export default {
        name: 'changePassword',
        computed: {
            
        },
        data(){
            return{
                form: {
                    oldPassword: '',
                    newPassword: '',
                    confirmPassword: ''
                },
                

                errors: new Errors()
            }
        },
        mounted(){
            console.log('changePassword mounted')
        },
        created(){
            
        },
        methods:{
                submitForm(){
                axios.post(`/api/personal/edit/changepassword/${this.$route.params.id}`, this.$data.form,{
                    headers: {
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.$store.commit("updateUserUpdatedTrue");
                    this.$router.push({path: '/admin'});
                })
                .catch((error) => this.errors.record(error.response.data.errors));
                
            }
        }

    }
</script>

<style>
    .is-danger{
        color: red;
        margin-left: 200px;
    }
</style>