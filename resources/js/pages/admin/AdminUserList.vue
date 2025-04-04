<script setup>
import Sidebar from '@/components/Admin_Sidebar.vue'
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import Loading from '@/components/Loading.vue'
import Button from 'primevue/button';
import html2pdf from 'html2pdf.js';
import Swal from 'sweetalert2';
import { InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';

const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const printContent = ref()
const loading = ref(false)



















//COMPONENTS VARIABLE
const category = ref("")
const search = ref("")

//API VARIABLE
const userListCategoryData = ref({})
const userListData = ref({})
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
            search: search.value
        }
    }).then(response => {
        userListData.value = response.data

    })
}

//COMPONENTS FUNCTION
const generatePdf = () => {
    const elem = printContent.value
    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();
};
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
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row justify-content-center mt-5">
        <div class="col-9">
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
                            <Button label="Add user" icon="pi pi-plus" severity="info" />
                            <Button label="print" icon="pi pi-file-pdf" severity="danger" raised />
                        </div>
                    </div>

                    <figure class="table-main">
                        <table class="table table-hover table-bordered table-responsive mt-3" ref="printContent">
                            <thead>
                                <tr>
                                    <th @click="sort('first_name')">
                                        Name
                                        <i class="pi pi-sort-amount-down-alt"></i>
                                        <i class="pi pi-sort-amount-up"></i>
                                    </th>
                                    <th @click="sort('email')">
                                        Email
                                        <i class="pi pi-sort-amount-down-alt"></i>
                                        <i class="pi pi-sort-amount-up"></i>
                                    </th>
                                    <th @click="sort('tel_no')">
                                        Tel Number
                                        <i class="pi pi-sort-amount-down-alt"></i>
                                        <i class="pi pi-sort-amount-up"></i>
                                    </th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in userListData.data" :key="index">
                                    <td>
                                        <img :src="`/UserImage/${data.image}`" width="50px" height="50px" alt="">
                                        {{ data.first_name }} {{ data.last_name }}
                                    </td>
                                    <td>{{ data.email }}</td>
                                    <td>{{ data.tel_no }}</td>
                                    <td class="text-center">
                                        <span class="action">
                                            <router-link class="btnUpdate"
                                                :to="{ name: 'admin-update-user', params: { id: data.id } }">
                                                <Button icon="pi pi-pen-to-square" severity="success" rounded raised />
                                            </router-link>
                                            <Button @click="deleteUser(data.id)" icon="pi pi-trash" severity="danger"
                                                rounded raised />
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="paginate_class">
                            <Button label="Prev" icon="pi pi-chevron-left" variant="text" severity="contrast" />
                            <span>1 of 2</span>
                            <Button label="Next" icon="pi pi-chevron-right" iconPos="right" variant="text"
                                severity="contrast" />
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

.table-action {
    display: flex;
    justify-content: end;
    gap: 15px;
    align-items: center;
    align-content: center;
}

.search input:focus {
    outline: none;
}

.search {
    display: flex;
}

.table {
    padding: 10px;
    border: solid 1px rgb(221, 219, 219);
    background: white;
    border-radius: 10px;

}

.table-category {
    display: flex;
    align-items: center;
}

.table-category select:focus {
    outline: none;
    box-shadow: none;


}

.table table th {
    background: rgb(206, 206, 206);
}

.table table .action {
    display: flex;
    gap: 10px;
}

figure {
    background-color: #fff;
}

.btnPaginate {
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
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
