<template>
<div>
    <h2 class="display-4 form-label-mb-5">Upload APK</h2>
    <form @submit.prevent="submitForm" @keydown="errors.clear($event.target.name)">
       <div class="row border py-4">
            <label class="col-form-label col-md-2">Select Game:</label>
            <select class="form-control col-md-9" v-model="selected">
                <option v-for="(game, key) in games" v-bind:value="{ id: game.id, text: game.name }" >{{ game.name }}</option>
            </select>    
        </div>

    <div class="row border py-4">
        <label class="col-form-label col-md-2" for="current_version">Version</label>
        <input type="number" step=".01" name="current_version" id="current_version" class="form-control col-md-9" v-model="form.version">
        
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
    data(){
        return{
            form: {
                    
                    version: ''
                    
                },
                files:[],
                selected:'',
                games:[],
                errors: new Errors
        }
    },
    components:{
        uploadApk
    },
    created(){
        axios.get('/api/games', {
                headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.games = response.data.games;
            })  
    },
    methods:{
        updateFile(value){
                this.files = value;
        },
        submitForm(){
                    let formData = new FormData();
                    formData.append('file', this.files[0]);    
                    formData.append('version', this.form.version);
                    formData.append('game', this.selected.id);  
                    axios.post('/api/games/uploadAPK', formData,{
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

    }
}
</script>