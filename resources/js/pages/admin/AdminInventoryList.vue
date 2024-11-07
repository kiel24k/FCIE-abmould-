<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <DeleteItemModal v-if="deleteItemModal" @cancelItem="cancelItem" :deleteId="deleteId" />
    <div class="row">
        <div :class="isSidebarHidden ? 'col-0' : 'col-2'" :key="sidebar">
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <div :class="isSidebarHidden ? 'col-12' : 'col-9'" key="content" class="row my-3 mx-1">
            <div class="col">
                <div class="admin-inventory-list">
                    <div class="row">
                        <div class="col title">
                            <h2>Item List</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-category">
                            <div class="card flex justify-center">
                                <Select v-model="selected" :options="itemOption" :selected="itemOption.default"
                                    showClear optionLabel="name" placeholder="Select a City" class="w-full md:w-56" />
                            </div>
                        </div>
                        <div class="col table-action">
                            <div class="search">
                                <input type="text" class="form-control" placeholder="search" v-model="search">
                                <Button icon="pi pi-search" severity="secondary" raised />
                            </div>
                            <Button icon="pi pi-file-pdf" severity="danger" raised></Button>
                            <Button icon="pi pi-plus-circle" severity="info" label="New Item" raised />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th class="" @click="sort('category')">
                                            <div class="head-title">
                                                Category
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                            </div>
                                        </th>
                                        <th @click="sort('barcode')">
                                            <div class="head-title">
                                                item_code
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                            </div>
                                        </th>
                                        <th @click="sort('brand')">
                                            <div class="head-title">
                                                Brand
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                            </div>
                                        </th>
                                        <th @click="sort('supplier_name')">
                                            <div class="head-title">
                                                Supplier Name
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                            </div>
                                        </th>
                                        <th @click="sort('unit_cost')">
                                            <div class="head-title">
                                                Unit_Cost
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                            </div>
                                        </th>
                                        <th @click="sort('quantity')">
                                            <div class="head-title">
                                                Quantity
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                            </div>
                                        </th>
                                        <th @click="sort('description')">
                                            <div class="head-title">
                                                Description
                                                <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
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
                                    <tr v-for="(data, index) in responseData.data" :key="index">
                                        <td>{{ data.category }}</td>
                                        <td>{{ data.item_code }}</td>
                                        <td>{{ data.brand }}</td>
                                        <td>{{ data.supplier_name }}</td>
                                        <td class="text-success">{{ data.unit_cost }}</td>
                                        <td>x{{ data.quantity }}</td>
                                        <td>{{ data.description }}</td>
                                        <td>
                                            <span class="action">
                                                <Button @click="view(data.id)" icon="pi pi-eye" severity="info" rounded
                                                    raised />
                                                <router-link class="btnUpdate"
                                                    :to="{ name: 'admin-edit-item', params: { id: data.id } }">
                                                    <Button icon="pi pi-pen-to-square" severity="success" rounded
                                                        raised />
                                                </router-link>
                                                <Button @click="deleteItem(data.id)" icon="pi pi-delete-left"
                                                    severity="danger" rounded raised />
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <!-- Filter -->
                    <!-- <div class="inventory-filter">
                        <div class="category">
                            <label for="">category: </label>
                            <select class="form-select" v-model="selected">
                                <option value="selected" disabled>Select</option>
                                <option value=""> all </option>
                                <option value="tools">tools</option>
                                <option value="materials">materials</option>
                            </select>
                        </div>
                        <div class="search col-8">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <img src="/public/icon/search.png" width="25px" alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="Search" v-model="search">

                                <Button icon="pi pi-file-pdf" severity="danger" label="print" @click="generatePdf"/>
                            </div>
                        </div>
                        <div class="create">
                            <router-link :to="{ name: 'admin-new-item' }">
                                <Button icon="pi pi-plus-circle" label="Add Item" severity="info"></Button>
                            </router-link>
                        </div>
                    </div>
                    <div id="table" class="table-responsive-sm-2" ref="printContent">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="" @click="sort('category')">
                                        <div class="head-title">
                                            Category
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                        </div>
                                    </th>
                                    <th @click="sort('barcode')">
                                        <div class="head-title">
                                            item_code
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                        </div>
                                    </th>
                                    <th @click="sort('brand')">
                                        <div class="head-title">
                                            Brand
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                        </div>
                                    </th>
                                    <th @click="sort('supplier_name')">
                                        <div class="head-title">
                                            Supplier Name
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                        </div>
                                    </th>
                                    <th @click="sort('unit_cost')">
                                        <div class="head-title">
                                            Unit_Cost
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                        </div>
                                    </th>
                                    <th @click="sort('quantity')">
                                        <div class="head-title">
                                            Quantity
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                        </div>
                                    </th>
                                    <th @click="sort('description')">
                                        <div class="head-title">
                                            Description
                                            <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
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
                                <tr v-for="(data, index) in responseData.data" :key="index">
                                    <td>{{ data.category }}</td>
                                    <td>{{ data.item_code }}</td>
                                    <td>{{ data.brand }}</td>
                                    <td>{{ data.supplier_name }}</td>
                                    <td class="text-success">{{ data.unit_cost }}</td>
                                    <td>x{{ data.quantity }}</td>
                                    <td>{{ data.description }}</td>
                                    <td>
                                        <span class="action">
                                            <Button  @click="view(data.id)" icon="pi pi-eye" severity="info"/>
                                            <router-link class="btnUpdate" 
                                                :to="{ name: 'admin-edit-item', params: { id: data.id } }">
                                                <Button icon="pi pi-pen-to-square" severity="success"/>
                                            </router-link>
                                            <Button  @click="deleteItem(data.id)" icon="pi pi-delete-left" severity="danger"/>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>




                        <div class="paginator text-center">
                            <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
                            <nav class="btnPaginate">
                                <button class="btn btn-dark" @click="previousPage"
                                    :disabled="!pagination.prev_page_url">
                                    Previous
                                </button>
                                <button class="btn btn-success" @click="nextPage" :disabled="!pagination.next_page_url">
                                    Next
                                </button>
                            </nav>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <Loading v-if="loading" />
        <AdminViewModal v-if="viewModal" :viewModalId="viewModalId" @exit="viewModal = false" />



    </div>



</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import Sidebar from '@/components/Admin_Sidebar.vue';
import { onMounted, ref, watch } from 'vue';
import AdminViewModal from '@/components/Admin_View_Modal.vue'
import DeleteItemModal from '@/components/Admin_Delete_Inventory_Modal_Logout.vue'
import Loading from '@/components/Loading.vue'
import html2pdf from 'html2pdf.js';
import Button from 'primevue/button';
import Select from 'primevue/select';    // optional

const products = ref([
    { name: 'Product A', category: 'Category 1', price: 100, quantity: 10 },
    { name: 'Product B', category: 'Category 2', price: 150, quantity: 5 },
    { name: 'Product C', category: 'Category 1', price: 200, quantity: 7 },
    { name: 'Product D', category: 'Category 3', price: 250, quantity: 3 },
    { name: 'Product E', category: 'Category 2', price: 120, quantity: 12 },
    // Add more products as needed
]);



const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const printContent = ref(null)
const deleteItemModal = ref(false)
const deleteId = ref()
//current database table
const selected = ref(null)
const loading = ref(false)
const responseData = ref({})
const search = ref('')
const viewModal = ref(false)
const viewModalId = ref(null)
const sortColumn = ref('brand'); // Default sorting column
const sortOrder = ref('asc'); // Default sorting order
const itemOption = ref([
    { default: '' },
    { name: 'tools' },
    { name: 'materials' },
]);

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


const pagination = ref({
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
});

// data per categor
const category = async (page) => {
    if (selected.value === null) {
        if (page < 1 || page > pagination.value.last_page) return;
        axios({
            method: 'GET',
            url: `/api/item-category?&page=${page}`,
            params: {
                sort_by: sortColumn.value,
                sort_order: sortOrder.value
            }
        }).then(response => {
            loading.value = false
            pagination.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                next_page_url: response.data.next_page_url,
                prev_page_url: response.data.prev_page_url,
            };
            responseData.value = response.data
        })
    }else if(selected){
        if (page < 1 || page > pagination.value.last_page) return;
        axios({
            method: 'GET',
            url: `/api/item-category?category=${selected.value.name}&page=${page}`,
            params: {
                sort_by: sortColumn.value,
                sort_order: sortOrder.value
            }
        }).then(response => {
            loading.value = false
            pagination.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                next_page_url: response.data.next_page_url,
                prev_page_url: response.data.prev_page_url,
            };
            responseData.value = response.data
        })

    }
}
const sort = (column) => {
    if (sortColumn.value === column) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortOrder.value = 'asc';
    }
    category()
};
watch(selected, (oldVal, newVal) => {
  if(selected.value == null){
   category()
  }
    category()
})

watch(search, (oldVal, newVal) => {
    console.log(search.value);
    axios({
        method: 'GET',
        url: `/api/items-search?category=${selected.value.name}&search=${search.value}`
    }).then(response => {
        responseData.value = response.data
    })
    if (search.value === '') {
        category()
    }
})

const view = (id) => {
    viewModal.value = true
    viewModalId.value = id

}
//delete item
const deleteItem = (id) => {
    deleteItemModal.value = true
    deleteId.value = id
}

const cancelItem = () => {
    deleteItemModal.value = false
    category()
}

const previousPage = () => {
    if (pagination.value.prev_page_url) {
        category(pagination.value.current_page - 1);
    }
};

const nextPage = () => {
    if (pagination.value.next_page_url) {
        category(pagination.value.current_page + 1);
    }
};


onMounted(() => {
    category()
})

</script>


<style scoped>
.admin-inventory-list {
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

.search {
    display: flex;
}

.table {
    padding: 10px;
    border: solid 1px rgb(221, 219, 219);
}

.table table th {
    background: rgb(200, 236, 250);
}

.table table .action {
    display: flex;
    gap: 10px;
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
