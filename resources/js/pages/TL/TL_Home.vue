<script setup>
import Header from "@/components/TL_Header.vue";
import { onMounted, ref, watch } from "vue";
import barcode from '@/components/BarcodeView.vue'
import { Button, Card, InputGroup, InputGroupAddon, InputText, Select } from "primevue";





//COMPONENTS VARIABLES
const category = ref("")
const search = ref("")
const pagination = ref({
    current_page: null,
    last_page: null
})


//API VARIABLES
const itemCategoryData = ref({})
const itemListData = ref({})




//API FUNCTIONS
const GET_ITEM_CATEGORY = async () => {
    await axios({
        method: 'GET',
        url: 'api/tl-item-category',

    }).then(response => {
        itemCategoryData.value = response.data

    })
}

const GET_ITEM_LIST_API = async (page = 1) => {
    await axios({
        method: 'GET',
        url: `api/tl-item-list?page=${page}`,
        params: {
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


//COMPONENTS FUNCTION
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



// HOOKS
watch(category, (oldVal, newVal) => {
GET_ITEM_LIST_API()

});

watch(search, (oldVal, newVal) => {
   
GET_ITEM_LIST_API()
});



onMounted(() => {
    GET_ITEM_CATEGORY()
    GET_ITEM_LIST_API()

});
</script>

<template>
    <Header />
    <div class="row m-2">
        <div class="col">
            <div class="admin-inventory-list">
                <!-- Filter -->

                <div class="filter">
                    <Select placeholder="Date" :options="itemCategoryData" optionLabel="release_date"
                        v-model="category" />
                    <InputGroup>
                        <InputText placeholder="Keyword" v-model="search" />
                        <InputGroupAddon>
                            <Button icon="pi pi-search" severity="secondary" variant="text" @click="toggle" />
                        </InputGroupAddon>
                    </InputGroup>
                    <Button severity="secondary" label="Clear" icon="pi pi-eraser" raised  v-if="search || category" @click="clear()"/>
                    <!-- <Button label="print" icon="pi pi-file-pdf" severity="danger" raised /> -->
                </div>
                <div class="items">
                    <Card
                        style="width: 26rem; border-radius: 10px;box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); overflow: hidden"
                        v-for="(data) in itemListData.data">
                        <template #header class="">
                            <div class="text-center">
                                <barcode :barcodeValue="data.item_code" />
                            </div>
                        </template>
                        <template #title>{{ data.category }}</template>
                        <template #subtitle>{{ data.supplier_name }} | {{ data.brand }}</template>
                        <template #content>
                            <p class="m-0">
                                {{ data.description }}
                            </p>
                           <div class="action text-end">
                            <Button icon="pi pi-eye" severity="contrast" raised/>
                           </div>
                        </template>
                    </Card>
                    
                </div>
                <div class="pagination_class mt-4">
                    <Button label="Prev" icon="pi pi-chevron-left" severity="contrast" variant="text" @click="prev()"/>
                    <span>{{ pagination.current_page }} 0f {{ pagination.last_page }}</span>
                    <Button label="Next" icon="pi pi-chevron-right" iconPos="right" severity="contrast" variant="text" @click="next()"/>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>
.admin-inventory-list {
    max-width: 80%;
    margin: auto;
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

.items {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    margin: auto;
    justify-content: center;
    align-items: center;
    margin-top: 20px;

}

.item {
    width: 20rem;
    background: rgb(255, 255, 255);
    height: 15rem;
    overflow: scroll;
    overflow-x: hidden;
    box-shadow: 0px 0px 5px 0px black;
    padding: 10px;
    border-radius: 5px;

}

.item::-webkit-scrollbar {
    width: 3px;
    height: 25px;

}

.item::-webkit-scrollbar-track {
    border-radius: 15px;
    background: rgb(192, 191, 191);
}

.item::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(26, 25, 25, 0.5);

}

.item h4 {
    color: rgb(72, 128, 231);
    font-weight: 600;
}

.title {
    display: flex;
    justify-content: space-between;
}
.pagination_class{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
