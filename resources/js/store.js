import { getLocalUser } from "./helpers/auth";
import axios from "axios";

const user = getLocalUser();

export default {
    state: {
        welcomeMessage: 'Welcome to IntelliRehab',
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        userAdded: false,
        userUpdated: false,
        users: [],
        groupAdded: false,
        groupUpdated: false,
        groups: []


    },
    getters: {
        welcome(state){
            return state.welcomeMessage;
        },

        isLoading(state){
            return state.loading;
        },
        isLoggedIn(state){
            return state.isLoggedIn;
        },
        currentUser(state){
            return state.currentUser;
        },
        authError(state){
            return state.auth_error;
        },
        users(state) {
            return state.users;
        },
        userAdded(state){
            return state.userAdded;
        },
        userUpdated(state){
            return state.userUpdated;
        },
        groups(state){
            return state.groups;
        },
        groupAdded(state){
            return state.groupAdded;
        },
        groupUpdated(state){
            return state.groupUpdated;
        },
    },
    mutations: {
        login(state){
            state.loading = true;
            state.auth_error = null;
        },

        loginSuccess(state, payload){
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({} , payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },

        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
            console.log(payload);
        },
        logout(state){
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        updateUsers(state, payload){
            state.users = payload;
        },
        updateUserAddedTrue(state){
            state.userAdded = true;
        },
        updateUserAddedFalse(state){
            state.userAdded = false;
        },
        updateUserUpdatedTrue(state){
            state.userUpdated = true;
        },
        updateUserUpdatedFalse(state){
            state.userUpdated = false;
        },
        updateGroups(state,payload){
            state.groups = payload;
        },
        updateGroupAddedTrue(state){
            state.groupAdded = true;
        },
        updateGroupAddedFalse(state){
            state.groupAdded = false;
        },
        updateGroupUpdatedTrue(state){
            state.groupUpdated = true;
        },
        updateGroupUpdatedFalse(state){
            state.groupUpdated = false;
        },
    },
    actions: {
        login(context){
            context.commit("login");
        },

        getUsers(context){
            axios.get('api/users', {
                headers: {
                    "Authorization": `Bearer ${context.state.currentUser.token}`
                }
            })
            .then((response) => {
                context.commit('updateUsers',response.data.users);
            })  
        },

        getGroups(context){
            axios.get('http://localhost:8000/api/groups', {
                headers: {
                    "Authorization": `Bearer ${context.state.currentUser.token}`
                }
            })
            .then((response) => {
                context.commit('updateGroups',response.data.groups);
            })  
        }
    }


};