<script setup>
import Header from '@/components/TL_Header.vue'
import { Button, Message, Select } from 'primevue'
import { onMounted, ref, watch } from 'vue'
import AdminApproveModal from '@/components/Admin_Approve_Modal.vue'
import AdminNotApproveModal from '@/components/Admin_Not_Approve_Modal.vue'
import Swal from 'sweetalert2'


//COMPONENTS VARIABLES 
const categoryStatus = ref('')
const isAdminApprovalModal = ref(false)
const isAdminNotApproveModal = ref(false)
const notApproveData = ref({})
const approveData = ref({})

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

//HOOKS
watch(categoryStatus, (oldVal, newVal) => {
    GET_SCHEDULE_REQUEST_API()
})
onMounted(() => {
    GET_SCHEDULE_REQUEST_API()
})


</script>

<template>
    
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
                            </div>
                        </td>
                        <td>{{ data.schedule_date }}</td>
                        <td>{{ data.schedule_quantity }}x</td>
                        <td class="table_status">
                            <span :style="data.status === 'pending' ? 'background-color: orange'
                             : data.status === 'released' ? 'background-color: rgb(37, 102, 235)' 
                             :data.status === 'not-release' ? 'background-color: rgb(221, 48, 41)'
                             : 'background-color: white;'
                             ">
                                {{ data.status }}
                            </span>
                        </td>
                        <td class="table_data_action">
                            <div class="table_action">
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
    margin-top: 4rem;
    margin-left: 3.5rem;
    display: grid;
    gap: 15px;
}

.table figure {
    display: flex;
    gap: 5px;
}

.table figure img {
    border-radius: 100%;
    width: 50px;
    height: 50px;
}

.user_name {
    display: grid;
}

.table_item {
    display: grid;
}

.table_data_action {
    width: 20rem;
}

.table_item a{
    display: flex;
    align-items: center;
    justify-content: space-between;

    
}
.table_action {
    display: flex;
    gap: 10px;
}
.table_status span{
    padding: 7px;
    border-radius: 50px;
    font-weight: bold;
    color:rgb(241, 239, 239);
}
</style>