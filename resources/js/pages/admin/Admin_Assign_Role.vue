<script setup>
import Header from "@/components/Admin_Header.vue"
import { Button, Message, Select } from "primevue";
import { onMounted, ref, watch } from "vue";
import UpdateUserRoleModal from '@/components/Admin_Update_User_Role_Modal.vue'



//COMPONENTS VARIABLE
const select = ref({})
const isUpdateUserRoleModal = ref(false)
const tableData = ref('')

//API VARIABLE
const userListData = ref({})
//API FUNCTIONS
const GET_USER_LIST = async () => {
    await axios({
        method: 'GET',
        url: 'api/user-list'
    }).then(response => {
        userListData.value = response.data
    })
}

//COMPONENTS FUNCTION
const asignRoleBtn = (data) => {
    tableData.value = data
    isUpdateUserRoleModal.value = true
}

const closeUpdateUserRoleModal = () => {
    isUpdateUserRoleModal.value = false
    GET_USER_LIST()
}






//HOOKS


onMounted(() => {
   
    
    GET_USER_LIST()
})

</script>

<template>
    <header>
        <UpdateUserRoleModal v-if="isUpdateUserRoleModal" @closeUpdateUserRoleModal="closeUpdateUserRoleModal" :tableData="tableData"/>
        <Header />
    </header>

    <section id="main">
        <div class="row">
            <div class="col title">
                <Message severity="white">
                    <h1>Team Members</h1>
                    <span>Manage you organization member</span>
                </Message>
            </div>
        </div>
        
        <div class="row mt-3 ">
            <div class="col">
                <div class="content p-4">
                    <div class="table_title">
                        <b>Team</b>
                    </div>
                    <div class="table_add_member">
                       <router-link :to="{name: 'create-user'}">
                        <Button label="Add member" variant="text" icon="pi pi-plus" severity="contrast"/>
                       </router-link>
                    </div>
                </div>
                <hr>
                <table class="table  table-hover">
                    <tbody>
                        <tr v-for="(data,index) in userListData.data">
                            <td class="figure_class">
                               <figure>
                                <img :src="`/UserImage/${data.image}`" width="30px" height="30px" alt="">
                               </figure>
                               <div class="figure_content">
                                <b>{{ data.first_name }} {{ data.middle_name }} {{ data.last_name }}</b>
                                <span>kiel@gmail.com</span>
                               </div>
                            </td>
                            <td class="table_role_select">
                                {{data.role.toUpperCase()}}
                            </td>
                            <td>
                                <Button icon="pi pi-cog" severity="info" variant="text" @click="asignRoleBtn(data)"/>
                                <!-- <Button icon="pi pi-trash" severity="danger" rounded  variant="text" /> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<style scoped>
section {
    width: 50%;
    margin: auto;
}

.p-message {
    background: white;
    outline: 0px;
}
section > div{

    background: white;
    box-shadow: 0px 0px 4px 0px gray;
    outline: 0px;
    border-radius: 10px;
    

}
.content{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.figure_class{
  
    display: flex;
    align-items: center;
    align-content: center;
    gap:10px;
}
.figure_class span{
    color:gray;
}
.figure_class img{
    border-radius: 100%;
}
.figure_content{
    display: grid;
}
.table .p-select{
    background: none;
   border:0px;
}
.table .p-select:hover{
    background: none;
}


#main{
    margin-top: 5rem;
}
</style>