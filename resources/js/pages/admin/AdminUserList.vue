<template>
    <header>
        <Header/>
    </header>
    <div class="row m-2">
        <div class="col">
            <div class="user-list-table">
                <div class="filter">
                  <div class="category">
                    <label for="">Roles: </label>
                    <select class="form-select" v-model="selected">
                        <option value="selected" disabled>Default</option>
                        <option value="">all</option>
                        <option value="admin">admin</option>
                        <option value="member">member</option>
                        <option value="inventory-manager">inventory-manager</option>
                    </select>
                  </div>
                  <div class="search col-8">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="/public/icon/search.png" width="25px" alt="">
                        </span>
                        <input type="text" class="form-control" placeholder="Search" v-model="search">
                      </div>
                  </div>
                  <div class="create">
                    <router-link :to="{name: 'create-user'}" class="btn createBtn">
                        <span>
                            <img src="/public/icon/add_icon_plus.png" width="15px" alt="">
                            <b>Add User</b>
                        </span>
                    </router-link>
                  </div>
                </div>
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tel Number</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data,index) in userList.data" :key="index">
                            <td>
                                <img style="border-radius: 100%;border:solid 2px black;" :src="`http://127.0.0.1:8000/UserImage/${data.image}`" width="50px" height="50px" alt="">
                            </td>
                            <td>{{ data.first_name }} {{ data.last_name }}</td>
                            <td>{{ data.email }}</td>
                            <td>{{ data.tel_no }}</td>
                            <td>{{ data.role }}</td>
                            <td>{{ data.created_at }}</td>
                            <td class="text-center">
                                <span>
                                    <button class="btn btn" @click="deleteUser(data.id)">
                                        <img src="/public/icon/trash_icon.png" width="30px" alt="">
                                    </button>
                                    <router-link :to="{name: 'admin-update-user', params: {id: data.id} }" class="btn btn">
                                        <img src="/public/icon/edit_icon_pencil.png" width="30px" alt="">
                                    </router-link>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    <Bootstrap5Pagination :data="userList" @pagination-change-page="page"/>
                </table>
            </div>
        </div>
    </div>
<Loading v-if="loading"/>

</template>

<script setup>
import Sidebar from '@/components/Admin_Sidebar.vue'
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import Loading from '@/components/Loading.vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const loading = ref(false)

//user list pagination
const selected = ref('')
const userList = ref({})
const page =  (page) => {
     axios.get(`api/user-list?role=${selected.value}&page=${page}`).then(response => {
        userList.value = response.data
    })
}

watch(selected, (oldVal, newVal) => {
    page()
})

const search = ref('')
watch(search, (oldVal, newVal) => {
    axios({
        method: 'GET',
        url: `/api/user-list-search?role=${selected.value}&search=${search.value}`
    }).then(response => {
        userList.value = response.data
    })

    if(search.value === ''){
        page()
    }
})
onMounted(() => {
    page()
})
//delete user
const deleteUser = async(id) => {
     loading.value = true
    await axios.delete(`api/delete-user/${id}`).then(response => {
       page()
       loading.value = false
    })
}


onMounted(() => {
    page()
})
</script>

<style scoped>
.user-list-table {
    max-width: 75%;
    margin:auto;
}
.filter{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.category{
    display: flex;
    align-items: center;
    gap:10px;
}
th{
    background: rgb(94, 93, 93);
    color:white;
}
.createBtn{
    background: rgb(18, 230, 18);
}
.createBtn span{
    display: flex;
    justify-content: center;
    align-items: center;
    gap:5px;
}
</style>
