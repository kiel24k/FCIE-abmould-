<template>
   <div class="row">
    <div class="col-1">
        <Sidebar/>
    </div>
    <div class="col">
        <Header/>
        <div class="admin-inventory-list">
            <table class="table  table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Supplier Name</th>
                        <th>Unit Cost</th>
                        <th>Quantity</th>
                        <th>Item Type</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in materialData.data" :key="index">
                        <td>{{ data.item_code }}</td>
                        <td>{{ data.supplier_name }}</td>
                        <td>{{ data.unit_cost }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ data.item_type }}</td>
                        <td>{{ data.description }}</td>
                        <td>
                            <span>
                                <router-link class="btn btn-info" :to="{name: 'admin-edit-material', params: {id: data.id} }">edit</router-link>
                                <button class="btn btn-danger" @click="deleteMaterial(data.id)">Delete</button>
                            </span>
                        </td>
                    </tr>

                </tbody>
                <Bootstrap5Pagination :data="materialData" @pagination-change-page="materialResponse"/>
            </table>
        </div>
    </div>
    <Loading v-if="loading"/>
   </div>
</template>

<script setup>
import Sidebar from '@/components/AdminSidebar.vue'
import Header from '@/components/AdminHeader.vue'
import { onMounted, ref } from 'vue';
import {Bootstrap5Pagination} from 'laravel-vue-pagination'
import Loading from '@/components/Loading.vue'

//current database table
const loading = ref(false)
const materialData = ref({})
const materialResponse = (page) => {
    loading.value = true
    axios({
        method: 'GET',
        url: `api/get-materials?page=${page}`
    }).then(response => {
        loading.value = false
        materialData.value = response.data
    })
}

//delete material
const deleteMaterial = (id) => {
    loading.value = true
    axios({
        method: 'DELETE',
        url: `api/delete-material/${id}`
    }).then(response => {
      if(response.status == 200){
        loading.value = false
        materialResponse()

      }
    })
}

onMounted(() => {
    materialResponse()
})

</script>


<style scoped>
.admin-inventory-list{
    max-width: 80%;
    margin:auto;
}
</style>
