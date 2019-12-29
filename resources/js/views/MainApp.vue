<template>
    <div id="main">
        <div class="content">
            
            <div v-if="haveUser">
                <Header></Header>
            </div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Header from './Header.vue';
    export default {
        name: 'main-app',
        components: {Header},
        data(){
            return{
                haveUser: false
            }
        },
        mounted(){
            this.haveUser= this.$store.getters.isLoggedIn;
            Event.$on('loggedIn', () => this.haveUser = true);
            Event.$on('loggedOut', ()=> this.haveUser = false);
        }
    }
</script>

