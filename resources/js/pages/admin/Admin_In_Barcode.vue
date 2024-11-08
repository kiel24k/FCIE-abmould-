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
                                    <Button label="Add" severity="contrast" icon="pi pi-plus" @click="addQuantityModal(data.item_id)"/>
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
import { computed, onMounted, ref, watch } from 'vue';
import Swal from 'sweetalert2';
import Button from 'primevue/button';

const inModal = ref(false)
const inModalId = ref()
const notFound = ref(false)
const barcodeResponse = ref([])
const userInformation = ref({})
const getScannedItems = ref()
const newItem = ref([])

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
        console.log("data:", data);

        newItem.value = response.data[0];
        if (newItem.value && !barcodeResponse.value.some(item => item.item_code === newItem.value.item_code)) {
            barcodeResponse.value.push(newItem.value);
            console.log("barcodeRespone:", barcodeResponse.value);
            console.log("newItem: ", newItem.value);
        }
        notFound.value = barcodeResponse.value.length === 0;
    }).catch(error => {
        console.error("Error fetching barcode data:", error);
        notFound.value = true;
    });
};

const user = (data) => {
    userInformation.value = data
    GET_SCANNED_ITEMS_API()
}

const GET_SCANNED_ITEMS_API = async () => {
    const response = await axios.get(`/api/get-scanned-items/${userInformation.value.id}`);
    getScannedItems.value = Array.from(new Set(response.data.map(item => item.item_code)))
        .map(code => response.data.find(item => item.item_code === code));
    // console.log("getScannedItems", getScannedItems.value);     
};
watch(newItem, async () => {
    try {
        const response = await axios.post('api/save-scanned-items', {
            user_id: userInformation.value.id,
            item_id: newItem.value.id,
            category: newItem.value.category,
            item_code: newItem.value.item_code,
            brand: newItem.value.brand,
            supplier_name: newItem.value.supplier_name,
            unit_cost: newItem.value.unit_cost,
            quantity: newItem.value.quantity,
            description: newItem.value.description
        });

        GET_SCANNED_ITEMS_API();
    } catch (error) {
        if (error.response.status === 422) {
            Swal.fire({
                title: "Item Existed",
                text: "Please use other Item",
                icon: "question"
            });
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
    GET_SCANNED_ITEMS_API()

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
