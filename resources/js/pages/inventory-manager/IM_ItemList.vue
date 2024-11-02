<template>
  <header>
    <Header />
  </header>

  <div class="row m-2">
    <div class="col">
      <div class="table-list">
        <!-- Filter -->
        <div class="table-filter">
          <div class="category">
            <label for="">category: </label>
            <select class="form-select" v-model="selected">
              <option value="selected" disabled>Select</option>
              <option value="">all</option>
              <option value="tools">tools</option>
              <option value="materials">materials</option>
            </select>
          </div>
          <div class="search col-8">
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">
                <img src="/public/icon/search.png" width="25px" alt="" />
              </span>
              <input type="text" class="form-control" placeholder="Search" v-model="search" />
              <button class="btn btn-danger" @click="generatePdf">Print</button>
            </div>
          </div>
        </div>
        <table class="table table-hover  mt-3" ref="printContent">
          <thead>
            <tr>
              <th>#</th>
              <th @click="sort('category')">
                Category
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('barcode')">
                Barcode
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('item_code')">
                Item Code
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('brand')">
                Brand
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('supplier_name')">
                Supplier Name
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('unit_cost')">
                Unit Cost
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('quantity')">
                Quantity
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th @click="sort('description')">
                Description
                <span>{{ sorting === 'asc' ? '▲' : '▼' }}</span>
              </th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in responseData.data" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ data.category }}</td>
              <td>{{ data.barcode }}</td>
              <td>{{ data.item_code }}</td>
              <td>{{ data.brand }}</td>
              <td>{{ data.supplier_name }}</td>
              <td>{{ data.unit_cost }}</td>
              <td>{{ data.quantity }}</td>
              <td>{{ data.description }}</td>
              <td class="text-center">
                <span>
                  <button class="btn btn" @click="updateBtn(data.id)">
                    <img src="/public/icon/edit_icon_pencil.png" width="25px" alt="">
                  </button>
                  <button class="btn btn">
                    <img src="/public/icon/view_icon_eye.png" width="30px" alt="" @click="viewData(data.id)">
                  </button>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <Loading v-if="loading" />
    <itemModal v-if="viewModal" :viewModalId="itemId" @exit="viewModal = false" />
  </div>

  <div class="row m-2">
    <div class="col">
      <div class="IM-inventory-list">
        <div class="pagination">
          <Bootstrap5Pagination :data="responseData" @pagination-change-page="getItem" />
        </div>

      </div>
    </div>

  </div>
  <UpdateModal v-if="updateModal" @closeBtn="updateModal = false" :itemId="itemId" :getItem="getItem" />


</template>

<script setup>
import Header from '@/components/IM_Header.vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination'
import { onMounted, ref, watch } from 'vue';
import UpdateModal from '../../components/IM_UpdateItemModal.vue'
import itemModal from '@/components/IM_View_Modal.vue'
import html2pdf from 'html2pdf.js';


const printContent = ref(null)
const selected = ref('')
const search = ref('')
const responseData = ref({})
const viewModal = ref(false)
const itemId = ref('')
const updateModal = ref(false)
const viewModalId = ref()
const sort_column_name = ref('item_code')
const sort_order = ref('asc')
const updateBtn = (id) => {
  updateModal.value = true
  itemId.value = id
}

const getItem = (page) => {
  axios({
    method: 'GET',
    url: `/api/IM_get_item_list?category=${selected.value}&page=${page}`,
    params: {
      sort_column_name: sort_column_name.value,
      sort_order: sort_order.value
    }
  }).then(response => {
    responseData.value = response.data
  })

}

const viewData = (id) => {
  viewModal.value = true
  itemId.value = id
}
watch(selected, (oldVal, newVal) => {
  getItem()


})
watch(search, (oldVal, newVal) => {
  axios({
    method: 'GET',
    url: `/api/IM_item-search-list?category=${selected.value}&search=${search.value}`,
  }).then(response => {
    responseData.value = response.data
  })
})

const sort = (sortValue) => {
  if (sort_column_name.value === sortValue) {
    sort_order.value = sort_order.value === 'asc' ? 'desc' : 'asc'
  } else {
    sort_column_name.value = sortValue
    sort_order.value = 'asc'
  }
  getItem()
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
  getItem()
})


</script>

<style scoped>
.IM-inventory-list {
  max-width: 80%;
  margin: auto;
  background: #000;
}

.inventory-filter {
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

.pagination {
  display: grid;
  justify-content: center;
}

.table-list {
  max-width: 80%;
  margin: auto;
  background: rgb(248, 248, 240);
  padding: 5px;
  box-shadow: 0px 0px 5px 0px gray;
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

.table th {

  cursor: pointer;
  font-weight: 400;
  color: rgb(255, 255, 255);
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
  background: rgb(90, 90, 90);
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
</style>
