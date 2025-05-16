<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import { onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import AdminCategoryListModal from "@/components/Admin_Category_List_Update_Modal.vue"
import Swal from 'sweetalert2';

const router = useRouter()

//INPUT VARIABLES
const selectedCategory = ref()
const search = ref('')

//API VARIABLES
const categoryListCategoryData = ref({})
const categoryListTable = ref({})

//COMPONENTS VARIABLES
const isCategoryListUpdateModal = ref(false)
const categoryTableId = ref(null)
const categoryLIstId = ref(null)
const sortOrder = ref('ASC')
const sortName = ref('')
const pagination = ref({
    current_page: '',
    last_page: ''

})

//API FUNCTIONS
const CATEGORY_LIST_CATEGORY = async () => {
    axios({
        method: 'GET',
        url: 'api/category-list-category'
    })
        .then(response => {
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


            console.log(response.data);

        })
        .catch(e => {
            console.log(e);
        })
}


//COMPONENTS
const sort = (val) => {
    if (sortOrder.value === 'DESC') {
        sortName.value = val
        sortOrder.value = 'ASC'
    } else {
        sortName.value = val
        sortOrder.value = 'DESC'
    }
    CATEGORY_LIST()

}

const prevBtn = () => {
    if (pagination.value.current_page <= pagination.value.last_page) {
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
//commetdsadasdas
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
                params: {
                    id: val
                }
            }).then(response => {
                if (response.status === 200) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Deleted Successfull",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            CATEGORY_LIST()


        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Delete not successfull",
                icon: "error"
            });
        }
    });



    CATEGORY_LIST()
}







watch(selectedCategory, (oldVal, newVal) => {
    console.log(selectedCategory.value);
    CATEGORY_LIST()

})

watch(search, (oldVal, newVal) => {
    CATEGORY_LIST()

})

//Hooks
onMounted(() => {
    CATEGORY_LIST_CATEGORY()
    CATEGORY_LIST()
})


</script>

<template>
    <AdminCategoryListModal v-if="isCategoryListUpdateModal" @closeCategoryListModal="closeCategoryListModal"
        :categoryLIstId="categoryLIstId" />
    <header>
        <Header />
    </header>

    <div id="main">
        <section>
            <div class="row title mt-5">
                <Message severity="info" size="large" icon="pi pi-wrench" fluid>
                    CATEGORY LIST
                </Message>
            </div>
        </section>
    
        <section>
            <div class="row mt-3">
                <div class="col-3 table-option">
                    <Select placeholder="Category" v-model="selectedCategory" :options="categoryListCategoryData"
                        optionLabel="release_date" />
                    <InputGroup>
                        <InputText placeholder="Search" v-model="search" size="small" />
                        <InputGroupAddon>
                            <Button icon="pi pi-search" severity="contrast" size="small" variant="text" @click="toggle" />
                        </InputGroupAddon>
                    </InputGroup>
                    <Button label="clear" severity="secondary" icon="pi pi-erased" raised  @click="clear" v-if="search || category"  />
                </div>
                <div class="col text-end list-action">
                    <Button label="New Category" icon="pi pi-plus" severity="info"
                        @click="router.push('admin-new-category')" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <table class="table table-bordered table-responsive table-hover">
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
                                    <Button icon="pi pi-pencil" severity="info" raised @click="editBtn(data.id)"  />
                                    <Button icon="pi pi-trash" severity="danger" raised @click="deleteBtn(data.id)" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col pagination_button">
                        <Button label="Prev" variant="text" icon="pi pi-angle-left" severity="contrast" @click="prevBtn()" />
                        <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
                        <Button label="Next" icon="pi pi-angle-right" variant="text" iconPos="right" severity="contrast" @click="nextBtn()" />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.table-option {
    display: flex;
    gap: 10px;
}

section {
    padding: 10px;
    margin: 20px;
    box-shadow: 1px 1px 5px 0px gray;
}

.list-action {
    display: flex;
    gap: 10px;
    justify-content: end;
}

th {
    background-color: #ebe9e9;
    transition: all linear 0.4s;
}

.table-head {
    display: flex;
    justify-content: space-between;
    align-content: center;
    align-items: center;
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
.category_table_action{
    display: flex;
    gap:5px;
}
.pagination_button{
    display: flex;
    align-items: center;
    justify-content: center;
}
#main{
    margin-left: 3rem;
}

</style>