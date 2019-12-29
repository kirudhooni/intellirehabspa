<template>
    <div v-if="showComponent" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> New User Added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="resetUserAdded">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
export default {
    name: 'success-alert',
    data(){
        return{
            message: ''
        }
    },
    computed:{
        showComponent(){
            
            return this.$store.getters.userAdded;
            //return true;
        }
    },
    methods:{
        resetUserAdded(){
            this.$store.commit("updateUserAddedFalse");
        }
    }
}
</script>