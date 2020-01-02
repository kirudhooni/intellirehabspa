<template>
<div>
    <form @submit.prevent="submitForm" @keydown="errors.clear($event.target.name)">
     <div class="row border py-4">
        <label class="col-form-label col-md-2" for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control col-md-9" v-model="form.name">
        
        <span class="help is-danger" v-text="errors.get('name')"></span>

    </div>

    <div class="row border py-4">
            <label class="col-form-label col-md-2" for="description">Description</label>
            <textarea rows="5" type="textarea"  name="description" id="description" class="form-control col-md-9 " v-model="form.description"></textarea>
    </div>

    <dualListBox firstTitle="Assigned Joints" secondTitle="All Joints" @inGroup="updateMasterList" @notInGroup="updateMasterList2"></dualListBox>

    <dualListBox firstTitle="Assigned Games" secondTitle="All Games" selectedGroup="sss" @inGroup="updateMasterList" @notInGroup="updateMasterList2"></dualListBox>

    <div class="row  py-4 col-md-12">
                <button @click="submitForm()" class="btn btn-success col-md-4">Sumbit</button>
                <div class="col-md-2"></div>
                <router-link class="btn btn-danger  col-md-4" role="button" to="/admin">Cancel</router-link>
        
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
                    masterlist1 :'',
                    masterlist2 : '',
                    showSuccess: false
                    
                },

                errors: new Errors()
            }
        },
        mounted(){
            console.log('add exercise mounted')
        },
        methods:{
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

<style>
    .is-danger{
        color: red;
        margin-left: 200px;
    }
</style>