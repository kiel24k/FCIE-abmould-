<template>
            <Header/>
       <div class="row">
        <div class="col-1">
            <Sidebar/>
        </div>
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
        <input type="text" placeholder="Search by item code" class="form-control" v-model="search">
    </div>
</div>

            <table class="table table-bordered table-hover table-responsive mt-3">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Item Code</th>
                        <th>Brand</th>
                        <th>Supplier Name</th>
                        <th>Unit Cost</th>
                        <th>Quantity</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data,index) in responseData.data" :key="index">
                        <td>{{ data.category }}</td>
                        <td>{{ data.item_code }}</td>
                        <td>{{ data.brand }}</td>
                        <td>{{ data.supplier_name }}</td>
                        <td>{{ data.unit_cost }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ data.description }}</td>
                    </tr>


                </tbody>
            </table>
            <div class="pagination justify-content-center">
                <Bootstrap5Pagination
                :data="responseData"
                @pagination-change-page="getItem"
                />
            </div>
        </div>
        </div>
       </div>


</template>
<script setup>
import Sidebar from '@/components/Member_Sidebar.vue'
import Header from '@/components/Header.vue'
import {Bootstrap5Pagination} from 'laravel-vue-pagination'
import { onMounted, ref, watch } from 'vue'

const selected = ref('')
const responseData = ref({})
const search = ref('')
const getItem = (page) => {
    axios({
        method: 'GET',
        url: `/api/member-get-item?category=${selected.value}&page=${page}`
    }).then(response => {
       responseData.value = response.data
    })
}


watch(selected, (oldVal, newVal) => {
    getItem()
})

watch(search,(oldVal, newVal) => {
    console.log(selected.value);

  axios({
      method: 'GET',
      url: `/api/member-item-search-list?category=${selected.value}&search=${search.value}`
  }).then(response => {
     responseData.value = response.data
  })

  if(search.value === ''){
    getItem()
  }
})

onMounted(() => {
    getItem()
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
th{
    background: rgb(22, 22, 22);
    color:white;
}
</style>
