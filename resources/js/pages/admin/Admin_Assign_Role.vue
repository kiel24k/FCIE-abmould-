<script setup>
import Header from "@/components/Admin_Header.vue"
import { Button, Message } from "primevue";
import { onMounted, ref } from "vue";
import UpdateUserRoleModal from '@/components/Admin_Update_User_Role_Modal.vue'
import axios from 'axios'

// COMPONENTS VARIABLE
const select = ref({})
const isUpdateUserRoleModal = ref(false)
const tableData = ref('')

// API VARIABLE
const userListData = ref({})

// API FUNCTIONS
const GET_USER_LIST = async () => {
    await axios({
        method: 'GET',
        url: 'api/user-list'
    }).then(response => {
        userListData.value = response.data
    })
}

// COMPONENTS FUNCTION
const asignRoleBtn = (data) => {
    tableData.value = data
    isUpdateUserRoleModal.value = true
}

const closeUpdateUserRoleModal = () => {
    isUpdateUserRoleModal.value = false
    GET_USER_LIST()
}

// HOOKS
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
                    <span>Manage your organization members</span>
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
                <table class="table table-hover">
                    <tbody>
                        <tr v-for="(data,index) in userListData.data" :key="index">
                            <td class="figure_class">
                               <figure>
                                <img :src="`/UserImage/${data.image}`" width="30" height="30" alt="User Image" />
                               </figure>
                               <div class="figure_content">
                                <b>{{ data.first_name }} {{ data.middle_name }} {{ data.last_name }}</b>
                                <span>{{ data.email }}</span>
                               </div>
                            </td>
                            <td class="table_role_select">
                                {{data.role.toUpperCase()}}
                            </td>
                            <td class="action_buttons">
                                <Button icon="pi pi-cog" severity="info" variant="text" @click="asignRoleBtn(data)" />
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
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.p-message {
    background: white;
    outline: 0;
}

section > div {
    background: white;
    box-shadow: 0 0 4px 0 gray;
    border-radius: 10px;
    outline: 0;
}

.content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.table_title {
    font-weight: bold;
    font-size: 1.2rem;
}

.table_add_member {
    /* on small devices, move add button below */
}

.figure_class {
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}

.figure_class span {
    color: gray;
    font-size: 0.85rem;
}

.figure_class img {
    border-radius: 50%;
    object-fit: cover;
}

.figure_content {
    display: grid;
}

.table .p-select {
    background: none;
    border: 0;
}

.table .p-select:hover {
    background: none;
}

#main {
    margin-top: 5rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table td {
    padding: 0.75rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #ddd;
}

.table_role_select {
    font-weight: 600;
    width: 20%;
    text-align: center;
    white-space: nowrap;
}

.action_buttons {
    width: 10%;
    text-align: center;
}

/* Responsive Styles */
@media (max-width: 768px) {
    section {
        width: 95%;
        margin: 1rem auto;
    }

    .content {
        flex-direction: column;
        align-items: flex-start;
    }

    .table_title {
        margin-bottom: 0.5rem;
    }

    .table_add_member {
        width: 100%;
        margin-top: 0.5rem;
        text-align: left;
    }

    table {
        font-size: 0.9rem;
    }

    .table_role_select,
    .action_buttons {
        width: auto;
        text-align: left;
    }

    .figure_class {
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Make table horizontally scrollable on small devices */
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}

@media (max-width: 400px) {
    .figure_class b {
        font-size: 1rem;
    }

    .figure_class span {
        font-size: 0.75rem;
    }
}
</style>
