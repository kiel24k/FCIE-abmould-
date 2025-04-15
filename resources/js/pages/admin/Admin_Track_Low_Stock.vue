<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import { onMounted, ref, watch } from 'vue';
import TrackLowStockModal from '@/components/Admin_Track_Low_Stock_Adjust_Treshold_Modal.vue'

const isModal = ref(false)

const selectedCategory = ref('')
const search = ref('')

const tableId = ref()
const userId = ref()
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


const GET_TRACK_LOW_STOCK_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/stock-category'
    })
        .then(function (response) {
            getTrackLowStockCategory.value = response.data
        }
        )
}

const GET_TRACK_LOW_STOCK_API = async (page = pagination.value.page) => {
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
    GET_TRACK_LOW_STOCK_API()
}

const clear = () => {
    selectedCategory.value = ''
    search.value = ''
}

const prev = () => {
    if (pagination.value.current_page <= pagination.value.last_page) {
        GET_TRACK_LOW_STOCK_API(pagination.value.current_page - 1)
    }
}

const next = () => {
    if (pagination.value.last_page > pagination.value.current_page) {
        GET_TRACK_LOW_STOCK_API(pagination.value.current_page + 1)
    }
}
const openAdjustTresholdModal = (id) => {
    tableId.value = id
    isModal.value = true
}

const closeAdjustTresholdModal = () => {
    GET_TRACK_LOW_STOCK_API()
    isModal.value = false
}

watch(selectedCategory, (oldVal, newVal) => {
    GET_TRACK_LOW_STOCK_API();
})

watch(search, (oldVal, newVal) => {
    GET_TRACK_LOW_STOCK_API()
})


onMounted(() => {
    GET_TRACK_LOW_STOCK_CATEGORY_API()
    GET_TRACK_LOW_STOCK_API()
})

</script>

<template>
    <header>
        <Header @user="user" />
    </header>
    <TrackLowStockModal v-if="isModal" @closeAdjustTresholdModal="closeAdjustTresholdModal" :tableId="tableId" :userId="userId" />

    <div id="main">
        <section>
            <div class="row title">
                <Message severity="info" size="large" icon="pi pi-wrench" fluid>
                    ADJUST TRESHOLD ITEM
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
                            <Button icon="pi pi-search" severity="contrast" size="small" variant="text" @click="toggle"  />
                        </InputGroupAddon>
                        <Button label="Clear" severity="secondary" icon="pi pi-eraser" raised size="small" @click="clear()" v-if="search || category" />
                    </InputGroup>
                    
    
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
                            <th @click="sort('quantity')">
                                <div class="table-head">
                                    <span>Current Stock</span><i class="pi pi-sort-amount-up" v-if="sortType === 'ASC'"></i>
                                    <i class="pi pi-sort-amount-down" v-else></i>
                                </div>
                            </th>
                            <th @click="sort('treshold')">
                                <div class="table-head">
                                    <span>Treshold</span><i class="pi pi-sort-amount-up" v-if="sortType === 'ASC'"></i>
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
                            <td>x{{ data.quantity }}</td>
                            <td>x{{ data.treshold }}</td>
                            <td>
                                <Button label="Adjust Treshold" severity="info" icon="pi pi-pencil" raised
                                    @click="openAdjustTresholdModal(data.id)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pag">
                        <Button label="prev" severity="contrast" variant="text" icon="pi pi-angle-left" @click="prev()" />
                       <span> {{ pagination.current_page }} of {{ pagination.last_page }}</span>
                        <Button label="next" severity="contrast"  variant="text" icon="pi pi-angle-right" iconPos="right" @click="next()" />
                </div>
            </div>
    
        </section>
    </div>


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
    align-content: center;
}
.title{
    margin-top: 5rem;
}

#main{
    margin-left: 3rem;
}
</style>