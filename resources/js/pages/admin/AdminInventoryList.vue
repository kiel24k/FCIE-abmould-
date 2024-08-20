<template>
    <header>
        <Header/>
    </header>
   <div class="row m-2">
    <div class="col">
        <div class="admin-inventory-list">
<!-- Filter -->
<div class="inventory-filter">
    <div class="category">
        <label for="">category: </label>
        <select class="form-select" v-model="selected">
            <option value="selected" disabled>Select</option>
            <option value=""> all </option>
            <option value="tools">tools</option>
            <option value="materials">materials</option>
        </select>
    </div>
    <div class="search col-8">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">
                <img src="/public/icon/search.png" width="25px" alt="">
            </span>
            <input type="text" class="form-control" placeholder="Search" v-model="search">
          </div>
    </div>
    <div class="create">
        <router-link :to="{name: 'admin-new-item'}" class="btn createButton">
            <span>
                <img src="/public/icon/add_icon_plus.png" width="15px" alt="">
                <b>Add Item</b>
            </span>
        </router-link>
    </div>
</div>
            <table class="table table-hover table-striped mt-3">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Barcode</th>
                        <th>Item Code</th>
                        <th>Brand</th>
                        <th>Supplier Name</th>
                        <th>Unit Cost</th>
                        <th>Quantity</th>
                        <th>Item Type</th>
                        <th>Description</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in responseData.data" :key="index">
                        <td>{{ data.category }}</td>
                        <td>{{ data.barcode }}</td>
                        <td>{{ data.item_code }}</td>
                        <td>{{ data.brand }}</td>
                        <td>{{ data.supplier_name }}</td>
                        <td class="text-success">{{ data.unit_cost }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ data.category }}</td>
                        <td>{{ data.description }}</td>
                        <td class="text-center">
                            <span>
                                <button class="btn btn" @click="deleteItem(data.id)">
                                    <img src="/public/icon/trash_icon.png" width="30px" alt="">
                                </button>
                                <router-link class="btn btn" :to="{name: 'admin-edit-item', params: {id: data.id} }">
                                    <img src="/public/icon/edit_icon_pencil.png" width="30px" alt="">
                                </router-link>
                                <button class="btn btn" @click="view(data.id)">
                                    <img src="/public/icon/view_icon_eye.png" width="30px" alt="">
                                </button>
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="pagination justify-content-center">
                <Bootstrap5Pagination
                :data="responseData"
                @pagination-change-page="category"
                />
            </div>
        </div>
    </div>
    <Loading v-if="loading"/>
    <!-- <AdminViewModal v-if="viewModal" :viewModalId="viewModalId" @exit = "viewModal = false" /> -->
   </div>
</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import {Bootstrap5Pagination} from 'laravel-vue-pagination'
// import AdminViewModal from '@/components/Admin_View_Modal.vue'
import Loading from '@/components/Loading.vue'

//current database table
const selected = ref('')
const loading = ref(false)
const responseData = ref({})
const search = ref('')
const viewModal = ref(false)
const viewModalId = ref(null)

// data per category
const category = async(page) => {
     axios({
        method: 'GET',
        url: `/api/item-category?category=${selected.value}&page=${page}`,
     }).then(response => {
        loading.value = false
        responseData.value = response.data
     })
}
 watch(selected,(oldVal, newVal) => {
    category()
})

 watch(search, (oldVal, newVal) => {
        axios({
        method: 'GET',
        url: `/api/items-search?category=${selected.value}&search=${search.value}`
     }).then(response => {
        responseData.value = response.data
     })
     if(search.value === ''){
        category()
     }
})

const view = (id) => {
    viewModal.value = true
    viewModalId.value = id

}
//delete item
const deleteItem = (id) => {
    loading.value = true
    axios({
        method: 'DELETE',
        url: `api/delete-item/${id}`
    }).then(response => {
      if(response.status == 200){
        loading.value = false
        category()
      }
    })
}

onMounted(() => {
        category()
})

</script>


<style scoped>
.admin-inventory-list{
    max-width: 80%;
    margin:auto;
}
.inventory-filter{
    display: flex;
    justify-content: space-between;
    align-content: center;
    align-items: center;
}
.filter {
    display:flex;
    align-items: center;
    gap:10px;
}
.category{
    display: flex;
    align-items: center;
    gap:10px;
}

.table th{
    font-weight: 400;
    color:rgb(255, 255, 255);
    font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgb(90, 90, 90);
}
.createButton{
    background: rgb(8, 241, 8);
}
.createButton span{
    display: flex;
    justify-content: center;
    align-items: center;
    gap:10px;

}

</style>
