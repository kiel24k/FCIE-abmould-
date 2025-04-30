<script setup>
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import Loading from '@/components/Loading.vue'
import Button from 'primevue/button';
import html2pdf from 'html2pdf.js';
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';
import { InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import ViewUserModal from '@/components/Admin_View_User_Modal.vue'
import PrintUserList from '@/components/Print_User_List.vue'


const router = useRouter()
const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const printContent = ref()
const loading = ref(false)


//COMPONENTS VARIABLE
const category = ref("")
const search = ref("")
const sortName = ref("")
const sortOrder = ref("ASC")
const isViewUserModal = ref(false)
const viewUserModalId = ref(null)
const isPrintModal = ref(false)
const tableData = ref({})

//API VARIABLE
const userListCategoryData = ref({})
const userListData = ref({})
const pagination = ref({
    current_page: null,
    last_page: null
})

//API FUNCTION
const GET_USER_LIST_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/user-list-category'
    }).then(response => {
        userListCategoryData.value = response.data
    })
}

const GET_USER_LIST_API = async (page = 1) => {
    await axios({
        method: 'GET',
        url: `api/user-list?page=${page}`,
        params: {
            category: category.value,
            search: search.value,
            sortName: sortName.value,
            sortOrder: sortOrder.value
        }
    }).then(response => {
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page
        }
        userListData.value = response.data
    })
}

const DELETE_USER_API = async (id) => {
    await axios({
        method: 'DELETE',
        url: 'api/delete-user',
        params: {
            id: id
        }
    })
}

//COMPONENTS FUNCTION

const print = () => {
    isPrintModal.value = true
tableData.value = userListData.value.data
}

const closeUserListModal = () => {
    isPrintModal.value = false
}

const sort = (data) => {
    sortName.value = data
    if (sortOrder.value === 'ASC') {
        sortOrder.value = 'DESC'
    } else {
        sortOrder.value = 'ASC'
    }
    GET_USER_LIST_API()
}

const prev = () => {
    if (pagination.value.last_page >= pagination.value.current_page) {
        GET_USER_LIST_API(pagination.value.last_page - 1)
    }
}

const next = () => {
    if (pagination.value.current_page < pagination.value.last_page) {
        GET_USER_LIST_API(pagination.value.current_page + 1)
    }
}

const update = (id) => {
    router.push(`/admin-update-user/${id}`)

}

const view = (id) => {
    isViewUserModal.value = true
    viewUserModalId.value = id
}

const closeViewUserModal = () => {
    isViewUserModal.value = false
    GET_USER_LIST_API()
}

const deleteBtn = (id) => {
    Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {
    DELETE_USER_API(id)
    Swal.fire({
      title: "Deleted!",
      text: "Data has been deleted.",
      icon: "success"
    });
  }
  GET_USER_LIST_API()
});

}
//HOOKS
watch(category, (oldVaL, newVal) => {
    GET_USER_LIST_API()
})

watch(search, (oldVal, newVal) => {
    GET_USER_LIST_API()
})

onMounted(() => {
    GET_USER_LIST_CATEGORY_API()
    GET_USER_LIST_API()

})

</script>

<template>
    <PrintUserList v-if="isPrintModal" :tableData="tableData" @closeUserListModal="closeUserListModal"/>
    <header>
        <ViewUserModal v-if="isViewUserModal" :viewUserModalId="viewUserModalId" @closeViewUserModal="closeViewUserModal"/>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row justify-content-center mt-5">
        <div class="col-9 mt-4">
            <div class="user-list-table">
                <div class="row">
                    <div class="col title">
                        <Message severity="info">
                            <h2>User List</h2>
                        </Message>
                    </div>
                </div>
                <div class="row bg-white p-2">
                    <div class="col table_filter_action">
                        <div class="list_filter">
                            <Select placeholder="Select role" :options="userListCategoryData" optionLabel="role"
                                v-model="category" />
                            <InputGroup>
                                <InputText placeholder="Search..." v-model="search" />
                                <InputGroupAddon>
                                    <Button icon="pi pi-search" severity="secondary" variant="text" @click="toggle" />
                                </InputGroupAddon>
                            </InputGroup>
                        </div>
                        <div class="list_action">
                            <router-link :to="{name: 'create-user'}">
                                <Button label="Add user" icon="pi pi-plus" severity="info" />
                            </router-link>
                            <Button label="Export" icon="pi pi-file-pdf" severity="danger" raised @click="print()" />
                        </div>
                    </div>

                    <figure class="table-main">
                        <table class="table table-hover table-bordered table-responsive mt-3" ref="printContent">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Profile</th>
                                    <th @click="sort('first_name')">
                                        First name
                                        <i class="pi pi-sort-amount-down-alt" v-if="sortOrder === 'ASC'"></i>
                                        <i class="pi pi-sort-amount-up" v-else></i>
                                    </th>
                                    <th @click="sort('middle_name')">
                                        Middle name
                                        <i class="pi pi-sort-amount-down-alt" v-if="sortOrder === 'ASC'"></i>
                                        <i class="pi pi-sort-amount-up" v-else></i>
                                    </th>
                                    <th @click="sort('last_name')">
                                        Last name
                                        <i class="pi pi-sort-amount-down-alt" v-if="sortOrder === 'ASC'"></i>
                                        <i class="pi pi-sort-amount-up" v-else></i>
                                    </th>
                                    <th @click="sort('email')">
                                        Email
                                        <i class="pi pi-sort-amount-down-alt" v-if="sortOrder === 'ASC'"></i>
                                        <i class="pi pi-sort-amount-up" v-else></i>
                                    </th>
                                    <th @click="sort('tel_no')">
                                        Tel Number
                                        <i class="pi pi-sort-amount-down-alt" v-if="sortOrder === 'ASC'"></i>
                                        <i class="pi pi-sort-amount-up" v-else></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in userListData.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <img :src="`/UserImage/${data.image}`" width="50px" height="50px" alt="">
                                    </td>
                                    <td>{{ data.first_name }}</td>
                                    <td>{{ data.middle_name }}</td>
                                    <td>{{ data.last_name }}</td>
                                    <td>{{ data.email }}</td>
                                    <td>{{ data.tel_no }}</td>
                                    <td>
                                        <div class="table_action">
                                            <Button icon="pi pi-pencil" severity="info" raised @click="update(data.id)" />
                                            <Button icon="pi pi-eye" severity="success" raised @click="view(data.id)" />
                                            <Button icon="pi pi-trash" severity="danger" raised @click="deleteBtn(data.id)"/>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="paginate_class">
                            <Button label="Prev" icon="pi pi-chevron-left" variant="text" severity="contrast"
                                @click="prev()" />
                            <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
                            <Button label="Next" icon="pi pi-chevron-right" iconPos="right" variant="text"
                                severity="contrast" @click="next()" />
                        </div>
                    </figure>
                </div>
            </div>
        </div>

    </div>
    <Loading v-if="loading" />
</template>



<style scoped>
.user-list-table {
    display: grid;
    gap: 20px;
}

.table_action {
    display: flex;
    gap: 5px;
}

.table_filter_action {
    display: flex;
    justify-content: space-between;
}

.list_filter {
    display: flex;
    gap: 5px;

}

.list_action {
    display: flex;
    gap: 10px;

}

.paginate_class {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>


<!-- <style scoped>
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
.table{
    box-shadow: 0px 0px 5px 0px gray;
  border-radius: 10px;
}
.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;
    
}

.user-list-table {
    max-width: 100%;
    margin: auto;
    
  
   
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
.pagin
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
</style> -->
