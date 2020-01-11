<template>
    
  <form-wizard @on-complete="onComplete" 
                        @on-error="handleErrorMessage"
                        shape="circle"
                        color="#3498db"
                        error-color="#ff4949"
                        title=""
                        subtitle="">
                        
      <tab-content title="Personal details" icon="ti-user" >
            <!-- :before-change="validatePersonalInfo" -->
          <el-form  :rules="rules"  :model="form" ref="ruleForm">
                

            
            
                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="First Name"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="firstname">
                            <el-input  v-model="form.firstname" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>    

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Last Name"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="lastname">
                            <el-input  v-model="form.lastname" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>   

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Username/MRN"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="username">
                            <el-input  v-model="form.username" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>   

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Phone"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="phone">
                            <el-input type="number" v-model="form.phone" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>   

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Address"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="address">
                            <el-input type="textarea" :rows="5" v-model="form.address" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>   

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Email"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="email">
                            <el-input type="email" v-model="form.email" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>  
                    
             <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Note"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item >
                            <el-input type="textarea" :rows="5" v-model="form.note" ></el-input>
                        </el-form-item >
                    </el-col>
                </el-row>  

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Doctor"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="doctor">
                             <el-select v-model="form.doctor" placeholder="Select Doctor" style="width:100%;">
                                <el-option
                                    v-if="user.level == 'doctor'"
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.lastname"
                                    
                                    
                                 >
                                Dr.{{user.lastname}}({{user.id}})
                                </el-option>
                            </el-select>
                        </el-form-item >
                    </el-col>
                </el-row>  

                <el-row class="border pt-4 px-2" type="flex"> 
                    <el-col :md="4">
                   <el-form-item label="Therapist"></el-form-item>

                    </el-col>
                    <el-col :md="20">
                        <el-form-item prop="therapist">
                             <el-select v-model="form.therapist" placeholder="Select Therapist" style="width:100%;">
                                <el-option
                                    v-if="user.level == 'therapist'"
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.lastname"
                                    
                                    
                                 >
                                {{user.lastname}}({{user.id}})
                                </el-option>
                            </el-select>
                        </el-form-item >
                    </el-col>
                </el-row>  
                   
            </el-form>    

      </tab-content>
      <tab-content title="Select Groups"
                   icon="ti-settings"
                   :before-change="validateGroup">
                   
                        <dualListBox :list1 ="list1Groups" :list2="groups" firstTitle="Groups Assigned" secondTitle="Groups Not Assigned" @inGroup="updateMasterList" @notInGroup="updateMasterList2" ></dualListBox>
                   
      </tab-content>
      <tab-content title="Select Exercises"
                   icon="ti-check"
                   :before-change="validateExercise">
       <dualListBox :list1 ="list1Exercises" :list2="exercises" firstTitle="Exercises Assigned" secondTitle="Exercises Not Assigned" @inGroup="updateMasterListExercises" @notInGroup="updateMasterList2Exercises"></dualListBox>
 
      </tab-content>

      <tab-content title="Baseline Active Roms"
                   icon="ti-check">
            <div class="row border py-4">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width= "25%">Joint</th>
                        <th width= "25%">ROM</th>
                        <th width= "55%" >ROM Value</th>
                    </tr>
                    
                    <template v-for="(joint,key1) in form.jointData" >  
                    <tr>
                        <td ><strong>{{joint.description}}</strong></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr v-for="(rom,key2) in joint.roms">
                        <td></td>
                        <td  >{{rom.name}}</td>
                        <td><input class="form-control col-md-12" type="text" v-model="form.jointData[key1].roms[key2].value" required></td>
                    </tr>
                </template>
                </table>
            </div>
      </tab-content>

      <tab-content title="Target Roms"
                   icon="ti-check">
            <div class="row border py-4">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width= "25%">Joint</th>
                        <th width= "25%">ROM</th>
                        <th width= "55%" >ROM Value</th>
                    </tr>
                    <tr>
                        <td ><strong>Master Target</strong>
                            <select class="form-control">
                                <option value="">Select Target</option>
                                <option v-for="target in preTargets ">{{target}}</option>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <template v-for="(joint,key1) in form.targetJointData" >  
                    <tr>
                        <td ><strong>{{joint.description}}</strong></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr v-for="(rom,key2) in joint.roms">
                        <td v-if="key2=='0'">
                            <strong>Preset Target</strong>
                            <select class="form-control">
                                <option value="">Select Target</option>
                                <option v-for="target in preTargets ">{{target}}</option>
                            </select>
                            
                        </td>
                        <td v-if="key2 > '0'"></td>
                        <td  >{{rom.name}}</td>
                        <td><input class="form-control col-md-12" type="text" v-model="form.targetJointData[key1].roms[key2].value" required></td>
                    </tr>
                </template>
                </table>
            </div>
      </tab-content>
      <span class="error mt-3">{{errorMsg}}</span>
  </form-wizard>


</template>

<script>

import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import dualListBox from '../components/dualListBox.vue';

export default {
    components: {
        FormWizard,
        TabContent,
        dualListBox
        
    },
    data(){
        return{
            form: {
                    firstname :'',
                    lastname :'',
                    username : '',
                    phone : '',
                    address:'',
                    email : '',
                    doctor : '',
                    therapist : '',
                    note :'',
                    assignedGroups:[],
                    unAssignedGroups:[],
                    assignedExercises:[],
                    unAssignedExercises:[],
                    jointData:[],
                    targetJointData:[]
                },
            users:[],
            groups:[],
            preTargets:[],
            list1Groups:[],
            exercises:[],
            list1Exercises:[],
            errorMsg:'',
            rules: {
                    firstname: [{
                        required: true,
                        message: 'Please input firstname',
                        trigger: 'blur'
                    }], 
                    lastname: [{
                        required: true,
                        message: 'Please input lastname',
                        trigger: 'blur'
                    }],
                    username: [{
                        required: true,
                        message: 'Please input username',
                        trigger: 'blur'
                    }],
                    phone: [{
                        required: true,
                        message: 'Please input a phone number',
                        trigger: 'blur'
                    }],
                    email: [{
                        required: true,
                        message: 'Please input a valid email',
                        trigger: 'blur'
                    }],
                    address: [{
                        required: true,
                        message: 'Please input a valid address',
                        trigger: 'blur'
                    }],
                    doctor: [{
                        required: true,
                        message: 'Please select a Doctor',
                        trigger: 'blur'
                    }],
                    therapist: [{
                        required: true,
                        message: 'Please select a Therapist',
                        trigger: 'blur'
                    }],
                }
                
            }
    },
    mounted(){
         axios.get('/api/users', {
                headers: {
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                this.users = response.data.users
            })  

            if( !this.groups.length){
          axios.get('/api/groups', {
                headers: {
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                for (var i = 0; i < response.data.groups.length; i++) {   
                  this.groups.push(response.data.groups[i].name);
                  
                  }
                
            })   
            }

            if( !this.exercises.length){
          axios.get('/api/exercises', {
                headers: {
                    "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                }
            })
            .then((response) => {
                for (var i = 0; i < response.data.exercises.length; i++) {   
                  this.exercises.push(response.data.exercises[i].name);
                  
                  }
                
            })   
            }

            axios.get('/api/joints/getRoms',{
                    headers:{
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.form.jointData = response.data.joints
                    
                })
            
            axios.get('/api/targets',{
                    headers:{
                        "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                    }
                })
                .then((response) => {
                    for (var i = 0; i < response.data.targets.length; i++) {   
                  this.preTargets.push(response.data.targets[i].name);
                  
                  }
                    
                    
                })
             
        
    },
    computed:{
        
    },
    methods:{
        onComplete(){
            
        },
        validatePersonalInfo(){

            
           return new Promise((resolve, reject) => {
             this.$refs.ruleForm.validate((valid) => {
               resolve(valid);
             });
           })

           
        },
        validateGroup(){
            return new Promise((resolve,reject) => {
                if(!this.form.assignedGroups.length){
                    reject('Please assign atleast one group!');
                }
                else resolve(true);
            })
        },
        validateExercise(){
            if(this.form.assignedExercises.length){
                let formData = new FormData();
                formData.append('exerciseNames', JSON.stringify(this.form.assignedExercises));
                axios.post(`/api/joints/getExerciseRoms`, formData, {
                        headers:{
                            "Authorization": `Bearer ${this.$store.state.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.form.targetJointData = response.data.joints
                        
                    })
            }
            return new Promise((resolve,reject) => {
                if(!this.form.assignedExercises.length){
                    reject('Please assign atleast one Exercise!');
                }
                else resolve(true);
            })
        },
        updateMasterList(value){
            this.form.assignedGroups = value;
        },
        updateMasterList2(value){
            this.form.unAssignedGroups = value;
        },

        //exercises
        updateMasterListExercises(value){
            this.form.assignedExercises = value;
        },
        updateMasterList2Exercises(value){
            this.form.unAssignedExercises = value;
        },
        resetForm(formName) {
        this.$refs[formName].resetFields();
      },
      handleErrorMessage(errorMsg){
          this.errorMsg = errorMsg
      }
    }
}
</script>

<style>
    .error{
        color:#e74c3c;
        font-size:20px;
        display:flex;
        justify-content:center;
    }
</style>