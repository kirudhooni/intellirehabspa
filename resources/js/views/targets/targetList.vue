<template>
    <div class="container">
        <h2 class="display-4 form-label-mb-5">Preassigned Targets List</h2>
        <successAlert alertHeader ="Success!" alertMessage ="New Target Added!" getter = "targetAdded" commit = "updateGameAddedFalse"></successAlert> 
        <successAlert alertHeader ="Success!" alertMessage ="Target Updated!" getter = "gameUpdated" commit = "updateGameUpdatedFalse"></successAlert>   
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
                                   <template v-if="!targets.length">   
                                        <tr>
                                            <td colspan="6" class="text-center">No targets Available</td>
                                        </tr>
                                   </template>
                                   <template v-else>   
                                        <tr v-for="(target, key) in targets" :key="target.id">
                                            <td>{{ target.name }}</td>
                                            <td>{{ target.description }}</td>
                                            <td>{{ target.updated_at }}</td>
                                            <td  ref="status">{{ target.status }}</td>
                                            <td>
                                                <router-link class="btn btn-outline-secondary" :to="`/targets/edit/${target.id}`">Edit</router-link>
                                            </td>
                                            <td>
                                                <button ref="deacButton" class="btn btn-outline-secondary" @click="deactivategame(target.id,key)">{{target.status == 'active' ?'Deactivate':'Activate'}}{{deacButton}}</button>
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
            targets: []
        }
    },
    components: {
            SuccessAlert,
            },
    created() {
        
        axios.get('/api/targets', {
                headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.targets = response.data.targets;
            })  
        
    },
    methods:{
        deactivategame(game_id,key){
            axios.get(`/api/targets/deactivate/${game_id}`,{
                headers:{
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.$refs.status[key].innerHTML = response.data.target_status
                this.$refs.deacButton[key].innerHTML = this.$refs.status[key].textContent == 'active' ?'Deactivate':'Activate'
                
            });
            
        },
        
    }
}
</script>