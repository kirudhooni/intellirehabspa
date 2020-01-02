<template>
    <div class="container">
        <h2 class="display-4 form-label-mb-5">User List</h2>
        <successAlert alertHeader ="Success!" alertMessage ="New User Added!" getter = "userAdded" commit = "updateUserAddedFalse"></successAlert> 
        <successAlert alertHeader ="Success!" alertMessage ="User Updated!" getter = "userUpdated" commit = "updateUserUpdatedFalse"></successAlert>   
        <div class="row">
                <div class="col-lg-12">
                    <div class="main-box clearfix">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th><span>Firstname</span></th>
                                        <th><span>Lastname</span></th>
                                        <th><span>Username</span></th>
                                        <th><span>Authentication Level</span></th>
                                        <th><span>Last Update</span></th>
                                        <th ><span>Status</span></th>
                                        <th ><span>Action</span></th>
                                    
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <template v-if="!users.length">   
                                        <tr>
                                            <td colspan="8" class="text-center">No Users Available</td>
                                        </tr>
                                   </template>
                                   <template v-else>   
                                        <tr v-for="(user, key) in users" :key="user.id">
                                            <td>{{ user.firstname }}</td>
                                            <td>{{ user.lastname }}</td>
                                            <td>{{ user.username }}</td>
                                            <td>{{ user.level }}</td>
                                            <td>{{ user.updated_at }}</td>
                                            <td  ref="status">{{ user.status }}</td>
                                            <td>
                                                <router-link class="btn btn-outline-secondary" :to="`/users/edit/${user.id}`">Edit</router-link>
                                            </td>
                                            <td>
                                                <button ref="deacButton" class="btn btn-outline-secondary" @click="deactivateUser(user.id,key)">{{user.status == 'active' ?'Deactivate':'Activate'}}{{deacButton}}</button>
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
        
        this.$store.dispatch('getUsers');
        
    },
    computed:{
        users(){
            return this.$store.getters.users;
        },
        
    },
    methods:{
        deactivateUser(user_id,key){
            axios.get(`/api/users/deactivate/${user_id}`,{
                headers:{
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.$refs.status[key].innerHTML = response.data.user_status
                this.$refs.deacButton[key].innerHTML = this.$refs.status[key].textContent == 'active' ?'Deactivate':'Activate'
                
            });
            
        },
        
    }
}
</script>