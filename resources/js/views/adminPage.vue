<template>
    <div class="container">
        <h1>Admin Page</h1>
        <br>
        <div class="form-row my-4" style="background-color: #BCC2C7; border-radius:10px;">
            <label class="col-md-2 col-form-label text-center" ><h2 class="text-center">Patients</h2></label>
            <a class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" href="#" role="button">Add</a>
            <a class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" href="#" role="button">View/Edit</a>
        </div>
        <div class="form-row  my-4" style="background-color: #BCC2C7; border-radius:10px;">
            <label class="col-md-2 col-form-label" ><h2 class="text-center">Groups</h2></label>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/groups/add">Add</router-link>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/groups">View/Edit</router-link>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/groups/manage">Manage</router-link>
            <button class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" @click="downloadGroups">Download Groups</button>
        </div>

    <!-- authauser -->
        <div class="form-row  my-4" style="background-color: #BCC2C7; border-radius:10px;">
            <label class="col-md-2 col-form-label text-center" ><h2 class="text-center">Users</h2></label>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/users/add">Add</router-link>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/users">Edit/View</router-link>
            <button class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" @click="downloadUsers">Download Users</button>
        </div>
    <!-- exercises -->
        <div class="form-row  my-4" style="background-color: #BCC2C7; border-radius:10px;">
            <label class="col-md-2 col-form-label text-center" ><h2 class="text-center">Exercise</h2></label>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/exercises/add">Add</router-link>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/exercises">Edit/View</router-link>
            <button class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" @click="downloadExercises">Download Exercises</button>
        </div>

    <!-- games -->
        <div class="form-row  my-4" style="background-color: #BCC2C7; border-radius:10px;">
            <label class="col-md-2 col-form-label text-center" ><h2 class="text-center">Game</h2></label>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/games/add">Add</router-link>
            <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" to="/games">Edit/View</router-link>
            <button class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" @click="downloadGames">Download Games</button>
        </div>
        

        <div class="form-row  my-4" style="background-color: #BCC2C7; border-radius:10px;">
                <label class="col-md-2 col-form-label" ><h2 class="text-center">Personal</h2></label>
        <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" :to="`/personal/edit/${this.$store.state.currentUser.id}`">Edit Personal Details</router-link>
                <router-link class="btn btn-primary col-md-2 mr-5 my-2 text-center" style="border-radius:30px" role="button" :to="`/personal/edit/changepassword/${this.$store.state.currentUser.id}`">Change Password</router-link>
            </div>
    </div>
</template>

<script>
    export default {
        name: 'admin',
        computed: {
        
        },
        methods: 
        {
             downloadUsers(){
             axios.get('/api/users/downloadUsers', {
                 headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                 },
                 responseType: 'blob'
             })
             .then((response) => {
                 var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                 var fileLink = document.createElement('a');
                 fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'UsersList.csv');
                    document.body.appendChild(fileLink);
                    fileLink.click();
             })
         },
         downloadGroups(){
             axios.get('/api/groups/downloadGroups', {
                 headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                 },
                 responseType: 'blob'
             })
             .then((response) => {
                 var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                 var fileLink = document.createElement('a');
                 fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'GroupsList.csv');
                    document.body.appendChild(fileLink);
                    fileLink.click();
             })
         },
         downloadExercises(){
             axios.get('/api/exercises/downloadExercises', {
                 headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                 },
                 responseType: 'blob'
             })
             .then((response) => {
                 var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                 var fileLink = document.createElement('a');
                 fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'ExercisesList.csv');
                    document.body.appendChild(fileLink);
                    fileLink.click();
             })
         },
         downloadGames(){
             axios.get('/api/games/downloadGames', {
                 headers: {
                     "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                 },
                 responseType: 'blob'
             })
             .then((response) => {
                 var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                 var fileLink = document.createElement('a');
                 fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'GamesList.csv');
                    document.body.appendChild(fileLink);
                    fileLink.click();
             })
         }     
        },
                
        
    }
</script>