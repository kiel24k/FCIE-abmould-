<script setup>
import Header from '@/components/IM_Header.vue'
import { Button, Message, Select } from 'primevue'
import { onMounted, ref, watch } from 'vue'
import AdminApproveModal from '@/components/Admin_Approve_Modal.vue'
import AdminNotApproveModal from '@/components/Admin_Not_Approve_Modal.vue'
import Swal from 'sweetalert2'
import UpdateModal from '../../components/IM_UpdateItemModal.vue'


//COMPONENTS VARIABLES 
const categoryStatus = ref('')
const isAdminApprovalModal = ref(false)
const isAdminNotApproveModal = ref(false)
const notApproveData = ref({})
const approveData = ref({})
const itemId = ref()
const isUpdateModal = ref(false)

//API VARIABLES
const scheduleRequestData = ref({})
const category = ref({})
//API FUNCTIONS
const GET_SCHEDULE_REQUEST_API = async () => {
    await axios({
        method: 'GET',
        url: '/api/get-schedule-request',
        params: {
            category: categoryStatus.value.status
        }
    }).then(response => {
        category.value = response.data.status
        console.log(response.data);
        scheduleRequestData.value = response.data.data
    })
}

//COMPONENTS FUNCTION
const approve = (data) => {
    isAdminApprovalModal.value = true
    approveData.value = data
}

const closeApproveModal = () => {
    isAdminApprovalModal.value = false
    GET_SCHEDULE_REQUEST_API()
}

const notApprove = (data) => {
    isAdminNotApproveModal.value = true
    notApproveData.value = data
}
const closeNotApproveModal = () => {
    isAdminNotApproveModal.value = false
    GET_SCHEDULE_REQUEST_API()
}

const deleteBtn = (id) => {

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            axios({
                method: 'DELETE',
                url: '/api/delete-schedule-request',
                params: {
                    schedule_id: id
                }
            }).then(response => {
                if (response.status === 200) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Data has been deleted.",
                        icon: "success"
                    });
                    GET_SCHEDULE_REQUEST_API()
                }

            })

        }
    });

}

const UpdateItemModal = (id) => {
  itemId.value = id
  isUpdateModal.value = true
}

//HOOKS
watch(categoryStatus, (oldVal, newVal) => {
    GET_SCHEDULE_REQUEST_API()
})
onMounted(() => {
    GET_SCHEDULE_REQUEST_API()
})


</script>

<template>
  <UpdateModal v-if="isUpdateModal" @closeBtn="isUpdateModal = false" :itemId="itemId" :getItem="getItem" />
    <AdminNotApproveModal v-if="isAdminNotApproveModal" @closeNotApproveModal="closeNotApproveModal"
        :notApproveData="notApproveData" />
    <AdminApproveModal v-if="isAdminApprovalModal" @closeApproveModal="closeApproveModal" :approveData="approveData" />
    <header>
        <Header />
    </header>


    <div class="main">
        <section>
            <Select placeholder="Select status" :options="category" optionLabel="status" v-model="categoryStatus" />
            <Button severity="secondary" label="Clear filter" raised @click="categoryStatus = ''" />
        </section>
        <section>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Item</th>
                        <th>Schedule date</th>
                        <th>Request quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in scheduleRequestData">
                        <td>
                            <figure>
                                <img :src="`/UserImage/${data.image}`" alt="">
                                <div class="user_name">
                                    <span>{{ data.first_name }} {{ data.middle_name }} {{ data.last_name }}</span>
                                    <b>{{ data.role }}</b>
                                </div>
                            </figure>
                        </td>
                        <td>
                            <div class="table_item">
                                <span>{{ data.category }}</span>
                                <span>{{ data.item_code }}</span>
                                <span>{{ data.brand }}</span>
                                <a @click="UpdateItemModal(data.item_id)">
                                    <span>View this item</span>
                                    <i class="pi pi-arrow-right" style="font-size: 10px"></i>
                                </a>

                            </div>
                        </td>
                        <td>{{ data.schedule_date }}</td>
                        <td>{{ data.schedule_quantity }}x</td>
                        <td class="table_status">
                            <b> {{ data.status }}</b>
                            <!-- <span :style="data.status === 'pending' ? 'background-color: orange'
                             : data.status === 'released' ? 'background-color: rgb(37, 102, 235)' 
                             :data.status === 'not-release' ? 'background-color: rgb(221, 48, 41)'
                             : 'background-color: white;'
                             ">
                                {{ data.status }}
                            </span> -->
                        </td>
                        <td class="table_data_action">
                            <div class="table_action">
                                <Button label="Not approve" severity="danger" icon="pi pi-times" raised
                                    @click="notApprove(data)" v-if="data.status === 'pending'" />
                                <Button icon="pi pi-trash" raised severity="danger"
                                    v-if="data.status === 'not-release' || data.status === 'released'"
                                    @click="deleteBtn(data.schedule_id)" />
                                <Button label="Approve" severity="success" icon="pi pi-check" raised
                                    @click="approve(data)" v-if="data.status === 'pending'" />
                                <Message severity="error" v-if="data.status === 'not-release'">Not approve</Message>
                                <Message v-if="data.status === 'released'">Approved</Message>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

    </div>



</template>

<style scoped>
.main {
    margin-top: 5rem;
    margin-left: 3.5rem;
    padding-right: 1rem;
    display: grid;
    gap: 15px;
}

.filter-section {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-controls {
    display: flex;
    gap: 10px;
    align-items: center;
}

.table-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.table-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table {
    width: 100%;
    min-width: 1000px;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
    vertical-align: top;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    position: sticky;
    top: 0;
    z-index: 10;
}

.table figure {
    display: flex;
    gap: 8px;
    align-items: center;
}

.table figure img {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    object-fit: cover;
    flex-shrink: 0;
}

.user_name {
    display: flex;
    flex-direction: column;
    min-width: 120px;
}

.user_name span {
    font-size: 14px;
    font-weight: 500;
}

.user_name b {
    font-size: 12px;
    color: #6c757d;
    font-weight: 400;
}

.table_item {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 150px;
}

.table_item span {
    font-size: 13px;
}

.table_item a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #007bff;
    text-decoration: none;
    font-size: 12px;
    margin-top: 4px;
}

.table_item a:hover {
    text-decoration: underline;
}

.action-cell {
    min-width: 250px;
}

.table_action {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

.action-btn {
    font-size: 12px;
    padding: 6px 12px;
}

.status-message {
    font-size: 11px;
    padding: 4px 8px;
}

.table_status b {
    font-size: 13px;
    color: #495057;
}

/* Mobile Styles */
@media (max-width: 768px) {

    .main {
        margin-left: 1rem;
        padding-right: 0.5rem;
        margin-top: 5rem;
    }
    
    .filter-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    
    .table {
        min-width: 800px;
        font-size: 12px;
    }
    
    .table th,
    .table td {
        padding: 8px;
    }
    
    .table figure img {
        width: 35px;
        height: 35px;
    }
    
    .user_name {
        min-width: 100px;
    }
    
    .user_name span {
        font-size: 12px;
    }
    
    .user_name b {
        font-size: 10px;
    }
    
    .table_item {
        min-width: 120px;
    }
    
    .table_item span {
        font-size: 11px;
    }
    
    .action-cell {
        min-width: 200px;
    }
    
    .action-btn {
        font-size: 10px;
        padding: 4px 8px;
    }
    
    .table_action {
        gap: 6px;
    }
    
    .status-message {
        font-size: 9px;
        padding: 2px 6px;
    }
}

/* Tablet Styles */
@media (max-width: 1024px) and (min-width: 769px) {
    .main {
        margin-left: 2rem;
        margin-top:5rem;
    }
    
    .table {
        min-width: 900px;
    }
    
    .table th,
    .table td {
        padding: 10px;
    }
    
    .action-cell {
        min-width: 220px;
    }
}

/* Small Mobile Styles */
@media (max-width: 480px) {
    .main {
        margin-left: 0.5rem;
        padding-right: 0.5rem;
        margin-top:5rem;
    }
    
    .filter-section,
    .table-section {
        margin: 0 -0.5rem;
        border-radius: 0;
    }
    
    .table {
        min-width: 700px;
        font-size: 11px;
    }
    
    .table th,
    .table td {
        padding: 6px;
    }
    
    .table figure {
        gap: 6px;
    }
    
    .table figure img {
        width: 30px;
        height: 30px;
    }
    
    .user_name {
        min-width: 80px;
    }
    
    .user_name span {
        font-size: 11px;
    }
    
    .user_name b {
        font-size: 9px;
    }
    
    .table_item {
        min-width: 100px;
    }
    
    .table_item span {
        font-size: 10px;
    }
    
    .action-cell {
        min-width: 180px;
    }
    
    .action-btn {
        font-size: 9px;
        padding: 3px 6px;
    }
    
    .table_action {
        gap: 4px;
    }
}

/* Very Small Screens */
@media (max-width: 360px) {
    .table {
        min-width: 600px;
        font-size: 10px;
    }
    
    .table th,
    .table td {
        padding: 4px;
    }
    
    .action-cell {
        min-width: 160px;
    }
    
    .action-btn {
        font-size: 8px;
        padding: 2px 4px;
    }
    .main{
        margin-top:10rem;
    }
}
</style>