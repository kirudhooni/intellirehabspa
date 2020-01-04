<template>
    <div class="container">
        <h2 class="display-4 form-label-mb-5">Games List</h2>
        <successAlert alertHeader ="Success!" alertMessage ="New Game Added!" getter = "gameAdded" commit = "updateGameAddedFalse"></successAlert> 
        <successAlert alertHeader ="Success!" alertMessage ="Game Updated!" getter = "gameUpdated" commit = "updateGameUpdatedFalse"></successAlert>   
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
                                   <template v-if="!games.length">   
                                        <tr>
                                            <td colspan="6" class="text-center">No games Available</td>
                                        </tr>
                                   </template>
                                   <template v-else>   
                                        <tr v-for="(game, key) in games" :key="game.id">
                                            <td>{{ game.name }}</td>
                                            <td>{{ game.description }}</td>
                                            <td>{{ game.updated_at }}</td>
                                            <td  ref="status">{{ game.status }}</td>
                                            <td>
                                                <router-link class="btn btn-outline-secondary" :to="`/games/edit/${game.id}`">Edit</router-link>
                                            </td>
                                            <td>
                                                <button ref="deacButton" class="btn btn-outline-secondary" @click="deactivategame(game.id,key)">{{game.status == 'active' ?'Deactivate':'Activate'}}{{deacButton}}</button>
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
            games: []
        }
    },
    components: {
            SuccessAlert,
            },
    mounted() {
        
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
        deactivategame(game_id,key){
            axios.get(`/api/games/deactivate/${game_id}`,{
                headers:{
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.$refs.status[key].innerHTML = response.data.game_status
                this.$refs.deacButton[key].innerHTML = this.$refs.status[key].textContent == 'active' ?'Deactivate':'Activate'
                
            });
            
        },
        
    }
}
</script>