<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" @user="user" />
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
                <div class="text-start">
                    <router-link :to="{ name: 'admin-inventory-list' }" class="btn btn-primary mb-2">Item
                        List</router-link>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <b>Scanned Items</b>
                    </div>
                </div>
                <table class="table table-hover table-striped">
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
                        <tr v-for="(data, index) in getScannedItems " :key="index">
                            <td>{{ data.category }}</td>
                            <td>{{ data.item_code }}</td>
                            <td>{{ data.brand }}</td>
                            <td>{{ data.supplier_name }}</td>
                            <td>{{ data.unit_cost }}</td>
                            <td>{{ data.description }}</td>
                            <td>
                                <span>
                                    <Button label="Reduce" icon="pi pi-minus" severity="contrast" @click="reduceItem(data.item_id)"/>
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
import Swal from 'sweetalert2';
import Button from 'primevue/button';

const OutModal = ref(false)
const isSidebarHidden = ref(false);
const barcodeResponse = ref([]) // Array to store unique scanned items
const userInformation = ref()
const getScannedItems = ref()
const reduceItemId = ref()
const newItem = ref([])

const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const barcodeValue = (data) => {
    axios.get(`/api/view-scan-barcode/${data}`)
        .then(response => {
            newItem.value = response.data[0];
            if (newItem.value && !barcodeResponse.value.some(item => item.item_code === newItem.value.item_code)) {
                barcodeResponse.value.push(newItem.value);
                console.log("barcodeRespone:", barcodeResponse.value);
                console.log("newItem: ", newItem.value);
            }
        })
        .catch(error => console.error("Error fetching barcode data:", error));
};

const user = (d) => {
    userInformation.value = d;
    GET_SCANNED_ITEMS_API();
};

// Fetch and remove duplicates from scanned items
const GET_SCANNED_ITEMS_API = async () => {
    const response = await axios.get(`/api/get-scanned-items-out/${userInformation.value.id}`);
    getScannedItems.value = Array.from(new Set(response.data.map(item => item.item_code)))
        .map(code => response.data.find(item => item.item_code === code));
};

watch(barcodeResponse.value, async () => {
    if (barcodeResponse.value.length > 0) {
        try {
            await axios.post('api/save-scanned-items-out', {
                id: userInformation.value.id,
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
            GET_SCANNED_ITEMS_API(); // Refresh after saving
        } catch (error) {
            console.log(error.response.status);
            if (error.response.status === 422) {
                Swal.fire({
                    title: "Item Existed",
                    text: "Please use other Item",
                    icon: "question"
                });
            }
        }
    }
});

// Show reduction modal and pass the item id
const reduceItem = (id) => {
    OutModal.value = true;   
    reduceItemId.value = id;
};

// Close modal and refresh scanned items
const exit = () => {
    OutModal.value = false;
    GET_SCANNED_ITEMS_API();
};

onMounted(() => {

});

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
    width: 80rem;
}

.table th {
    color: rgb(255, 255, 255);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgb(90, 90, 90);
}
</style>
