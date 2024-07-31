<template>
   <div class="row">
    <div class="col-1">
        <Sidebar/>
    </div>
    <div class="col">
        <Header/>
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
        <input type="text" placeholder="Search by item code" class="form-control" v-model="search">
    </div>
    <div class="create">
        <router-link :to="{name: 'admin-new-item'}" class="btn btn-success">New Item</router-link>
    </div>
</div>

            <table class="table  table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Item Code</th>
                        <th>Brand</th>
                        <th>Supplier Name</th>
                        <th>Unit Cost</th>
                        <th>Quantity</th>
                        <th>Item Type</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in responseData.data" :key="index">
                        <td>{{ data.category }}</td>
                        <td>{{ data.item_code }}</td>
                        <td>{{ data.brand }}</td>
                        <td>{{ data.supplier_name }}</td>
                        <td>{{ data.unit_cost }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ data.category }}</td>
                        <td>{{ data.description }}</td>
                        <td>
                            <span>
                                <router-link class="btn btn-info" :to="{name: 'admin-edit-item', params: {id: data.id} }">edit</router-link>
                                <button class="btn btn-danger" @click="deleteItem(data.id)">Delete</button>
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
   </div>
</template>

<script setup>
import Sidebar from '@/components/AdminSidebar.vue'
import Header from '@/components/Header.vue'
import { onMounted, ref, watch } from 'vue';
import {Bootstrap5Pagination} from 'laravel-vue-pagination'
import Loading from '@/components/Loading.vue'

//current database table
const selected = ref('')
const loading = ref(false)
const responseData = ref({})
const search = ref('')

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
</style>
