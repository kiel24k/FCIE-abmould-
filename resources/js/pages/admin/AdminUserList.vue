<template>
    <div class="row">
        <div class="col-1">
            <Sidebar/>
        </div>
        <div class="col">
            <Header/>
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
                    <input type="text" class="form-control" placeholder="Search for roles" v-model="search">
                  </div>
                  <div class="create">
                    <router-link :to="{name: 'create-user'}" class="btn btn-success">Create</router-link>
                  </div>
                </div>
                <table class="table  table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tel Number</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data,index) in userList.data" :key="index">
                            <td>
                                <img :src="`http://127.0.0.1:8000/UserImage/${data.image}`" width="100px" height="100px" alt="">
                            </td>
                            <td>{{ data.first_name }} {{ data.last_name }}</td>
                            <td>{{ data.email }}</td>
                            <td>{{ data.tel_no }}</td>
                            <td>{{ data.role }}</td>
                            <td>{{ data.created_at }}</td>
                            <td>
                                <span>
                                    <router-link :to="{name: 'admin-update-user', params: {id: data.id} }" class="btn btn-info">Update</router-link>
                                    <button class="btn btn-danger" @click="deleteUser(data.id)">Delete</button>
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
import Sidebar from '@/components/AdminSidebar.vue'
import Header from '@/components/Header.vue'
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
</style>
