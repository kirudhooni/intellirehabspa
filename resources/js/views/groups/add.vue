<template>
<div>
    <h2 class="display-4 form-label-mb-5">Add Group</h2>
    <form @submit.prevent="submitForm" @keydown="errors.clear($event.target.name)">
     <div class="row border py-4">
        <label class="col-form-label col-md-2" for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control col-md-9" v-model="form.name">
        
        <span class="help is-danger" v-text="errors.get('name')"></span>

    </div>

    <div class="row border py-4">
            <label class="col-form-label col-md-2" for="description">Description</label>
            <textarea rows="5" type="textarea"  name="description" id="description" class="form-control col-md-9 " v-model="form.description"></textarea>
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
        name: 'add',
        computed: {
            
        },
        data(){
            return{
                form: {
                    name :'',
                    description :''
                    
                },

                errors: new Errors()
            }
        },
        mounted(){
            console.log('add group mounted')
        },
        methods:{
                submitForm(){
                axios.post('/api/groups/add', this.$data.form,{
                    headers: {
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.$store.commit("updateGroupAddedTrue");
                    this.$router.push({path: '/groups'});
                    console.log(response);
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