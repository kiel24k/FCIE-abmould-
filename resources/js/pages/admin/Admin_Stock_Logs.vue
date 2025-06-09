<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, Message } from 'primevue';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';
import AdminViewUserProfileModal from "@/components/Admin_View_User_Logs_Modal.vue"

const isAdminViewUserProfileModal = ref(false)
const getLogsData = ref({})
const userId = ref(null)

const API_GET_LOGS = async () => {
    await axios.get('api/get-logs').then(response => {
        getLogsData.value = response.data
    })
}

const removeLogs = (data) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, remove it!"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete('api/remove-logs', {
                params: { id: data }
            }).then(() => {
                API_GET_LOGS()
                Swal.fire("Removed!", "Remove successfully.", "success")
            })
        }
    })
}

const viewUser = (id) => {
    isAdminViewUserProfileModal.value = true
    userId.value = id
}

const closeProfileModal = () => {
    isAdminViewUserProfileModal.value = false
}

onMounted(() => {
    API_GET_LOGS()
})
</script>

<template>
    <header>
        <AdminViewUserProfileModal v-if="isAdminViewUserProfileModal" @closeProfileModal="closeProfileModal"
            :userId="userId" />
        <Header />
    </header>

    <section>
        <div class="container bg-white">
            <Message severity="contrast" icon="pi pi-ellipsis-v" size="large">
                Stock Adjustment Logs
            </Message>

            <div class="logs-wrapper">
    <div class="notif-card" v-for="(data, index) in getLogsData" :key="index">
        <div class="info">
            <div class="notif-info">
                <div class="date_and_time d-grid text-center">
                    <span>{{ data.date_released }}</span>
                    <b>{{ data.time }}</b>
                </div>

                <div class="user-info text-center">
                    <Button icon="pi pi-wrench" severity="contrast" rounded raised class="m-2"
                        v-if="data.action === 'treshold'" />
                    <Button icon="pi pi-wrench" severity="secondary" rounded raised class="m-2"
                        v-if="data.action === 'quantity'" />
                </div>

                <div class="message text-center">
                    <b>
                        {{ data.action === "treshold" ? "Managing Treshold" : "Managing Stocks" }}
                    </b>
                    <p>
                        The user named <b>"{{ data.first_name }}"</b> successfully
                        <b class="text-primary">
                            {{ data.action === "treshold" ? "Changed the Treshold" : "Changed the Stock" }}
                        </b> from Inventory
                    </p>
                </div>
            </div>

            <div class="notif_info_option text-center">
                <router-link :to="{ name: 'admin-edit-item', params: { id: data.item_id } }">
                    Edit/View this item
                </router-link>
                |
                <i class="pi pi-user m-1"></i>
                <small class="text-warning cursor-pointer" @click="viewUser(data.user_id)">Track User</small>
                |
                <Button label="Remove" icon="pi pi-trash" severity="secondary" size="small"
                    @click="removeLogs(data.id)" />
            </div>
        </div>
    </div>
</div>

        </div>
    </section>
</template>

<style scoped>
section {
    margin-top: 10px;
}

.container {
    box-shadow: 2px 10px 15px 2px gray;
    margin-top: 5rem;
    padding: 1rem;
}

.info {
    display: flex;
    justify-content: space-between;
    border: 1px rgb(177, 207, 8) solid;
    border-width: 0px 0px 1px 0px;
    background: rgb(247, 245, 245);
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 15px;
    gap: 1rem;
    flex-wrap: wrap;
}

.notif-info {
    display: flex;
    align-items: center;
    flex: 1;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.date_and_time {
    min-width: 100px;
}

.notif_info_option {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

/* Responsive layout for smaller screens */
@media (max-width: 768px) {
    .info {
        flex-direction: column;
        align-items: center;        /* Center horizontally */
        padding: 1rem;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
        border-radius: 10px;
        text-align: center;         /* Center text */
    }

    .notif-info {
        flex-direction: column;
        align-items: center;        /* Center content */
        width: 100%;
        gap: 0.75rem;
    }

    .notif_info_option {
        flex-direction: column;
        align-items: center;        /* Center buttons/links */
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .container {
        padding: 0.5rem;
    }

    .message {
        font-size: 0.95rem;
    }

    .date_and_time {
        min-width: auto;
    }
}



</style>
