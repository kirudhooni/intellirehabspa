<template>
    <div v-if="showComponent" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{alertHeader}}</strong> {{alertMessage}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="resetUserAdded">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
export default {
    name: 'success-alert',
    props: [
        'alertHeader',
        'alertMessage',
        'getter',
        'commit'

    ],
    data(){
        return{
            message: ''
        }
    },
    computed:{
        showComponent(){
            
            return this.$store.getters[this.getter];
            //return true;
        }
    },
    methods:{
        resetUserAdded(){
            this.$store.commit(this.commit);
        }
    }
}
</script>