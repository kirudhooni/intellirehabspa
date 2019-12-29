<template>
<div>
    <form @submit.prevent="submitForm" @keydown="errors.clear($event.target.name)">
     <div class="row border py-4">
        <label class="col-form-label col-md-2" for="first-name">First Name</label>
        <input type="text" name="firstname" id="firstname" class="form-control col-md-9" v-model="form.firstname">
        
        <span class="help is-danger" v-text="errors.get('firstname')"></span>

    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="last-name">Last Name</label>
        <input type="text" value="" name="lastname" id="last-name" class="form-control col-md-9" v-model="form.lastname">

        <span class="help is-danger" v-text="errors.get('lastname')"></span>
    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="user-name">Username</label>
        <input type="text" value="" name="username" id="user-name" class="form-control col-md-9 " v-model="form.username">

        <span class="help is-danger" v-text="errors.get('username')"></span>
    </div>
   
    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="phone">Phone</label>
        <input type="text" value="" name="phone" id="phone" class="form-control col-md-9" v-model="form.phone">

        <span class="help is-danger" v-text="errors.get('phone')"></span>
    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="e-mail">E-mail</label>
        <input type="email" value="" name="email" id="e-mail" class="form-control col-md-9" v-model="form.email">
        <span class="help is-danger" v-text="errors.get('email')"></span>
    </div>

    <div class="row border py-4">
            <label class="col-form-label col-md-2" for="note">Note</label>
            <textarea rows="5" type="textarea"  name="note" id="note" class="form-control col-md-9 " v-model="form.note"></textarea>
    </div>

    
    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="level" >Level</label>
        <select name="level" class="form-control col-md-9" v-model="form.level" @change="errors.clear('level')">
                <option value="Therapist">Therapist</option>
                <option value="Doctor">Doctor</option>
                <option value="Admin">Admin</option>
        </select>
        <span class="help is-danger" v-text="errors.get('level')"></span>

    </div>
    
    
    <div class="row border py-4">
        <button type="submit" class="btn btn-primary col-md-5">Sumbit</button>
        <div class="col-md-2"></div>
        <a class="btn btn-primary  col-md-5" href="#" role="button">Cancel</a>
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
        name: 'add',
        computed: {
            
        },
        data(){
            return{
                form: {
                    firstname :'',
                    lastname :'',
                    username : '',
                    phone : '',
                    email : '',
                    level : '',
                    note :''
                },

                errors: new Errors()
            }
        },
        mounted(){
            console.log('add user mounted')
        },
        methods:{
                submitForm(){
                axios.post('/api/users/add', this.$data.form,{
                    headers: {
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.$store.commit("updateUserAddedTrue");
                    this.$router.push({path: '/users'});
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