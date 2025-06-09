<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import { onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import AdminCategoryListModal from "@/components/Admin_Category_List_Update_Modal.vue"
import Swal from 'sweetalert2';

const router = useRouter()

const selectedCategory = ref()
const search = ref('')

const categoryListCategoryData = ref({})
const categoryListTable = ref({})

const isCategoryListUpdateModal = ref(false)
const categoryTableId = ref(null)
const categoryLIstId = ref(null)
const sortOrder = ref('ASC')
const sortName = ref('')
const pagination = ref({
    current_page: '',
    last_page: ''
})

const CATEGORY_LIST_CATEGORY = async () => {
    axios({
        method: 'GET',
        url: 'api/category-list-category'
    }).then(response => {
        categoryListCategoryData.value = response.data
    })
}

const CATEGORY_LIST = async (page = 1) => {
    await axios({
        method: 'GET',
        url: `api/category-list-table?page=${page}`,
        params: {
            sortOrder: sortOrder.value,
            sortName: sortName.value,
            category: selectedCategory.value,
            search: search.value
        }
    })
    .then(response => {
        categoryListTable.value = response.data
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page
        }
    })
    .catch(e => {
        console.log(e);
    })
}

const sort = (val) => {
    sortName.value = val
    sortOrder.value = sortOrder.value === 'DESC' ? 'ASC' : 'DESC'
    CATEGORY_LIST()
}

const prevBtn = () => {
    if (pagination.value.current_page > 1) {
        CATEGORY_LIST(pagination.value.current_page - 1)
    }
}

const nextBtn = () => {
    if (pagination.value.current_page < pagination.value.last_page) {
        CATEGORY_LIST(pagination.value.current_page + 1)
    }
}

const editBtn = (val) => {
    isCategoryListUpdateModal.value = true
    categoryLIstId.value = val
}

const clear = () => {
    search.value = ""
    categoryLIstId.value = ""
}

const closeCategoryListModal = () => {
    isCategoryListUpdateModal.value = false
    CATEGORY_LIST()
}

const deleteBtn = (val) => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios({
                method: 'GET',
                url: 'api/delete-category',
                params: { id: val }
            }).then(response => {
                if (response.status === 200) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Deleted Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    CATEGORY_LIST()
                }
            })
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Delete not successful",
                icon: "error"
            });
        }
    });
}

watch(selectedCategory, () => CATEGORY_LIST())
watch(search, () => CATEGORY_LIST())

onMounted(() => {
    CATEGORY_LIST_CATEGORY()
    CATEGORY_LIST()
})
</script>

<template>
    <AdminCategoryListModal v-if="isCategoryListUpdateModal"
        @closeCategoryListModal="closeCategoryListModal"
        :categoryLIstId="categoryLIstId" />
    <header>
        <Header />
    </header>

    <div id="main">
        <section>
            <div class="row title mt-5">
                <Message severity="info" size="large" icon="pi pi-wrench" style="width: 100%;">
                    CATEGORY LIST
                </Message>
            </div>
        </section>

        <section>
            <div class="row mt-3 g-3 align-items-end">
                <div class="col-12 col-md-6 d-flex flex-column flex-md-row gap-2">
                    <Select placeholder="Category" v-model="selectedCategory" :options="categoryListCategoryData"
                        optionLabel="release_date" class="flex-fill" />
                    <InputGroup class="flex-fill">
                        <InputText placeholder="Search" v-model="search" size="small" />
                        <InputGroupAddon>
                            <Button icon="pi pi-search" severity="contrast" size="small" variant="text" />
                        </InputGroupAddon>
                    </InputGroup>
                </div>
                <div class="col-12 col-md-3 mt-2 mt-md-0">
                    <Button label="Clear" icon="pi pi-eraser" severity="secondary" raised @click="clear"
                        v-if="search || selectedCategory" class="w-100" />
                </div>
                <div class="col-12 col-md-3 text-md-end mt-2 mt-md-0">
                    <Button label="New Category" icon="pi pi-plus" severity="info"
                        @click="router.push('admin-new-category')" class="w-100 w-md-auto" />
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th @click="sort('name')">
                                        <div class="table_head">
                                            <span>Category Name</span>
                                            <i class="pi pi-sort-amount-down"></i>
                                        </div>
                                    </th>
                                    <th @click="sort('details')">
                                        <div class="table_head">
                                            <span>Details</span>
                                            <i class="pi pi-sort-amount-down"></i>
                                        </div>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in categoryListTable.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.details }}</td>
                                    <td class="category_table_action">
                                        <Button icon="pi pi-pencil" severity="info" raised @click="editBtn(data.id)" />
                                        <Button icon="pi pi-trash" severity="danger" raised @click="deleteBtn(data.id)" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 mt-3 d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <Button label="Prev" variant="text" icon="pi pi-angle-left" severity="contrast" @click="prevBtn()" />
                    <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
                    <Button label="Next" icon="pi pi-angle-right" variant="text" iconPos="right" severity="contrast"
                        @click="nextBtn()" />
                </div>
            </div>
        </section>
    </div>
</template>


<style scoped>
.table-option {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

section {
    padding: 10px;
    margin: 20px;
    box-shadow: 1px 1px 5px 0px gray;
    border-radius: 5px;
    background-color: #fff;
}

.list-action {
    display: flex;
    gap: 10px;
    justify-content: end;
    flex-wrap: wrap;
}

th {
    background-color: #ebe9e9;
    transition: all linear 0.4s;
}

th:hover {
    background: #D9D9D9;
    cursor: pointer;
}

.table_head {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.category_table_action {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

#main {
    margin: 1rem;
}

@media (max-width: 768px) {
    .table_head {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
