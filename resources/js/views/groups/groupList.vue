<template>
    <div class="container">
        <h1>Admin Group-List</h1>
        <successAlert alertHeader ="Success!" alertMessage ="New Group Added!" getter = "groupAdded" commit = "updateGroupAddedFalse"></successAlert> 
        <successAlert alertHeader ="Success!" alertMessage ="Group Updated!" getter = "groupUpdated" commit = "updateGroupUpdatedFalse"></successAlert>   
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
                                   <template v-if="!groups.length">   
                                        <tr>
                                            <td colspan="6" class="text-center">No Groups Available</td>
                                        </tr>
                                   </template>
                                   <template v-else>   
                                        <tr v-for="(group, key) in groups" :key="group.id">
                                            <td>{{ group.name }}</td>
                                            <td>{{ group.description }}</td>
                                            <td>{{ group.updated_at }}</td>
                                            <td  ref="status">{{ group.status }}</td>
                                            <td>
                                                <router-link class="btn btn-outline-secondary" :to="`/groups/edit/${group.id}`">Edit</router-link>
                                            </td>
                                            <td>
                                                <button ref="deacButton" class="btn btn-outline-secondary" @click="deactivateGroup(group.id,key)">{{group.status == 'active' ?'Deactivate':'Activate'}}{{deacButton}}</button>
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
        }
    },
    components: {
            SuccessAlert,
            },
    mounted() {
        
        this.$store.dispatch('getGroups');
        
    },
    computed:{
        groups(){
            return this.$store.getters.groups;
        },
        
    },
    methods:{
        deactivateGroup(group_id,key){
            axios.get(`/api/groups/deactivate/${group_id}`,{
                headers:{
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.$refs.status[key].innerHTML = response.data.group_status
                this.$refs.deacButton[key].innerHTML = this.$refs.status[key].textContent == 'active' ?'Deactivate':'Activate'
                
            });
            
        },
        
    }
}
</script>