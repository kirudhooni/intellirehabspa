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

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="current_version">Current Version</label>
        <input type="number" step=".01" name="current_version" id="current_version" class="form-control col-md-9" v-model="form.current_version">
        
        <span class="help is-danger" v-text="errors.get('current_version')"></span>
    </div>
    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="current_version">Upload APK file</label>
        <uploadApk @uploadedFile="updateFile"></uploadApk>
        
        
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
    import uploadApk from '../components/UploadApk.vue';
    export default {
        name: 'add',
        components: {
            uploadApk
        },
        data(){
            return{
                form: {
                    name :'',
                    description :'',
                    current_version: ''
                    
                },
                files:[],
                errors: new Errors()
            }
        },
        mounted(){
            console.log('add game mounted')
        },
        methods:{
                submitForm(){
                axios.post('/api/games/add', this.$data.form,{
                    headers: {
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    if(submitFiles()){
                    this.$store.commit("updateGameAddedTrue");
                    this.$router.push({path: '/games'});
                    console.log(response);
                    }
                    else{
                        alert('Failed to upload APK file to server!')
                    }
                })
                .catch((error) => this.errors.record(error.response.data.errors));
                
            }
        },
        submitFiles() {
                for( let i = 0; i < this.files.length; i++ ){
                    if(this.files[i].id) {
                        continue;
                    }
                    let formData = new FormData();
                    formData.append('file', this.files[i]);

                    axios.post('/api/games/uploadAPK',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                            }
                        }
                    ).then((response)=>{
                        true
                    })
                    .catch((error) => false);
                }
            },
            updateFile(value){
                this.files = value;
            }


    }
</script>

<style>
    .is-danger{
        color: red;
        margin-left: 200px;
    }
</style>