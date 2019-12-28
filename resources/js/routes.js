import loginPage from './views/loginPage.vue';
import home from './views/home.vue';
export const routes =[
    {
        path: '/',
        component: home,
        meta:{
            requiresAuth: true
        }
    },

    {
        path: '/login',
        component: loginPage,
        
    }

];

