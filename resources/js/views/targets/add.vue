<template>
<div>
    <h2 class="display-4 form-label-mb-5">Add Game</h2>
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

    <div class="row py-4"></div>

    <div class="row border py-4">
        <table class="table table-striped table-bordered">
            <tr>
                <th width= "25%">Joint</th>
                <th width= "25%">ROM</th>
                <th width= "55%" >ROM Value</th>
            </tr>
            
            <template v-for="joint in form.jointData">  
            <tr>
                <td ><strong>{{joint.description}}</strong></td>
                <td></td>
                <td></td>
            </tr>

            <tr v-for="rom in joint.roms">
                <td></td>
                <td  >{{rom.name}}</td>
                <td><input class="form-control col-md-12" type="text"></td>
            </tr>
           </template>
        </table>
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
        components: {
           
        },
        data(){
            return{
                form: {
                    name :'',
                    description :'',
                    jointData:[],
                    
                },
                
                errors: new Errors()
            }
        },
        mounted(){
            console.log('add game mounted')
        },
        created(){

                axios.get('/api/joints/getRoms',{
                    headers:{
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.form.jointData = response.data.joints
                    
                })
        },
        methods:{
                submitForm(){
                    let formData = new FormData();
                    formData.append('file', this.files[0]);    
                    formData.append('name', this.form.name);
                    formData.append('description', this.form.description);
                    formData.append('current_version', this.form.current_version);
                    axios.post('/api/games/add', formData,{
                        headers: {
                            "Authorization": `Bearer ${this.$store.state.currentUser.token}`,
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then((response) => {
                        
                        this.$store.commit("updateGameAddedTrue");
                        this.$router.push({path: '/games'});
                        console.log(response);
                        
                    })
                    .catch((error) => this.errors.record(error.response.data.errors));
                
            },
            
        },
        

    }
</script>

<style>
    .is-danger{
        color: red;
        margin-left: 200px;
    }
</style>