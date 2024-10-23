<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row">
        <div :class="isSidebarHidden ? 'col-0' : 'col-2'" :key="sidebar">
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <div :class="isSidebarHidden ? 'col-12' : 'col-10'" key="content" class="my-2">
            <div class="">
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
                        <div class="search col-5">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <img src="/public/icon/search.png" width="25px" alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="Search" v-model="search">
                            </div>
                        </div>
                        <div class="create">
                            <router-link :to="{ name: 'create-user' }" class="btn createBtn">
                                <span>
                                    <img src="/public/icon/add_icon_plus.png" width="15px" alt="">
                                    <b>Add User</b>
                                </span>
                            </router-link>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-responsive mt-3">
                        <thead>
                            <tr>
                                <th>
                                    Image
                                </th>
                                <th @click="sort('first_name')">
                                    Name
                                    <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th @click="sort('email')">
                                    Email
                                    <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th @click="sort('tel_no')">
                                    Tel Number
                                    <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th @click="sort('role')">
                                    Role
                                    <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in userList.data" :key="index">
                                <td>
                                    <img style="border-radius: 100%;border:solid 2px black;"
                                        :src="`http://127.0.0.1:8000/UserImage/${data.image}`" width="50px"
                                        height="50px" alt="">
                                </td>
                                <td>{{ data.first_name }} {{ data.last_name }}</td>
                                <td>{{ data.email }}</td>
                                <td>{{ data.tel_no }}</td>
                                <td>{{ data.role }}</td>
                                <td class="text-center">
                                    <span>
                                        <button class="btn btn" @click="deleteUser(data.id)">
                                            <img src="/public/icon/trash_icon.png" width="30px" alt="">
                                        </button>
                                        <router-link :to="{ name: 'admin-update-user', params: { id: data.id } }"
                                            class="btn btn">
                                            <img src="/public/icon/edit_icon_pencil.png" width="30px" alt="">
                                        </router-link>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="paginator text-center">
                        <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
                        <span class="paginateBtn">
                            <button class="btn btn-success" @click="prevBtn">Prev</button>
                            <button class="btn btn-dark" @click="nextBtn">Next</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Loading v-if="loading" />

</template>

<script setup>
import Sidebar from '@/components/Admin_Sidebar.vue'
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import Loading from '@/components/Loading.vue'

const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const loading = ref(false)
//user list pagination
const selected = ref('')
const userList = ref({})
const sortDefault = ref('first_name')
const sortOrder = ref('asc')
const pagination = ref({
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
})

const page = (page) => {
    axios.get(`api/user-list?role=${selected.value}&page=${page}`, {
        params: {
            order: sortOrder.value,
            sort: sortDefault.value
        }
    }).then(response => {
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            next_page_url: response.data.next_page_url,
            prev_page_url: response.data.prev_page_url
        }
        userList.value = response.data
    })
}

const sort = (sortValue) => {
    console.log(sortValue);
    if (sortDefault.value === sortValue) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortDefault.value = sortValue
        sortOrder.value = 'asc'
    }
    page()
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

    if (search.value === '') {
        page()
    }
})

//delete user
const deleteUser = async (id) => {
    loading.value = true
    await axios.delete(`api/delete-user/${id}`).then(response => {
        page()
        loading.value = false
    })
}
const prevBtn = () => {
    if (pagination.value.prev_page_url) {
        page(pagination.value.current_page - 1)

    }
}
const nextBtn = () => {
    if (pagination.value.next_page_url) {
        page(pagination.value.current_page + 1)
    }

}


onMounted(() => {
    page()
})
</script>

<style scoped>
.my-2{
    padding: 20px 40px;
}
.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}

.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;
}

.user-list-table {
    max-width: 100%;
    margin: auto
}

.filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.category {
    display: flex;
    align-items: center;
    gap: 10px;
}

th {

    color: rgb(37, 36, 36);
    cursor: pointer;
}

.createBtn {
    background: rgb(18, 230, 18);
}

.createBtn span {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.paginator {
    display: grid;
    justify-content: center;
}

.paginateBtn {
    display: flex;
    gap: 10px;
}

.paginateBtn button {
    width: 6rem;
}
</style>
