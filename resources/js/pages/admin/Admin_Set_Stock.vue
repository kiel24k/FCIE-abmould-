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
    }).then(response => {
        getTrackLowStockCategory.value = response.data
    })
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
    }).then(response => {
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
    if (pagination.value.current_page > 1) {
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

watch(selectedCategory, () => {
    GET_SET_STOCK_API()
})

watch(search, () => {
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

    <div id="main">
        <section>
            <div class="row title">
                <Message severity="info" size="large" icon="pi pi-wrench" style="width: 100%;">
                    SET ITEM STOCK
                </Message>
            </div>
        </section>

        <section>
            <div class="row bg-white p-3 gy-3 align-items-end">
                <div class="col-12 col-md-6 d-flex flex-column flex-md-row gap-2">
                    <Select v-model="selectedCategory" :options="getTrackLowStockCategory" optionLabel="release_date"
                        size="small" placeholder="Select a Date" class="flex-fill" />
                    <InputGroup class="flex-fill">
                        <InputText placeholder="Search" v-model="search" size="small" />
                        <InputGroupAddon>
                            <Button icon="pi pi-search" severity="contrast" size="small" variant="text" />
                        </InputGroupAddon>
                    </InputGroup>
                </div>
                <div class="col-12 col-md-3">
                    <Button label="Clear" severity="secondary" raised size="small" class="w-100"
                        @click="clear()" v-if="search || selectedCategory" />
                </div>
            </div>

            <div class="row bg-white p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th @click="sort('category')">
                                    <div class="table-head">
                                        <span>Category</span>
                                        <i :class="sortType === 'ASC' ? 'pi pi-sort-amount-up' : 'pi pi-sort-amount-down'"></i>
                                    </div>
                                </th>
                                <th @click="sort('item_code')">
                                    <div class="table-head">
                                        <span>Item Code</span>
                                        <i :class="sortType === 'ASC' ? 'pi pi-sort-amount-up' : 'pi pi-sort-amount-down'"></i>
                                    </div>
                                </th>
                                <th @click="sort('treshold')">
                                    <div class="table-head">
                                        <span>Treshold</span>
                                        <i :class="sortType === 'ASC' ? 'pi pi-sort-amount-up' : 'pi pi-sort-amount-down'"></i>
                                    </div>
                                </th>
                                <th @click="sort('quantity')">
                                    <div class="table-head">
                                        <span>Current Stock</span>
                                        <i :class="sortType === 'ASC' ? 'pi pi-sort-amount-up' : 'pi pi-sort-amount-down'"></i>
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
                </div>

                <div class="col-12 mt-3 d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <Button label="Prev" severity="contrast" icon="pi pi-angle-left" variant="text" @click="prev()" />
                    <b>{{ pagination.current_page }} of {{ pagination.last_page }}</b>
                    <Button label="Next" severity="contrast" icon="pi pi-angle-right" variant="text" iconPos="right"
                        @click="next()" />
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

.table-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.title {
    margin-top: 5rem;
}

#main {
    margin-left: 3rem;
}

@media (max-width: 768px) {
    .table-head {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
