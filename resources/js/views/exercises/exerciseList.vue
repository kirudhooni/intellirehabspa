<template>
    <div class="container">
        <h2 class="display-4 form-label-mb-5">Exercise List</h2>
        <successAlert alertHeader ="Success!" alertMessage ="New exercise Added!" getter = "exerciseAdded" commit = "updateexerciseAddedFalse"></successAlert> 
        <successAlert alertHeader ="Success!" alertMessage ="exercise Updated!" getter = "exerciseUpdated" commit = "updateexerciseUpdatedFalse"></successAlert>   
        <div class="row">
                <div class="col-lg-12">
                    <div class="main-box clearfix">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th><span>Name</span></th>
                                        <th><span>Description</span></th>
                                        <th><span>Last Update</span></th>
                                        <th ><span>Status</span></th>
                                        <th ><span>Action</span></th>
                                    
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <template v-if="!exercises.length">   
                                        <tr>
                                            <td colspan="6" class="text-center">No exercises Available</td>
                                        </tr>
                                   </template>
                                   <template v-else>   
                                        <tr v-for="(exercise, key) in exercises" :key="exercise.id">
                                            <td>{{ exercise.name }}</td>
                                            <td>{{ exercise.description }}</td>
                                            <td>{{ exercise.updated_at }}</td>
                                            <td  ref="status">{{ exercise.status }}</td>
                                            <td>
                                                <router-link class="btn btn-outline-secondary" :to="`/exercises/edit/${exercise.id}`">Edit</router-link>
                                            </td>
                                            <td>
                                                <button ref="deacButton" class="btn btn-outline-secondary" @click="deactivateexercise(exercise.id,key)">{{exercise.status == 'active' ?'Deactivate':'Activate'}}{{deacButton}}</button>
                                            </td>
                                        </tr>
                                   </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>


<script>
import SuccessAlert from './../successAlert.vue';
export default {
    name: 'list',
    data(){
        return{
            deacButton: '', 
            exercises: []
        }
    },
    components: {
            SuccessAlert,
            },
    mounted() {
        
        axios.get('http://localhost:8000/api/exercises', {
                headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.exercises = response.data.exercises;
            })  
        
    },
    methods:{
        deactivateexercise(exercise_id,key){
            axios.get(`/api/exercises/deactivate/${exercise_id}`,{
                headers:{
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.$refs.status[key].innerHTML = response.data.exercise_status
                this.$refs.deacButton[key].innerHTML = this.$refs.status[key].textContent == 'active' ?'Deactivate':'Activate'
                
            });
            
        },
        
    }
}
</script>