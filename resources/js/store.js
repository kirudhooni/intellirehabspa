import { getLocalUser } from "./helpers/auth";
import Axios from "axios";

const user = getLocalUser();

export default {
    state: {
        welcomeMessage: 'Welcome to IntelliRehab',
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        userAdded: false,
        users: [],


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
        }
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
        }
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
        }
    }


};