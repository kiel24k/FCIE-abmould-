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
    top:0;
    display: grid;
    justify-content: center;
    align-items: center;
    background-color: rgb(0, 0, 0,0.5);
    height: 100%;
    width: 100%;
    z-index:999;
  }
  .card-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .card-body{
    height: auto;
  }

  .item {
    width: 40rem;
    background: rgb(255, 255, 255);
    height: auto;
    overflow: scroll;
    overflow-x: hidden;
    box-shadow: 0px 0px 5px 0px black;
    padding: 10px;
    border-radius: 5px;
  }
  .item::-webkit-scrollbar {
    width: 5px;
    height: 25px;
  }
  .item::-webkit-scrollbar-track {
    border-radius: 15px;
    background: rgb(192, 191, 191);
  }
  .item::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(26, 25, 25, 0.5);
  }

  .item h4 {
    color: rgb(72, 128, 231);
    font-weight: 600;
  }
  .title {
    display: flex;
    justify-content: space-between;
  }
</style>
