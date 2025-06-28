<template>
    <div class="view-modal">
        <div class="card">
          <div class="card-header">
            <h4>Item</h4>
            <img src="/public/icon/exit.png" width="20px" height="20px" alt="" @click="exit" style="cursor: pointer;">
          </div>
          <div class="card-body">
            <div class="item">
                <div class="row">
                  <div class="col text-start">
                    <b>Unit cost</b>
                    <h4>₱{{ item.unit_cost }}</h4>
                  </div>
                </div>
                <div class="row">
                  <b>Category:</b>  
                  <p>{{ item.category }}</p>
                </div>
                <div class="row">
                    <b>Description:</b>
                  <p>
                    {{ item.description }}
                  </p>
                </div>
                <div class="row">
                  <b>Quantity:</b>
                  <small>{{ item.quantity }}x</small>
                </div>
                <div class="row">
                  <b>Total cost:</b>
                  <small>₱{{ item.total_cost }}.00</small>
                </div>
                <div class="row" v-if="item.supplier_name">
                  <b>Supplier Name:</b>
                  <small>{{ item.supplier_name }}</small>
                </div>
                <div class="row">
                    <barcode :barcodeValue="item.item_code"/>
                </div>
              </div>
          </div>
        </div>
      </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import barcode from '@/components/BarcodeView.vue'

const emitExit = defineEmits(['exit'])
const props = defineProps(['viewModalId'])
const item = ref({})
const getItem = () => {
    axios({
        method: 'GET',
        url: `/api/view-item/${props.viewModalId}`,
    }).then(response => {
       item.value = response.data

    })
}
const exit = () => {
    emitExit('exit')
}
onMounted(() => {
    getItem()
})

</script>

<style scoped>
.view-modal {
  position: fixed;
  top: 0;
  left: 0;
  display: grid;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.5);
  height: 100%;
  width: 100%;
  z-index: 999;
  padding: 1rem;
  box-sizing: border-box;
}

.card {
  width: 100rem;
  max-width: 640px;
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #ddd;
}

.card-body {
  padding: 1rem;
  max-height: 80vh;
  overflow-y: auto;
}

.item h4 {
  color: rgb(72, 128, 231);
  font-weight: 600;
}

/* Scrollbar styling (optional) */
.card-body::-webkit-scrollbar {
  width: 6px;
}
.card-body::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.3);
  border-radius: 4px;
}

/* Responsive tweaks */
@media (max-width: 768px) {
  .card {
    max-width: 25rem;
  }

  .card-header h4 {
    font-size: 1.1rem;
  }

  .item h4 {
    font-size: 1rem;
  }
}

</style>
