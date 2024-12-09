<template>
    <Header />
    <div class="row m-2">
        <div class="col">
            <div class="admin-inventory-list">
                <div class="row">
                    <div class="col text-end">
                        <div class="category">
                            <select  v-model="selected">
                                <option :value="data.category" v-for="(data) in itemCategory" >
                                    {{ data.category }}
                                </option>
                            </select>
                            <InputGroup>
                                <InputText placeholder="Keyword" v-model="search" />
                                <InputGroupAddon>
                                    <Button icon="pi pi-search" severity="secondary" variant="text" disabled/>
                                </InputGroupAddon>
                            </InputGroup>
                        </div>
                    </div>
                </div>
                <div class="items">
                    <Card style="width: 25rem; border-radius: 10px;box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); overflow: hidden" v-for="(data) in items ">
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
                        </template>
                    </Card>
                </div>
                <div class="pagination justify-content-center mt-5">
                    <Bootstrap5Pagination :data="responseData" @pagination-change-page="getItem" />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Header from "@/components/TL_Header.vue";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import { onMounted, ref, watch } from "vue";
import barcode from '@/components/BarcodeView.vue'
import { Button, Card, InputGroup, InputGroupAddon, InputText } from "primevue";




const selected = ref("");
const responseData = ref({});
const search = ref("");


//API VARIABLES
const itemCategory = ref({})
const items = ref({})
//END OF API VARIABLES


const ITEM_CATEGORY_API = async () => {
    const response = await axios.get('api/tl-item-category')
    itemCategory.value = response.data
};  

const ITEMS_API = async () => {
    const response = await axios.get('api/tl-items', {
        params: {
            category: selected.value
        }
    })
   items.value = response.data
}

watch(selected, (oldVal, newVal) => {
    
    ITEMS_API()
})






onMounted(() => {
    ITEM_CATEGORY_API()
    ITEMS_API()
});
</script>

<style scoped>
.admin-inventory-list {
    max-width: 80%;
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
.category{
    display: flex;
}
select{
    padding:10px;
    border:solid 1px gray;
    border-radius: 10px;
    background: white;
}
select:active{
    border:solid 1px gray;
}
</style>
