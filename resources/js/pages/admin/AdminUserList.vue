<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row justify-content-center mt-5">
            <div class="col-9">
                <div class="user-list-table">
                    <div class="row">
                        <div class="col title">
                            <h2>User List</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-category">
                            <select class="form-select" style="width:max-content" v-model="selected">
                                <option value="selected" disabled>Select</option>
                                <option value="">all</option>
                                <option value="admin">admin</option>
                                <option value="member">member</option>
                                <option value="inventory-manager">inventory-manager</option>
                            </select>
                            <div class="search">
                                <input type="text" placeholder="search" v-model="search">
                                <Button disabled icon="pi pi-search" severity="contrast" variant="outlined" />
                            </div>
                            <div class="table-action">
                                <Button icon="pi pi-file-pdf" severity="danger" label="print" raised @click="generatePdf"></Button>
                                <router-link :to="{ name: 'create-user' }">
                                    <Button icon="pi pi-plus-circle" label="New" severity="info" />
                                </router-link>

                            </div>

                        </div>

                    </div>
                    <div class="row">
                       <figure class="table-main">
                        <table class="table table-striped table-hover table-responsive mt-3" ref="printContent">
                            <thead>
                                <tr>
                                    <th @click="sort('first_name')">
                                        Name
                                        <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                    </th>
                                    <th @click="sort('email')">
                                        Email
                                        <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                    </th>
                                    <th @click="sort('tel_no')">
                                        Tel Number
                                        <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                    </th>
                                    <th @click="sort('role')">
                                        Role
                                        <span>{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                    </th>

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in userList.data" :key="index">
                                    <td>
                                        <img :src="`/UserImage/${data.image}`" width="50px"
                                            height="50px" alt="">
                                        {{ data.first_name }} {{ data.last_name }}
                                    </td>
                                    <td>{{ data.email }}</td>
                                    <td>{{ data.tel_no }}</td>
                                    <td>{{ data.role }}</td>
                                    <td class="text-center">
                                        <span class="action">
                                            <router-link class="btnUpdate"
                                                :to="{ name: 'admin-update-user', params: { id: data.id } }">
                                                <Button icon="pi pi-pen-to-square" severity="success" rounded
                                                    raised />
                                            </router-link>
                                            <Button @click="deleteUser(data.id)" icon="pi pi-trash"
                                                severity="danger" rounded raised />
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                       </figure>

                            <div class="paginator text-center">

                                <nav class="btnPaginate">
                                    <Button icon="pi pi-chevron-left" severity="primary" @click="previousPage"
                                        :disabled="!pagination.prev_page_url" rounded raised />
                                    <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
                                    <Button icon="pi pi-chevron-right" rounded raised @click="nextPage"
                                        :disabled="!pagination.next_page_url" />
                                </nav>
                            </div>

                    </div>


                </div>
            </div>

    </div>
    <Loading v-if="loading" />
</template>

<script setup>
import Sidebar from '@/components/Admin_Sidebar.vue'
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import Loading from '@/components/Loading.vue'
import Button from 'primevue/button';
import html2pdf from 'html2pdf.js';
import Swal from 'sweetalert2';

const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const printContent = ref()
const loading = ref(false)
//user list pagination
const selected = ref('')
const userList = ref({})
const sortDefault = ref('first_name')
const sortOrder = ref('asc')
const pagination = ref({
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
})

const page = (page) => {
    axios.get(`api/user-list?role=${selected.value}&page=${page}`, {
        params: {
            order: sortOrder.value,
            sort: sortDefault.value
        }
    }).then(response => {
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            next_page_url: response.data.next_page_url,
            prev_page_url: response.data.prev_page_url
        }
        userList.value = response.data
    })
}

const sort = (sortValue) => {
    console.log(sortValue);
    if (sortDefault.value === sortValue) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortDefault.value = sortValue
        sortOrder.value = 'asc'
    }
    page()
}



watch(selected, (oldVal, newVal) => {
    page()
})

const search = ref('')
watch(search, (oldVal, newVal) => {
    axios({
        method: 'GET',
        url: `/api/user-list-search?role=${selected.value}&search=${search.value}`
    }).then(response => {
        userList.value = response.data
    })

    if (search.value === '') {
        page()
    }
})

//delete user
const deleteUser = async (id) => {
    const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success m-2",
    cancelButton: "btn btn-danger m-2"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel!",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
       axios.delete(`api/delete-user/${id}`).then(response => {
        page()
    })
    swalWithBootstrapButtons.fire({
      title: "Deleted!",
      text: "Delete Successful",
      icon: "success"
    });
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire({
      title: "Cancelled",
      text: "Delete Not Successful",
      icon: "error"
    });
  }
});

    // await axios.delete(`api/delete-user/${id}`).then(response => {
    //     page()

    // })
}
const prevBtn = () => {
    if (pagination.value.prev_page_url) {
        page(pagination.value.current_page - 1)

    }
}
const nextBtn = () => {
    if (pagination.value.next_page_url) {
        page(pagination.value.current_page + 1)
    }

}

const generatePdf = () => {
    const elem = printContent.value
    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();
};


onMounted(() => {
    page()
})
</script>

<style scoped>
.mt-5{
    padding-left: 10rem;
}
.table-main{
    overflow-x: scroll;
}
.user-list-table {
    display: grid;
    gap: 20px;
}

.table-action {
    display: flex;
    justify-content: end;
    gap: 15px;
    align-items: center;
    align-content: center;
}

.search input:focus {
    outline: none;
}

.search {
    display: flex;
}

.table {
    padding: 10px;
    border: solid 1px rgb(221, 219, 219);
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
.table-category{
display: flex;
align-items: center;
}
.table-category select:focus {
    outline: none;
    box-shadow: none;


}

.table table th {
    background: rgb(206, 206, 206);
}

.table table .action {
    display: flex;
    gap: 10px;
}
</style>


<!-- <style scoped>
.my-2{
    padding: 20px 40px;
}
.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}
.table{
    box-shadow: 0px 0px 5px 0px gray;
  border-radius: 10px;
}
.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;

}

.user-list-table {
    max-width: 100%;
    margin: auto;



}

.filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.category {
    display: flex;
    align-items: center;
    gap: 10px;
}

th {

    color: rgb(37, 36, 36);
    cursor: pointer;
}

.createBtn {
    background: rgb(18, 230, 18);
}

.createBtn span {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.paginator {
    display: grid;
    justify-content: center;
}

.paginateBtn {
    display: flex;
    gap: 10px;
}

.paginateBtn button {
    width: 6rem;
}
</style> -->
