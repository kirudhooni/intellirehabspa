<template>
<div>
    <form @submit.prevent="submitForm">
     <div class="row border py-4">
        <label class="col-form-label col-md-2" for="first-name">First Name</label>
        <input type="text" name="firstname" id="firstname" class="form-control col-md-9" v-model="form.firstname">
        
        

    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="last-name">Last Name</label>
        <input type="text" value="" name="lastname" id="last-name" class="form-control col-md-9" v-model="form.lastname">

    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="user-name">Username</label>
        <input type="text" value="" name="username" id="user-name" class="form-control col-md-9 " v-model="form.username">

    </div>
   
    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="phone">Phone</label>
        <input type="text" value="" name="phone" id="phone" class="form-control col-md-9" v-model="form.phone">
    
    </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="e-mail">E-mail</label>
    <input type="email" value="" name="email" id="e-mail" class="form-control col-md-9" v-model="form.email">
        
    </div>

    <div class="row border py-4">
            <label class="col-form-label col-md-2" for="note">Note</label>
            <textarea rows="5" type="textarea"  name="note" id="note" class="form-control col-md-9 " v-model="form.note"></textarea>
    </div>

    
    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="level" >Level</label>
        <select name="level" class="form-control col-md-9" v-model="form.level">
                <option value="Therapist">Therapist</option>
                <option value="Doctor">Doctor</option>
                <option value="Admin">Admin</option>
        </select>
        
            
    </div>
    
    <span class="help is-danger" v-text="errors"></span>
    <div class="row border py-4">
        <button type="submit" class="btn btn-primary form-control col-md-5">Sumbit</button>
        <a class="btn btn-primary form-control ml-2 col-md-5" href="#" role="button">Cancel</a>
    
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

        record(Errors){
            this.errors = errors;
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

                errors:{}
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
                .then((response) => alert('User Added!'))
                .catch((error) => this.errors = error);
                
            }
        }

    }
</script>