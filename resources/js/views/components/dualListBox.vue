<template>
    <div>
        <div class="row" style="padding-top:30px; padding-bottom:10px;">
            <h3 class="col-md-4 text-center" for="inGroup">{{firstTitle}}</h3>
            <div class="col-md-2"></div>
            <h3 class="col-md-4 text-center" for="notInGroup">{{secondTitle}}</h3>
        </div>
        <div class="row">
            
            <div class="col-md-4">
                <select size="20" class="form-control" name="inGroup" id="list1" multiple>
                    <option v-for="item1 in list1" >{{ item1 }}</option>
                </select>
            </div>
            <div class="col-md-2" style="margin-top:100px;">
                <button class="btn btn-danger btn-block mb-2" @click="oneToRight">&raquo;</button>
                <button class="btn btn-success btn-block mb-2" @click="oneToLeft">&laquo;</button>
            </div>
            
            <div class="col-md-4">
                <select size="20" class="form-control" name="notInGroup" id="list2" multiple>
                    <option v-for="item2 in list2" >{{ item2 }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'dualListBox',

        props:[
            'selectedGroup',
            'firstTitle',
            'secondTitle',
            'firstURL',
            'secondURL',
        ],
        mounted() {
            console.log('DualListBox mounted.')
        },

        data() {
            return {
                
                newUsers: '',
                list1: [],
                list2: [],
                allUsers: [],
            }
        },
        methods: {
            oneToRight() {
                 
                var select = [];   
                var i; 
                $("#list1 :selected").each(function(){
                    select.push($(this).val()); 
                });
                if (select != ""){
                    for (i = 0; i < select.length; i++) {
                    this.list2.push(select[i])
                    var del = this.list1.indexOf(select[i])
                    this.list1.splice(del,1)
                    }
                    
                }
                this.$emit('notInGroup',this.list2);
                this.$emit('inGroup',this.list1);
            },
            oneToLeft() {
                var select = [];   
                var i; 
                $("#list2 :selected").each(function(){
                    select.push($(this).val()); 
                });
                if (select != ""){
                    for (i = 0; i < select.length; i++) {
                    this.list1.push(select[i])
                    var del = this.list2.indexOf(select[i])
                    this.list2.splice(del,1)
                    }
                    
                }

                this.$emit('notInGroup',this.list2);
                this.$emit('inGroup',this.list1);
            },
        },

        created(){
            
               Event.$on('idSelected',(id)=>{

                this.allUsers=[]
                this.list1 = []
                this.list2 =[]
                //axios.get(`/api/users/getUsersInGroup/${group}`,{
                axios.get(`${this.firstURL}${id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }

                }).then((response) => {
                    
                  for (var i = 0; i < response.data.users.length; i++) {  
                  this.list1.push(response.data.users[i].username);
                  
                  }
            });
                //axios.get(`/api/users/getUsersNotInGroup/${group}`,{
                axios.get(`${this.secondURL}${id}`,{
                    headers: {
                         "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                         }
                }).then((response) => {  
                    
                  for (var i = 0; i < response.data.users.length; i++) {   
                  this.list2.push(response.data.users[i].username);
                  
                  }
              });
            });
        },
    }
</script>
