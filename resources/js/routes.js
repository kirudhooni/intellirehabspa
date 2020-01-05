import loginPage from './views/loginPage.vue';
import adminPage from './views/adminPage.vue';
import home from './views/home.vue';
import usersMain from './views/users/usersMain.vue';
import UserList from './views/users/userList.vue';
import UserAdd from './views/users/add.vue';
import UserEdit from './views/users/edit.vue';

import groupsMain from './views/groups/groupsMain.vue';
import GroupList from './views/groups/groupList.vue';
import GroupAdd from './views/groups/add.vue';
import GroupEdit from './views/groups/edit.vue';

import PersonalEdit from './views/personal/edit.vue';
import PersonalChangePassword from './views/personal/changePassword.vue';
import GroupManage from './views/groups/manage.vue';

import exercisesMain from './views/exercises/exercisesMain.vue';
import ExerciseList from './views/exercises/exerciseList.vue'; 
import ExerciseAdd from './views/exercises/add.vue';
import ExerciseEdit from './views/exercises/edit.vue';

import gamesMain from './views/games/gamesMain.vue';
import GameList from './views/games/gameList.vue'; 
import GameAdd from './views/games/add.vue';
import GameEdit from './views/games/edit.vue';
import GameApk from './views/games/uploadApk.vue';

import patientsMain from './views/patients/patientsMain.vue';
import PatientList from './views/patients/patientList.vue'; 
import PatientAdd from './views/patients/add.vue';
import PatientEdit from './views/patients/edit.vue';

import targetsMain from './views/targets/targetsMain.vue';
import TargetList from './views/targets/targetList.vue'; 
import TargetAdd from './views/targets/add.vue';
import TargetEdit from './views/targets/edit.vue';

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
            {
                path: 'edit/:id',
                component: UserEdit
            }
        ]  
    },
    {
        path: '/groups',
        component: groupsMain,
        meta:{
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: GroupList
            },
            {
                path: 'add',
                component: GroupAdd
            },
            {
                path: 'edit/:id',
                component: GroupEdit
            },
            {
                path: 'manage',
                component: GroupManage
            }
        ]  
    },
    {
        path: '/exercises',
        component: exercisesMain,
        meta:{
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: ExerciseList
            },
            {
                path: 'add',
                component: ExerciseAdd
            },
            {
                path: 'edit/:id?',
                component: ExerciseEdit
            }
        ]  
    },
    {
        path: '/targets',
        component: targetsMain,
        meta:{
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: TargetList
            },
            {
                path: 'add',
                component: TargetAdd
            },
            {
                path: 'edit/:id',
                component: TargetEdit
            },
            
        ]  
    },
    {
        path: '/games',
        component: gamesMain,
        meta:{
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: GameList
            },
            {
                path: 'add',
                component: GameAdd
            },
            {
                path: 'edit/:id',
                component: GameEdit
            },
            {
                path: 'uploadApk',
                component: GameApk
            }
        ]  
    },
    {
        path: '/patients',
        component: patientsMain,
        meta:{
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: PatientList
            },
            {
                path: 'add',
                component: PatientAdd
            },
            {
                path: 'edit/:id',
                component: PatientEdit
            },
            
        ]  
    },
    {
        path: '/personal/edit/:id',
        component: PersonalEdit,
        meta:{
            requiresAuth: true
        },
    },
    {
        path: '/personal/edit/changepassword/:id',
        component: PersonalChangePassword,
        meta:{
            requiresAuth: true
        },
    },

];

