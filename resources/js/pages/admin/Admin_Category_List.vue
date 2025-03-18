<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, InputGroup, InputGroupAddon, InputText, Select } from 'primevue';
import { onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter()

//INPUT VARIABLES
const selectedCategory = ref()
const search = ref('')

//API VARIABLES
const categoryListCategoryData = ref({})
const categoryListTable = ref({})


//API FUNCTIONS
const CATEGORY_LIST_CATEGORY= async () => {
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
            category: selectedCategory.value,
            search: search.value
        }
    })
        .then(response => {
            categoryListTable.value = response.data
        })
        .catch(e => {
            console.log(e);
            
        })
}

//Hooks



onMounted(() => {
    CATEGORY_LIST_CATEGORY()
    CATEGORY_LIST()
})





watch(selectedCategory, (oldVal, newVal) => {
    console.log(selectedCategory.value);
    CATEGORY_LIST()

})

watch(search, (oldVal, newVal) => {
    CATEGORY_LIST()

})

</script>

<template>

    <header>
        <Header />
    </header>



    <section>
        <div class="row">
            <div class="col title">
                <h1>Category List</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-3 table-option">
                <Select placeholder="Category" v-model="selectedCategory" :options="categoryListCategoryData"
                    optionLabel="release_date" />
                <InputGroup>
                    <InputText placeholder="Search" v-model="search" size="small" />
                    <InputGroupAddon>
                        <Button icon="pi pi-search" severity="contrast" size="small" variant="text" @click="toggle" />
                    </InputGroupAddon>
                </InputGroup>
                <Button label="clear" severity="danger" />
            </div>
            <div class="col text-end list-action">
                <Button label="New Category" icon="pi pi-plus" severity="info"
                    @click="router.push('admin-new-category')" />
                <Button label="Print" icon="pi pi-print" severity="danger" />
            </div>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>
                                <div class="table_head">
                                    <span>Category Name</span>
                                    <i class="pi pi-sort-amount-down"></i>
                                </div>
                            </th>
                            <th>
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
                            <td>{{ data.name }}</td>
                            <td>{{ data.details }}</td>
                            <td class="category_table_action">
                                <Button icon="pi pi-pencil" severity="info" />
                                <Button icon="pi pi-trash" severity="danger" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col text-center">
                    <Button label="Prev" />
                    <span>1 of 2</span>
                    <Button label="Next" />
                </div>
            </div>
        </div>
    </section>
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
    border: white solid 1px;
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

td {
    border: white solid 1px;
    background-color: #D9D9D9;
    padding: 20px;
}

.table_head {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.catagory_table_action>button {
    margin: 2px;

}
</style>