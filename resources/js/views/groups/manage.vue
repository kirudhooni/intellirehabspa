<template>
    <div class="container">
        <h2 class="display-4 form-label-mb-5">Manage Groups</h2>
        <div v-if="showSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Group Updated!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- select box -->
        <div class="row col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Group:</label>
                            <select class='form-control' v-model="selected" @change="passSelectedGroup()">
                              <option v-for="(group, key) in groups" v-bind:value="{ id: group.id, text: group.name }" >{{ group.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>

        <dualListBox :list1 ="list1" :list2="list2" firstTitle="In Group" secondTitle="Not In Group"  @inGroup="updateMasterList" @notInGroup="updateMasterList2"></dualListBox>

        
            <div class="row  py-4 col-md-12">
                <button @click="submitForm()" class="btn btn-success col-md-4">Sumbit</button>
                <div class="col-md-2"></div>
                <router-link class="btn btn-danger  col-md-4" role="button" to="/admin">Cancel</router-link>
        
            </div>
        
    </div>
</template>

<script>
import DualListBox from '../components/dualListBox.vue';
export default {
    name: 'manage',
    data(){
        return{
            selected: '',
            masterlist1 :'',
            masterlist2 : '',
            list1: [],
            list2: [],
            showSuccess: false
        }
    },
    components: {
                DualListBox,
            },
    mounted() {
        
        this.$store.dispatch('getGroups',null,{ root: true });
        
    },
    computed:{
        groups(){
            return this.$store.getters.groups;
        },
        // showSuccess(){
        //     return this.showSuccess;
        // }
        
    },
    methods:{
        
        passSelectedGroup(){
            //Event.$emit('idSelected',this.selected.id);
            //get data from server
                this.list1 = []
                this.list2 =[]
                //axios.get(`/api/users/getUsersInGroup/${group}`,{
                axios.get(`/api/users/getUsersInGroup/${this.selected.id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }

                }).then((response) => {
                    
                  for (var i = 0; i < response.data.users.length; i++) {  
                  this.list1.push(response.data.users[i].username);
                  
                  }
            });
                //axios.get(`/api/users/getUsersNotInGroup/${group}`,{
                axios.get(`/api/users/getUsersNotInGroup/${this.selected.id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                         }
                }).then((response) => {  
                    
                  for (var i = 0; i < response.data.users.length; i++) {   
                  this.list2.push(response.data.users[i].username);
                  
                  }
              });
            
        },
        updateMasterList(value){
            this.masterlist1 = value;
        },
        updateMasterList2(value){
            this.masterlist2 = value;
        },
        submitForm(){
            axios.post(`/api/groups/addUsers/${this.selected.id}`,
                [
                    this.masterlist1, 
                    this.masterlist2
                ],{
                headers: {
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response)=> {
                this.showSuccess = true;
            })
            
        }

    }
}
</script>