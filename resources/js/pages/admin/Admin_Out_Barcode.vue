<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row">
        <div :class="isSidebarHidden ? 'col-0' : 'col-2'" :key="sidebar">
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <AdminOutModal v-if="OutModal" :reduceItemId="reduceItemId" @exit="exit" />
        <div :class="isSidebarHidden ? 'col-12' : 'col-9'" key="content">
            <div id="scanner">
                <Scanner @barcodeValue="barcodeValue" />
            </div>
            <div class="data-table">
                <table class="table table-hover table-striped mt-4">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in barcodeData " :key="index">
                            <td>{{ data.category }}</td>
                            <td>{{ data.barcode }}</td>
                            <td>{{ data.item_code }}</td>
                            <td>{{ data.brand }}</td>
                            <td>{{ data.supplier_name }}</td>
                            <td>{{ data.unit_cost }}</td>
                            <td>x{{ data.quantity }}</td>
                            <td>{{ data.description }}</td>
                            <td>
                                <span>
                                    <button class="btn btn-dark" @click="reduceItem(data.id)">Reduce Item</button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import Sidebar from '@/components/Admin_Sidebar.vue';
import Scanner from '@/components/Barcode_Scanner.vue'
import { onMounted, ref, watch } from 'vue';
import AdminOutModal from '@/components/Barcode_Out_Modal.vue'

const OutModal = ref(false)
const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};
const barcodeData = ref({})
const barcodeParams = ref('')
const barcodeValue = (data) => {
    axios({
        method: 'GET',
        url: `/api/view-scan-barcode/${data}`
    }).then(response => {
        barcodeParams.value = data
        barcodeData.value = response.data
    })
}

const updatedBarcodeValue = () => {
    axios({
        method: 'GET',
        url: `/api/view-scan-barcode/${barcodeParams.value}`
    }).then(response => {
        barcodeData.value = response.data
    })
}


const reduceItemId = ref()
const reduceItem = (id) => {
    OutModal.value = true
    reduceItemId.value = id


}
const exit = () => {
    OutModal.value = false
    updatedBarcodeValue()
}

// const barcodeValue = () => {
//     axios({
//         method: 'GET',
//         url: `/api/view-scan-barcode/{barcode}`
//     })
// }

onMounted(() => {

})

</script>

<style scoped>
.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}

.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;
}

.data-table {
    overflow-x: auto;
    width: 75rem;
    margin: auto;
}

table {
    width: 69rem;
}

.table th {
    font-weight: 400;
    color: rgb(255, 255, 255);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgb(90, 90, 90);
    padding-left: 20px
}
</style>
