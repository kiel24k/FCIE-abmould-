<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" @user="user" />
    </header>
    <div class="row">
        <div :class="isSidebarHidden ? 'col-0' : 'col-2'" :key="sidebar">
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <InModal v-if="inModal" :barcodeValue="barcodeValue" :inModalId="inModalId" @exit="exit" />
        <div :class="isSidebarHidden ? 'col-12' : 'col-9'" key="content">
            <div id="scanner">
                <Scanner @barcodeValue="barcodeValue" />
            </div>
            <div class="data-table mt-4">
                <div class="text-start">
                    <router-link :to="{ name: 'admin-inventory-list' }" class="btn btn-primary mb-2">Item
                        List</router-link>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <b>Scanned Items</b>
                    </div>
                </div>
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Item Code</th>
                            <th>Brand</th>
                            <th>Supplier Name</th>
                            <th>Unit Cost</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in getScannedItems" :key="index">
                            <td>{{ data.category }}</td>
                            <td>{{ data.item_code }}</td>
                            <td>{{ data.brand }}</td>
                            <td>{{ data.supplier_name }}</td>
                            <td>{{ data.unit_cost }}</td>
                            <td>{{ data.description }}</td>
                            <td>
                                <span>
                                    <button class="btn btn-dark" @click="addQuantityModal(data.item_id)">Add
                                        Quantity</button>
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="text-center" v-if="notFound">
                    <h4>No data found</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import Sidebar from '@/components/Admin_Sidebar.vue';
import Scanner from '@/components/Barcode_Scanner.vue'
import InModal from '@/components/Barcode_In_Modal.vue'
import { onMounted, ref, watch } from 'vue';

const inModal = ref(false)
const inModalId = ref()
const notFound = ref(false)
const barcodeResponse = ref([])
const userInformation = ref()
const getScannedItems = ref()

const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

// Function to add only unique items to barcodeResponse
const barcodeValue = (data) => {
    axios({
        method: 'GET',
        url: `/api/view-scan-barcode/${data}`
    }).then(response => {
        const newItem = response.data[0];

        if (newItem && !barcodeResponse.value.some(item => item.item_code === newItem.item_code)) {
            barcodeResponse.value.push(newItem);
        }

        notFound.value = barcodeResponse.value.length === 0;
    }).catch(error => {
        console.error("Error fetching barcode data:", error);
        notFound.value = true;
    });
};

const GET_SCANNED_ITEMS_API = async () => {
    const response = await axios.get(`/api/get-scanned-items/${userInformation.value.id}`);
    getScannedItems.value = Array.from(new Set(response.data.map(item => item.item_code)))
        .map(code => response.data.find(item => item.item_code === code));
};

watch(barcodeResponse.value, async () => {
    if (barcodeResponse.value.length > 0) {
        try {
            await axios.post('api/save-scanned-items', {
                id: userInformation.value.id,
                data: barcodeResponse.value
            });
            GET_SCANNED_ITEMS_API();
        } catch (error) {
            console.error("Error saving scanned items:", error);
        }
    }
});


const addQuantityModal = (id) => {
    inModal.value = true
    inModalId.value = id

}

const exit = () => {
    inModal.value = false
    GET_SCANNED_ITEMS_API()

}

onMounted(async () => {


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
    width: 69rem;
    margin: auto;
}

table {
    width: 69rem;
}

.table th {
    color: rgb(255, 255, 255);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgb(90, 90, 90);
}
</style>
