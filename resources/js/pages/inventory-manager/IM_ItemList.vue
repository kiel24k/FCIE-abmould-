<script setup>
import Header from '@/components/IM_Header.vue'
import { onMounted, ref, watch } from 'vue';
import UpdateModal from '../../components/IM_UpdateItemModal.vue'
import itemModal from '@/components/IM_View_Modal.vue'
import html2pdf from 'html2pdf.js';
import { Button, InputGroup, InputGroupAddon, InputText, Select } from 'primevue';
import Swal from 'sweetalert2';



const printContent = ref(null)
const viewModal = ref(false)
const itemId = ref('')
const updateModal = ref(false)

//COMPONENTS VARIABLE
const category = ref('')
const search = ref('')
const sortName = ref('')
const sortBy = ref('ASC')
const pagination = ref({
  current_page: null,
  last_page: null

})

//API VARIABLE
const itemCategory = ref({})
const itemList = ref({})


//API FUNCTION
const GET_ITEM_CATEGORY_LIST = async () => {
  await axios({
    method: 'GET',
    url: 'api/IM_item_category'
  }).then(response => {
    itemCategory.value = response.data
   
  })
}

const GET_ITEM_LIST_API = async (page = 1) => {
  await axios({
    method: 'GET',
    url: `api/IM-get-item-list?page=${page}`,
    params: {
      category: category.value.release_date,
      search: search.value,
      sortName: sortName.value,
      sortBy: sortBy.value
    }
  }).then(response => {
    pagination.value = {
      current_page: response.data.current_page,
      last_page: response.data.last_page
    }
    itemList.value = response.data

  })
}

const daleteBtn =  (id) => {
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
      url: 'api/delete-item',
      data: {
        id: id
      }
    })
    Swal.fire({
      title: "Deleted!",
      text: "Item has been deleted.",
      icon: "success"
    });
  }
  GET_ITEM_LIST_API()
});

}

//COMPONENTS FUNCTION 
const clear = () => {
  search.value = ""
  category.value = ""
}

const sort = (val) => {
  sortName.value = val
  if (sortBy.value === 'DESC') {
    sortBy.value = 'ASC'
  } else {
    sortBy.value = 'DESC'
  }
  GET_ITEM_LIST_API()
}

const prevBtn = () => {
  if(pagination.value.last_page >= pagination.value.current_page){
    GET_ITEM_LIST_API(pagination.value.last_page - 1)
  }
}

const nextBtn = () => {
  if(pagination.value.current_page < pagination.value.last_page){
  GET_ITEM_LIST_API(pagination.value.current_page + 1)
  }
}



//HOOKDS
watch(category, (oldVal, newVal) => {
  GET_ITEM_LIST_API()

})

watch(search, (oldVal, newVal) => {
  GET_ITEM_LIST_API()
})


onMounted(() => {
  GET_ITEM_CATEGORY_LIST()
  GET_ITEM_LIST_API()

})

</script>

<template>
  <header>
    <Header />
  </header>
  <div class="row item_list">
    <div class="col">
      <div class="table-list">
        <!-- Filter -->
        <div class="table-filter">
          <div class="category">
            <Select placeholder="Date" :options="itemCategory" optionLabel="release_date" v-model="category" />
            <InputGroup>
              <InputText placeholder="Search..." v-model="search" />
              <InputGroupAddon>
                <i class="pi pi-search" severity="secondary" variant="text" @click="toggle" />
              </InputGroupAddon>
              <Button label="Clear" raised icon="pi pi-eraser" severity="secondary" @click="clear()"
                v-if="search || category" />
            </InputGroup>
          </div>
          <div class="search">
            <div class="input-group">
              <Button @click="generatePdf" label="Print" severity="danger" icon="pi pi-file-pdf" />
            </div>
          </div>
        </div>
        <table class="table table-hover table-bordered  mt-3" ref="printContent">
          <thead>
            <tr>
              <th>#</th>
              <th @click="sort('category')">
                Category
                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                <i class="pi pi-sort-amount-up" v-else></i>
              </th>
              <th @click="sort('item_code')">
                Item code
                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                <i class="pi pi-sort-amount-up" v-else></i>
              </th>
              <th @click="sort('unit_cost')">
                Unit cost
                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                <i class="pi pi-sort-amount-up" v-else></i>
              </th>
              <th @click="sort('quantity')">
                Quantity
                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                <i class="pi pi-sort-amount-up" v-else></i>
              </th>
              <th @click="sort('treshold')">
                Treshold
                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                <i class="pi pi-sort-amount-up" v-else></i>
              </th>
              <th @click="sort('description')">
                Description
                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'ASC'"></i>
                <i class="pi pi-sort-amount-up" v-else></i>
              </th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>

            <tr v-for="(data, index) in itemList.data" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ data.category }}</td>
              <td>{{ data.item_code }}</td>
              <td>{{ data.unit_cost }}</td>
              <td>{{ data.quantity }}x</td>
              <td>{{ data.treshold }}x</td>
              <td>{{ data.description }}</td>
              <td class="table-action">
                <Button severity="info" icon="pi pi-pen-to-square" @click="updateBtn(data.id)" raised />
                <Button severity="danger" icon="pi pi-trash" @click="daleteBtn(data.id)" raised />
                <Button severity="success" icon="pi pi-eye" raised />
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination_btn ">
          <Button label="Prev" variant="text" severity="contrast" icon="pi pi-chevron-left" @click="prevBtn()" />
          <span>{{ pagination.current_page }} of {{ pagination.last_page }}</span>
          <Button label="Next" variant="text" severity="contrast" icon="pi pi-chevron-right" iconPos="right" @click="nextBtn()" />
        </div>
      </div>
    </div>
    <Loading v-if="loading" />
    <itemModal v-if="viewModal" :viewModalId="itemId" @exit="viewModal = false" />
  </div>
  <UpdateModal v-if="updateModal" @closeBtn="updateModal = false" :itemId="itemId" :getItem="getItem" />


</template>



<style scoped>
.item_list {
  margin-top: 3.5rem;
}

.table-list {
  max-width: 80%;
  margin: auto;
  background: white;
  padding: 5px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  margin-top: 10px;

}


.table-filter {
  display: flex;
  justify-content: space-between;
  align-content: center;
  align-items: center;
}

.filter {
  display: flex;
  align-items: center;
  gap: 10px;
}

.category {
  display: flex;
  align-items: center;
  gap: 10px;
}


.table-action {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.table th {

  cursor: pointer;
  font-weight: 400;
  color: rgb(0, 0, 0);
  font-family:
    system-ui,
    -apple-system,
    BlinkMacSystemFont,
    "Segoe UI",
    Roboto,
    Oxygen,
    Ubuntu,
    Cantarell,
    "Open Sans",
    "Helvetica Neue",
    sans-serif;
}

.createButton {
  background: rgb(8, 241, 8);
}

.createButton span {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.pagination_btn {
  display: flex;
  align-items: center;
  justify-content: center;



}
</style>
