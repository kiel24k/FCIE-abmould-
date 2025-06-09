<script setup>
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import Loading from '@/components/Loading.vue'
import Button from 'primevue/button';
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';
import { InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import ViewUserModal from '@/components/Admin_View_User_Modal.vue'
import PrintUserList from '@/components/Print_User_List.vue'

const router = useRouter()
const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const printContent = ref()
const loading = ref(false)

// COMPONENTS VARIABLE
const category = ref("")
const search = ref("")
const sortName = ref("")
const sortOrder = ref("ASC")
const isViewUserModal = ref(false)
const viewUserModalId = ref(null)
const isPrintModal = ref(false)
const tableData = ref({})

// API VARIABLE
const userListCategoryData = ref([])
const userListData = ref({ data: [] })
const pagination = ref({
    current_page: 1,
    last_page: 1
})

// API FUNCTION
const GET_USER_LIST_CATEGORY_API = async () => {
    try {
        const response = await axios.get('api/user-list-category');
        userListCategoryData.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const GET_USER_LIST_API = async (page = 1) => {
    loading.value = true;
    try {
        const response = await axios.get(`api/user-list?page=${page}`, {
            params: {
                category: category.value,
                search: search.value,
                sortName: sortName.value,
                sortOrder: sortOrder.value
            }
        });
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page
        }
        userListData.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

const DELETE_USER_API = async (id) => {
    try {
        await axios.delete('api/delete-user', { params: { id } });
    } catch (error) {
        console.error(error);
    }
}

// COMPONENTS FUNCTION

const print = () => {
    isPrintModal.value = true;
    tableData.value = userListData.value.data;
}

const closeUserListModal = () => {
    isPrintModal.value = false;
}

const sort = (field) => {
    if (sortName.value === field) {
        sortOrder.value = sortOrder.value === 'ASC' ? 'DESC' : 'ASC';
    } else {
        sortName.value = field;
        sortOrder.value = 'ASC';
    }
    GET_USER_LIST_API();
}

const prev = () => {
    if (pagination.value.current_page > 1) {
        GET_USER_LIST_API(pagination.value.current_page - 1);
    }
}

const next = () => {
    if (pagination.value.current_page < pagination.value.last_page) {
        GET_USER_LIST_API(pagination.value.current_page + 1);
    }
}

const update = (id) => {
    router.push(`/admin-update-user/${id}`);
}

const view = (id) => {
    isViewUserModal.value = true;
    viewUserModalId.value = id;
}

const closeViewUserModal = () => {
    isViewUserModal.value = false;
    GET_USER_LIST_API();
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
    }).then(async (result) => {
        if (result.isConfirmed) {
            await DELETE_USER_API(id);
            Swal.fire({
                title: "Deleted!",
                text: "Data has been deleted.",
                icon: "success"
            });
            GET_USER_LIST_API();
        }
    });
}

// WATCHERS
watch(category, () => {
    GET_USER_LIST_API();
})

watch(search, () => {
    GET_USER_LIST_API();
})

onMounted(() => {
    GET_USER_LIST_CATEGORY_API();
    GET_USER_LIST_API();
})
</script>

<template>
    <PrintUserList v-if="isPrintModal" :tableData="tableData" @closeUserListModal="closeUserListModal" />
    <header>
        <ViewUserModal v-if="isViewUserModal" :viewUserModalId="viewUserModalId" @closeViewUserModal="closeViewUserModal" />
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-9 mt-4">
            <div class="user-list-table">
                <div class="row mb-2">
                    <div class="col title">
                        <Message severity="info">
                            <h2>User List</h2>
                        </Message>
                    </div>
                </div>
                <div class="row bg-white p-3 rounded shadow-sm">
                    <div class="col table_filter_action d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                        <div class="list_filter d-flex flex-wrap gap-3 align-items-center flex-grow-1">
                            <Select placeholder="Select role" :options="userListCategoryData" optionLabel="role" v-model="category" class="flex-grow-1" />
                            <InputGroup class="flex-grow-1" style="max-width: 300px;">
                                <InputText placeholder="Search..." v-model="search" />
                                <InputGroupAddon>
                                    <Button icon="pi pi-search" severity="secondary" variant="text" @click="GET_USER_LIST_API()" />
                                </InputGroupAddon>
                            </InputGroup>
                        </div>
                        <div class="list_action d-flex gap-2 flex-wrap">
                            <router-link :to="{ name: 'create-user' }">
                                <Button label="Add user" icon="pi pi-plus" severity="info" />
                            </router-link>
                            <Button label="Export" icon="pi pi-file-pdf" severity="contrast" raised @click="print()" />
                        </div>
                    </div>

                    <figure class="table-main w-100 overflow-auto">
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th style="min-width: 40px;">#</th>
                                    <th style="min-width: 60px;">Profile</th>
                                    <th style="min-width: 120px; cursor:pointer" @click="sort('first_name')">
                                        First name
                                        <i class="pi" :class="sortName === 'first_name' ? (sortOrder === 'ASC' ? 'pi-sort-amount-down-alt' : 'pi-sort-amount-up') : ''"></i>
                                    </th>
                                    <th style="min-width: 120px; cursor:pointer" @click="sort('middle_name')">
                                        Middle name
                                        <i class="pi" :class="sortName === 'middle_name' ? (sortOrder === 'ASC' ? 'pi-sort-amount-down-alt' : 'pi-sort-amount-up') : ''"></i>
                                    </th>
                                    <th style="min-width: 120px; cursor:pointer" @click="sort('last_name')">
                                        Last name
                                        <i class="pi" :class="sortName === 'last_name' ? (sortOrder === 'ASC' ? 'pi-sort-amount-down-alt' : 'pi-sort-amount-up') : ''"></i>
                                    </th>
                                    <th style="min-width: 180px; cursor:pointer" @click="sort('email')">
                                        Email
                                        <i class="pi" :class="sortName === 'email' ? (sortOrder === 'ASC' ? 'pi-sort-amount-down-alt' : 'pi-sort-amount-up') : ''"></i>
                                    </th>
                                    <th style="min-width: 140px; cursor:pointer" @click="sort('tel_no')">
                                        Tel Number
                                        <i class="pi" :class="sortName === 'tel_no' ? (sortOrder === 'ASC' ? 'pi-sort-amount-down-alt' : 'pi-sort-amount-up') : ''"></i>
                                    </th>
                                    <th style="min-width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in userListData.data" :key="data.id">
                                    <td>{{ (pagination.current_page - 1) * 10 + index + 1 }}</td>
                                    <td>
                                        <img :src="`/UserImage/${data.image}`" width="50" height="50" alt="User Profile" style="object-fit: cover; border-radius: 50%;" />
                                    </td>
                                    <td>{{ data.first_name }}</td>
                                    <td>{{ data.middle_name }}</td>
                                    <td>{{ data.last_name }}</td>
                                    <td>{{ data.email }}</td>
                                    <td>{{ data.tel_no }}</td>
                                    <td>
                                        <div class="table_action d-flex gap-1 flex-wrap justify-content-center">
                                            <Button icon="pi pi-pencil" severity="info" raised @click="update(data.id)" />
                                            <Button icon="pi pi-eye" severity="success" raised @click="view(data.id)" />
                                            <Button icon="pi pi-trash" severity="danger" raised @click="deleteBtn(data.id)" />
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="paginate_class d-flex justify-content-center align-items-center gap-3 mt-3 flex-wrap">
                            <Button label="Prev" icon="pi pi-chevron-left" variant="text" severity="contrast" @click="prev()" :disabled="pagination.current_page <= 1" />
                            <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
                            <Button label="Next" icon="pi pi-chevron-right" iconPos="right" variant="text" severity="contrast" @click="next()" :disabled="pagination.current_page >= pagination.last_page" />
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <Loading v-if="loading" />
</template>

<style scoped>
.list_action {
  display: flex;
  gap: 10px;
  flex-wrap: nowrap;
  align-items: center;
  justify-content: center;
}

@media (max-width: 768px) {
  .list_action > * {
    width: 100%;
  }

  .list_filter {
    flex-direction: column;
    gap: 0.75rem;
    align-items: stretch;
  }

  /* Make table horizontally scrollable on small screens */
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  table {
    font-size: 0.85rem;
    min-width: 800px;
  }

  th, td {
    white-space: nowrap;
    padding: 0.4rem 0.5rem;
  }

  .table_action {
    flex-direction: row;
    gap: 0.25rem;
    flex-wrap: wrap;
    justify-content: center;
  }

  .paginate_class {
    flex-direction: column;
    gap: 0.5rem;
  }

  .paginate_class span {
    font-size: 0.9rem;
  }
}

.list_filter {
  display: flex;
  gap: 10px;
  flex-wrap: nowrap;
  align-items: center;
}

@media (max-width: 768px) {
  .list_filter {
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
  }
}

.paginate_class {
  display: flex;
  gap: 10px;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 1rem;
}

.table_action {
  display: flex;
  gap: 5px;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: center;
}
</style>
