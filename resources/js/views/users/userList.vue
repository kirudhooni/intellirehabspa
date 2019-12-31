<template>
    <div class="container">
        <h1>Admin User-List</h1>
        <successAlert alertHeader ="Success!" alertMessage ="New User Added!" getter = "userAdded" commit = "updateUserAddedFalse"></successAlert>   
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
                                        <tr v-for="user in users" :key="user.id">
                                            <td>{{ user.firstname }}</td>
                                            <td>{{ user.lastname }}</td>
                                            <td>{{ user.username }}</td>
                                            <td>{{ user.level }}</td>
                                            <td>{{ user.updated_at }}</td>
                                            <td>{{ user.status }}</td>
                                            <td>
                                                <router-link :to="`/users/edit/${user.id}`">Edit</router-link>
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
    components: {
            SuccessAlert,
            },
    mounted() {
        
        this.$store.dispatch('getUsers');
    },
    computed:{
        users(){
            return this.$store.getters.users;
        }
    }
}
</script>