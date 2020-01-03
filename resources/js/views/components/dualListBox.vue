<template>
    <div>
        <div class="row" style="padding-top:30px; padding-bottom:10px;">
            <h3 class="col-md-4 text-center" for="inGroup">{{firstTitle}}</h3>
            <div class="col-md-2"></div>
            <h3 class="col-md-4 text-center" for="notInGroup">{{secondTitle}}</h3>
        </div>
        <div class="row">
            
            <div class="col-md-4">
                <select size="20" class="form-control" v-model="list1Selected" name="inGroup" id="list1" multiple>
                    <option v-for="item1 in list1" >{{ item1 }}</option>
                </select>
            </div>
            <div class="col-md-2" style="margin-top:100px;">
                <button class="btn btn-danger btn-block mb-2" @click="oneToRight">&raquo;</button>
                <button class="btn btn-success btn-block mb-2" @click="oneToLeft">&laquo;</button>
            </div>
            
            <div class="col-md-4">
                <select size="20" class="form-control" v-model="list2Selected" name="notInGroup" id="list2" multiple>
                    <option v-for="item2 in list2" >{{ item2 }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'dualListBox',

        props:[
            'firstTitle',
            'secondTitle',
            'list1',
            'list2'

        ],
        mounted() {
            console.log('DualListBox mounted.')
            this.$emit('notInGroup',this.list2);
            this.$emit('inGroup',this.list1);
        },

        data() {
            return {
                list1Selected:[],
                list2Selected:[],
                newUsers: '',
                // list1: [],
                // list2: [],
                allUsers: [],
            }
        },
        methods: {
            oneToRight() {
                 
                //var select = [];   
                var i; 
                // $("#list1 :selected").each(function(){
                //     select.push($(this).val()); 
                // });
                if (this.list1Selected != ""){
                    for (i = 0; i < this.list1Selected.length; i++) {
                    this.list2.push(this.list1Selected[i])
                    var del = this.list1.indexOf(this.list1Selected[i])
                    this.list1.splice(del,1)
                    }
                    
                }
                this.$emit('notInGroup',this.list2);
                this.$emit('inGroup',this.list1);
            },
            oneToLeft() {
                // var select = [];   
                var i; 
                // $("#list2 :selected").each(function(){
                //     select.push($(this).val()); 
                // });
                if (this.list2Selected != ""){
                    for (i = 0; i < this.list2Selected.length; i++) {
                    this.list1.push(this.list2Selected[i])
                    var del = this.list2.indexOf(this.list2Selected[i])
                    this.list2.splice(del,1)
                    }
                    
                }

                this.$emit('notInGroup',this.list2);
                this.$emit('inGroup',this.list1);
            },
        },

        created(){
            // this.list1 = this.listOne;
            // this.list2 = this.listTwo;
        },
    }
</script>
