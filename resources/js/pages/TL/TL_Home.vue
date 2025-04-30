<script setup>
import Header from '@/components/TL_Header.vue'
import Sidebar from '@/components/Admin_Sidebar.vue';
import { onMounted, ref, watch } from 'vue';
import AdminViewModal from '@/components/Admin_View_Modal.vue'
import Loading from '@/components/Loading.vue'
import html2pdf from 'html2pdf.js';
import PrintItemList from '@/components/Print_Item_List.vue'

import { Button, InputText, InputGroup, InputGroupAddon, Message, Select } from 'primevue';
import Swal from 'sweetalert2';

const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};
const userInformation = ref()
const user = (val) => {
    userInformation.value = val
}

const printContent = ref(null)
const loading = ref(false)
const viewModal = ref(false)
const viewModalId = ref(null)
const print = (data) => {
    isPrintModal.value = true
    tableData.value = itemListData.value.data
};


const closeItemListModal = () => {
    isPrintModal.value = false
}

//COMPONENTS VARIABLES
const sortName = ref('')
const sortBy = ref('ASC')
const category = ref("")
const search = ref("")
const pagination = ref({
    current_page: null,
    last_page: null
})
const isPrintModal = ref(false)
const tableData = ref({})



//API VARIABLES
const itemListCategory = ref({})
const itemListData = ref({})

//API FUNCTIONS
const GET_ITEM_LIST_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/item-list-category'
    }).then(response => {
        itemListCategory.value = response.data
    })
}

const GET_ITEM_LIST_API = async (page = 1) => {
    await axios({
        method: 'GET',
        url: `api/get-item-list?page=${page}`,
        params: {
            sortName: sortName.value,
            sortBy: sortBy.value,
            category: category.value,
            search: search.value
        }
    }).then(response => {
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page
        }
        itemListData.value = response.data
    })
}

const deleteItem = (id) => {
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
            axios({
                method: 'DELETE',
                url: `api/delete-item/${id}`,
                params: {
                    userId: userInformation.value.id
                }
            }).then(response => {
                console.log(response);
                if (response.status == 200) {
                    GET_ITEM_LIST_API()
                }
            })
            Swal.fire({
                title: "Deleted!",
                text: "Your item has been deleted.",
                icon: "success"
            });
        }
    })




}
// COMPONENTS FUNCTION
const view = (id) => {
    viewModal.value = true
    viewModalId.value = id

}
const sort = (data) => {
    sortName.value = data
    if (sortBy.value === "ASC") {
        sortBy.value = 'DESC'
    } else {
        sortBy.value = 'ASC'
    }
    GET_ITEM_LIST_API()
}

const clear = () => {
    search.value = ""
    category.value = ""
}

const prev = () => {
if(pagination.value.last_page >= pagination.value.current_page){
    GET_ITEM_LIST_API(pagination.value.last_page - 1)
}
}
const next = () => {
    if(pagination.value.current_page < pagination.value.last_page){
        GET_ITEM_LIST_API(pagination.value.current_page + 1)
    }
}


//HOOKS

watch(category, (oldVal, newVal) => {
    GET_ITEM_LIST_API()
})

watch(search, (oldVal, newVal) => {
    GET_ITEM_LIST_API()
})

onMounted(() => {
    GET_ITEM_LIST_CATEGORY_API()
    GET_ITEM_LIST_API()

})

</script>

<template>
    <PrintItemList v-if="isPrintModal" :tableData="tableData" @closeItemListModal="closeItemListModal"/>
    <header>
        <Header @toggle-sidebar="toggleSidebar" @user="user" />
    </header>
    <div class="row justify-content-center mt-5">
        <div class="col-9">
            <div class="admin-inventory-list">
                <div class="row">
                    <div class="col title mt-4">
                        <Message icon="pi pi-list">
                            <h2>ITEM LIST</h2>
                        </Message>
                    </div>
                </div>
            
                <div class="row">
                    
                    <div class="col bg-white">
                        <div class="row p-3">
                            <div class="col table-category">
                                <Select placeholder="Select Date" :options="itemListCategory" optionLabel="release_date"
                                    v-model="category" />
                                <InputGroup>
                                    <InputText placeholder="Search Item" v-model="search" />
                                    <InputGroupAddon>
                                        <Button icon="pi pi-search" severity="secondary" variant="text" disabled />
                                    </InputGroupAddon>
                                    <Button label="clear" severity="secondary" raised @click="clear"
                                        v-if="search || category" />
                                </InputGroup>
                            </div>
                            <div class="col table-action">
                                <Button icon="pi pi-file-pdf" severity="danger" label="Export" raised
                                    @click="print()"></Button>
                                <router-link :to="{ name: 'admin-new-item' }">
                                    <Button icon="pi pi-plus-circle" severity="info" label="New" raised />
                                </router-link>
                            </div>
                        </div>
                        <figure class="table-main">
                            <table class="table table-bordered  table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="" @click="sort('category')">
                                            <div class="head-title">
                                                Category
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('item_code')">
                                            <div class="head-title">
                                                item_code
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('brand')">
                                            <div class="head-title">
                                                Brand
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('supplier_name')">
                                            <div class="head-title">
                                                Supplier Name
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('unit_cost')">
                                            <div class="head-title">
                                                Unit_Cost
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('quantity')">
                                            <div class="head-title">
                                                Quantity
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('treshold')">
                                            <div class="head-title">
                                                Treshold
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th @click="sort('description')">
                                            <div class="head-title">
                                                Description
                                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                                                <i class="pi pi-sort-amount-up" v-else></i>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="head-title">
                                                Action
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in itemListData.data" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ data.category }}</td>
                                        <td> <i class="pi pi-barcode"></i> {{ data.item_code }}</td>
                                        <td>{{ data.brand }}</td>
                                        <td>{{ data.supplier_name }}</td>
                                        <td class="text-success">{{ data.unit_cost }}</td>
                                        <td>x{{ data.quantity }}</td>
                                        <td>x{{ data.treshold }}</td>
                                        <td>{{ data.description }}</td>
                                        <td>
                                            <span class="action">
                                                <Button @click="view(data.id)" icon="pi pi-eye" severity="info"
                                                    raised />
                                                <router-link class="btnUpdate"
                                                    :to="{ name: 'admin-edit-item', params: { id: data.id } }">
                                                    <Button icon="pi pi-pen-to-square" severity="success" raised />
                                                </router-link>
                                                <Button @click="deleteItem(data.id)" icon="pi pi-trash"
                                                    severity="danger" raised />
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="paginator">
                             <Button label="Prev" icon="pi pi-chevron-left" severity="contrast" variant="text" @click="prev()"/>
                             <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
                             <Button label="Next" icon="pi pi-chevron-right" iconPos="right" severity="contrast" variant="text" @click="next()"/>
                                </div>
                        </figure>


                    </div>
                </div>
            </div>
        </div>
        <Loading v-if="loading" />
        <AdminViewModal v-if="viewModal" :viewModalId="viewModalId" @exit="viewModal = false" />
    </div>



</template>




<style scoped>
@media screen and (max-width:1019px) {
    .table-main {
        max-width: 50rem;
        overflow-y: scroll;
        margin: auto;
    }

}

@media screen and (max-width:888px) {
    .table-main {
        max-width: 30rem;
        overflow-y: scroll;
        margin: auto;
    }

}

.admin-inventory-list {
    display: grid;
    gap: 20px;

}

.table-action {
    display: flex;
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
    border-radius: 10px;

}

.table-category {
    display: flex;
}

.table-category select:focus {
    outline: none;
    box-shadow: none;


}



.table table .action {
    display: flex;
    gap: 10px;
}

.action {
    display: flex;
    justify-content: start;
    gap: 10px;
}
.paginator{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<!-- <style scoped>
.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}

/* laptop or pc */
@media screen and (min-width: 769px) {
    .admin-inventory-list {
        width: 67rem;
        margin: auto;

    }

    .inventory-filter {
        display: flex;
        justify-content: space-between;
        align-content: center;

        align-items: center;
    }

    .filter {
        display: flex;
        align-items: center;
        gap: 10px;

    }

    .category {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .createButton {
        background-color: rgb(24, 180, 24);
        color: white;
    }

    .createButton span {
        display: flex;
        align-items: center;


    }

    #table {
        margin-top: 10px;
        display: grid;
        justify-content: center
    }

    table {
        height: 50rem;
        border-radius: 5px;
        max-width: rem;
        overflow-y: scroll;
        box-shadow: 0px 0px 5px 0px gray;
        padding: 10px;
        display: block;
    }

    table th {
        color: rgb(94, 93, 93);
        font-weight: 600;
        cursor: pointer;
    }

    table td {
        border-bottom: 2px solid white;
    }

    table .head-title {
        display: flex;
        justify-content: space-between;
    }

    .action {
        display: flex;
    }
    .action button{
        margin: 5px;
    }

    table tbody button {
        border-radius: 5px;
        color: white;
        border: 0px;
        font-weight: 600;
    }

    .btnView {
        background: none;
    }

    .btnUpdate {
        background: none;
    }

    .btnDelete {
        background: none;
    }

    .pagination {
        display: grid;
        align-items: center;
        justify-content: center;
    }

    .pagination-action button {
        border-radius: 4px;
        background-color: black;
        color: white;
        font-weight: 550;
        width: 4rem;
        text-align: center;
    }

    .btnPaginate {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btnPaginate button {
        width: 6rem;
        text-align: center;
    }
}

/* for small phones */
@media screen and (max-width: 1035px) {
    .admin-inventory-list {
        width: 50rem;
        margin: auto;


    }

    .inventory-filter {
        display: flex;
        justify-content: start;
        align-content: start;
        align-items: center;


    }

    .filter {
        display: flex;
        align-items: center;
        gap: 10px;

    }

    .category {
        display: flex;
        align-items: center;
        gap: 10px;

    }

    .createButton {
        background-color: rgb(24, 180, 24);
        color: white;
    }

    .createButton span {
        display: flex;
        align-items: center;


    }

    .search {
        width: 20rem;
    }

    .search input {
        max-width: 80%;

    }

    #table {
        margin: auto;
        max-width: 80rem;


    }

    table {
        margin: auto;
        height: 30rem;
        overflow-x: scroll;
        overflow-y: scroll;
        display: block;
        width: 50rem;
    }

    table th {
        color: rgb(94, 93, 93);
        font-weight: 600;
        border-bottom: 2px solid white;

    }

    table td {
        border-bottom: 2px solid white;
    }

    table .head-title {
        display: flex;
        justify-content: space-between;
    }

    .action {
        display: flex;
    }
   

    table tbody button {
        border-radius: 5px;
        color: white;
        border: 0px;
        font-weight: 600;
    }

    .btnView {
        background: none;
    }

    .btnUpdate {
        background: none;
    }

    .btnDelete {
        background: none;
    }

    .pagination {
        display: grid;
        align-items: center;
        justify-content: center;
    }

    .pagination-action button {
        border-radius: 4px;
        background-color: black;
        color: white;
        font-weight: 550;
        width: 4rem;
        text-align: center;
    }
}

/* screen and tablets */
@media screen and (min-width: 601px) {}
</style> -->
