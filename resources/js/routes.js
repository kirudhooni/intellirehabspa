import loginPage from './views/loginPage.vue';
import adminPage from './views/adminPage.vue';
import home from './views/home.vue';
import usersMain from './views/users/usersMain.vue';
import UserList from './views/users/userList.vue';
import UserAdd from './views/users/add.vue';

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
    },
    {
        path: '/admin',
        component: adminPage,  
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/users',
        component: usersMain,
        meta:{
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: UserList
            },
            {
                path: 'add',
                component: UserAdd
            },
            // {
            //     path: '/edit/:id',
            //     component: userEdit
            // }
        ]  
    }

];

