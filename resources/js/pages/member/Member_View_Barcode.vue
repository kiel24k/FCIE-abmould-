<template>
    <header>
        <Header/>
    </header>
    <div>
        <div id="scanner">
            <Scanner @barcodeValue="barcodeValue"/>
        </div>
        <div class="data-table mt-4">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Barcode</th>
                        <th>Item Code</th>
                        <th>Brand</th>
                        <th>Supplier Name</th>
                        <th>Unit Cost</th>
                        <th>Quantity</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in barcodeResponse" :key="index">
                        <td>{{ data.category }}</td>
                        <td>{{ data.barcode }}</td>
                        <td>{{ data.item_code }}</td>
                        <td>{{ data.brand }}</td>
                        <td>{{ data.supplier_name }}</td>
                        <td>{{ data.unit_cost }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ data.description }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="notFound">
                <h4>No data found</h4>
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from '@/components/Member_Header.vue'
import Scanner from '@/components/Barcode_Scanner.vue'
import { onMounted, ref, watch } from 'vue';

const notFound = ref(false)
const barcodeResponse = ref(null)
const barcodeValue = (data) => {
   axios({
    method: 'GET',
    url: `/api/view-scan-barcode/${data}`
   }).then(response => {
        barcodeResponse.value = response.data
        if(barcodeResponse.value == ''){
            notFound.value = true
        }else{
            notFound.value = false
        }

   })
}
onMounted(() => {

})
</script>

<style scoped>
.data-table{
    overflow-x: auto;
    width: 75rem;
    margin:auto;
}
table{
    width: 75rem;
}
    .table th{
        font-weight: 400;
        color:rgb(255, 255, 255);
        font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        background: rgb(90, 90, 90);
    }

    </style>
