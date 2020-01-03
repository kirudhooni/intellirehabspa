<template>
<div>
    <h2 class="display-4 form-label-mb-5">Add Exercise</h2>
    
     <div class="row border py-4">
        <label class="col-form-label col-md-2" for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control col-md-9" v-model="form.name">
        
        <span class="help is-danger" v-text="errors.get('name') " @keydown="errors.clear(errors.name)"></span>

    </div>

    <div class="row border py-4">
            <label class="col-form-label col-md-2" for="description">Description</label>
            <textarea rows="5" type="textarea"  name="description" id="description" class="form-control col-md-9 " v-model="form.description"></textarea>
    </div>

    <dualListBox :list1 ="list1" :list2="list2" firstTitle="Assigned Joints" secondTitle="All Joints" @inGroup="updateMasterList" @notInGroup="updateMasterList2"></dualListBox>

    <dualListBox :list1 ="list1game" :list2="list2game" firstTitle="Assigned Games" secondTitle="All Games" selectedGroup="sss" @inGroup="updateMasterListGame" @notInGroup="updateMasterList2Game"></dualListBox>

    <div class="row  py-4 col-md-12">
                <button @click="submitForm" class="btn btn-success col-md-4">Sumbit</button>
                <div class="col-md-2"></div>
                <router-link class="btn btn-danger  col-md-4" role="button" to="/admin">Cancel</router-link>
        
            </div>

    
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

    import DualListBox from '../components/dualListBox.vue';
    export default {
        name: 'add',
        components:{
            DualListBox
        },
        computed: {
            
        },
        data(){
            return{
                form: {
                    name :'',
                    description :'',
                    assignedJoints :'',
                    unassignedJoints : '',
                    assignedGames:'',
                    unassignedGames:'',
                    showSuccess: false
                    
                },
                list1: [],
                list2: [],
                list1game: [],
                list2game: [],


                errors: new Errors()
            }
        },
        mounted(){
            console.log('add exercise mounted')
        },
        created(){
                this.list1 = []
                this.list2 =[]
                this.list1game = []
                this.list2game =[]
                
                axios.get(`/api/exercises/edit/${this.$route.params.id}`,{
                headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.form.name = response.data.exercise.name
                    this.form.description = response.data.exercise.description
                });
                axios.get(`/api/exercises/getJointsInExercise/${this.$route.params.id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }

                }).then((response) => {
                    
                  for (var i = 0; i < response.data.joints.length; i++) {  
                  this.list1.push(response.data.joints[i].name);
                  
                  }
            });
                
                axios.get(`/api/exercises/getJointsNotInExercise/${this.$route.params.id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                         }
                }).then((response) => {  
                    
                  for (var i = 0; i < response.data.joints.length; i++) {   
                  this.list2.push(response.data.joints[i].name);
                  
                  }
              });


              axios.get(`/api/exercises/getGamesInExercise/${this.$route.params.id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }

                }).then((response) => {
                    
                  for (var i = 0; i < response.data.games.length; i++) {  
                  this.list1game.push(response.data.games[i].name);
                  
                  }
            });
                axios.get(`/api/exercises/getGamesNotInExercise/${this.$route.params.id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                         }
                }).then((response) => {  
                    
                  for (var i = 0; i < response.data.games.length; i++) {   
                  this.list2game.push(response.data.games[i].name);
                  
                  }
              });
        },
        methods:{
                
            submitForm(){
                axios.post(`/api/exercises/add`,
                      
                        this.form
                    ,{
                    headers: {
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response)=> {
                    this.showSuccess = true;
                    this.$router.push({path: '/exercises'});
                })
                .catch((error) => this.errors.record(error.response.data.errors));
                
            },
            updateMasterList(value){
                this.form.assignedJoints = value;
            },
            updateMasterList2(value){
                this.form.unassignedJoints = value;
            },
            updateMasterListGame(value){
                this.form.assignedGames = value;
                
            },
            updateMasterList2Game(value){
                this.form.unassignedGames = value;
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