<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <DeleteItemModal v-if="deleteItemModal" @cancelItem="cancelItem" :deleteId="deleteId"/>
    <div class="row">
        <div :class="isSidebarHidden ? 'col-0' : 'col-2'" :key="sidebar">
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <div :class="isSidebarHidden ? 'col-12' : 'col-9'" key="content" class="row my-3 mx-1">
            <div class="col">
                <div class="admin-inventory-list">
                    <!-- Filter -->
                    <div class="inventory-filter">
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
                            </div>
                        </div>
                        <div class="create">
                            <router-link :to="{ name: 'admin-new-item' }" class="btn createButton">
                                <span>
                                    <img src="/public/icon/add_icon_plus.png" width="15px" alt="">
                                    <b>Add Item</b>
                                </span>
                            </router-link>
                        </div>
                    </div>
                    <div id="table" class="table-responsive-sm-2">
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
                                            <button class="btnView" @click="view(data.id)">
                                                <img src="/public/icon/view_icon_eye.png" width="30px" alt="">
                                            </button>
                                            <router-link class="btnUpdate"
                                                :to="{ name: 'admin-edit-item', params: { id: data.id } }">
                                                <img src="/public/icon/edit_icon_pencil.png" width="30px" alt="">
                                            </router-link>
                                            <button class="btnDelete">
                                                <img src="/public/icon/trash_icon.png" width="30px" alt=""
                                                    @click="deleteItem(data.id)">
                                            </button>
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
                    </div>
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
const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const deleteItemModal = ref(false)
const deleteId = ref()
//current database table
const selected = ref('')
const loading = ref(false)
const responseData = ref({})
const search = ref('')
const viewModal = ref(false)
const viewModalId = ref(null)
const sortColumn = ref('brand'); // Default sorting column
const sortOrder = ref('asc'); // Default sorting order

const pagination = ref({
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
});

// data per category
const category = async (page) => {
    if (page < 1 || page > pagination.value.last_page) return;
    axios({
        method: 'GET',
        url: `/api/item-category?category=${selected.value}&page=${page}`,
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
    category()
})

watch(search, (oldVal, newVal) => {
    axios({
        method: 'GET',
        url: `/api/items-search?category=${selected.value}&search=${search.value}`
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
        height: 24rem;
        max-width: 71rem;
        overflow-y: scroll;
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
</style>
