<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import { onMounted, ref, watch } from 'vue';
import SetStockTresholdModal from '@/components/Admin_Set_Stock_Treshold_Modal.vue'

const isModal = ref(false)

const selectedCategory = ref('')
const search = ref('')

const userId = ref()
const tableId = ref()
const getTrackLowStockCategory = ref({})
const getTrackLowStockData = ref({})
const sortType = ref('ASC')
const sortedName = ref('')
const pagination = ref({
    current_page: null,
    last_page: null,
    page: 1
})

const user = (data) => {
    userId.value = data.id
}


const GET_SET_STOCK_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/stock-category'
    })
        .then(function (response) {
            getTrackLowStockCategory.value = response.data
        }
        )
}

const GET_SET_STOCK_API = async (page = pagination.value.page) => {
    await axios({
        method: 'GET',
        url: `api/get-stock?page=${page}`,
        params: {
            category: selectedCategory.value,
            search: search.value,
            sort: sortType.value,
            sortedName: sortedName.value
        }
    })
        .then(function (response) {
            console.log(response.data);
            pagination.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page
            }

            getTrackLowStockData.value = response.data
        })
}

const sort = (value) => {

    if (sortType.value === 'DESC') {
        sortedName.value = value
        sortType.value = 'ASC'
    } else {
        sortedName.value = value
        sortType.value = 'DESC'
    }
    GET_SET_STOCK_API()
}

const clear = () => {
    selectedCategory.value = ''
    search.value = ''
}

const prev = () => {
    if (pagination.value.current_page <= pagination.value.last_page) {
        GET_SET_STOCK_API(pagination.value.current_page - 1)
    }
}

const next = () => {
    if (pagination.value.last_page > pagination.value.current_page) {
        GET_SET_STOCK_API(pagination.value.current_page + 1)
    }
}
const openAdjustTresholdModal = (id) => {
    tableId.value = id
    isModal.value = true
}

const closeSetStockModal = () => {
    GET_SET_STOCK_API()
    isModal.value = false
}

watch(selectedCategory, (oldVal, newVal) => {
    GET_SET_STOCK_API()
})

watch(search, (oldVal, newVal) => {
    GET_SET_STOCK_API()
})


onMounted(() => {
    GET_SET_STOCK_CATEGORY_API()
    GET_SET_STOCK_API()
})

</script>

<template>
    <header>
        <Header @user="user" />
    </header>
    <SetStockTresholdModal v-if="isModal" @closeSetStockModal="closeSetStockModal" :tableId="tableId" :userId="userId" />

    <section>
        <div class="row title">
            <Message severity="info" size="large" icon="pi pi-wrench" fluid>
                SET ITEM STOCK
            </Message>
        </div>
    </section>

    <section>
        <div class="row bg-white p-3">

            <div class="col-3 category">
                <Select v-model="selectedCategory" :options="getTrackLowStockCategory" optionLabel="release_date"
                    size="small" placeholder="Select a Date" class="w-full md:w-56" />
                <InputGroup>
                    <InputText placeholder="Search" v-model="search" size="small" />
                    <InputGroupAddon>
                        <Button icon="pi pi-search" severity="contrast" size="small" variant="text" @click="toggle" />
                    </InputGroupAddon>
                </InputGroup>
                <Button label="Clear" severity="danger" raised size="small" @click="clear()" />

            </div>
            <div class="col text-end search">
                <Button icon="pi pi-print" severity="danger" label="Print" raised />
            </div>
        </div>
        <div class="row bg-white p-3">
            <table class="table table-responsive table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <div class="table-head">
                                <span>#</span>
                            </div>
                        </th>
                        <th @click="sort('category')">
                            <div class="table-head">
                                <span>Category</span><i class="pi pi-sort-amount-up" v-if="sortType === 'ASC'"></i>
                                <i class="pi pi-sort-amount-down" v-else></i>
                            </div>
                        </th>
                        <th @click="sort('item_code')">
                            <div class="table-head">
                                <span>Item Code</span><i class="pi pi-sort-amount-up" v-if="sortType === 'ASC'"></i>
                                <i class="pi pi-sort-amount-down" v-else></i>
                            </div>
                        </th>
                        <th @click="sort('treshold')">
                            <div class="table-head">
                                <span>Treshold</span><i class="pi pi-sort-amount-up" v-if="sortType === 'ASC'"></i>
                                <i class="pi pi-sort-amount-down" v-else></i>
                            </div>
                        </th>
                        <th @click="sort('quantity')">
                            <div class="table-head">
                                <span>Current Stock</span><i class="pi pi-sort-amount-up" v-if="sortType === 'ASC'"></i>
                                <i class="pi pi-sort-amount-down" v-else></i>
                            </div>
                        </th>

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in getTrackLowStockData.data" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ data.category }}</td>
                        <td>{{ data.item_code }}</td>
                        <td>x{{ data.treshold }}</td>
                        <td>x{{ data.quantity }}</td>
                        <td>
                            <Button label="Adjust Stock" severity="info" icon="pi pi-pencil" raised
                                @click="openAdjustTresholdModal(data.id)" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pag text-center">
                    <Button label="Prev" severity="contrast" icon="pi pi-angle-left" variant="text" @click="prev()" />
                  <b>  {{ pagination.last_page }} of {{ pagination.current_page }}</b>
                    <Button label="Next" severity="contrast" icon="pi pi-angle-right" variant="text"  iconPos="right" @click="next()" />
            </div>
        </div>

    </section>


</template>

<style scoped>
section {
    margin: 20px;
    box-shadow: 1px 1px 5px 0px gray;
}

.category {
    display: flex;
    gap: 5px;
    align-items: center;
    align-content: center;
}



.table-head {
    display: flex;
    justify-content: space-between;
    align-content: center;
    align-items: center;
}


.pag{
    display: flex;
    align-items: center;
    justify-content: center;

}

</style>