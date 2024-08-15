<template>
    <Header />
    <div class="row m-2">
        <div class="col">
            <div class="admin-inventory-list">
                <!-- Filter -->
                <div class="inventory-filter">
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
                                <img src="/public/icon/search.png" width="25px" alt="">
                            </span>
                            <input type="text" class="form-control" placeholder="Search" v-model="search">
                          </div>
                    </div>
                </div>

                <div class="items">
                    <div
                        class="item"
                        v-for="(data, index) in responseData.data"
                        :key="index"
                    >
                        <div class="title">
                           <h4>{{ data.item_code }}</h4>
                           <h4>{{ data.category }}</h4>
                        </div>
                        <div class="row">
                            <b>Unit Cost:</b>
                            <span>₱{{data.unit_cost}}</span>
                        </div>
                        <div class="row">
                           <b>Description:</b>
                          <p>
                           {{ data.description }}
                          </p>
                        </div>
                        <div class="row">
                          <b>Quantity:</b>
                          <small>{{ data.quantity }}x</small>
                        </div>
                        <div class="row">
                          <b>Supplier Name:</b>
                          <small>{{ data.supplier_name }}</small>
                        </div>
                        <div class="row">
                            <barcode :barcodeValue="data.barcode"/>
                        </div>
                      </div>
                    </div>
                <div class="pagination justify-content-center mt-5">
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
import Header from "@/components/Member_Header.vue";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import { onMounted, ref, watch } from "vue";
import barcode from '@/components/BarcodeView.vue'

const selected = ref("");
const responseData = ref({});
const search = ref("");

const getItem = (page) => {
    axios({
        method: "GET",
        url: `/api/member-get-item?category=${selected.value}&page=${page}`,
    }).then((response) => {
        responseData.value = response.data;
    });
};

watch(selected, (oldVal, newVal) => {
    getItem();
});

watch(search, (oldVal, newVal) => {
    axios({
        method: "GET",
        url: `/api/member-item-search-list?category=${selected.value}&search=${search.value}`,
    }).then((response) => {
        responseData.value = response.data;
    });

    if (search.value === "") {
        getItem();
    }
});

onMounted(() => {
    getItem();
});
</script>

<style scoped>
.admin-inventory-list {
    max-width: 80%;
    margin: auto;
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
.items {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    margin: auto;
    justify-content: center;
    align-items: center;
    margin-top: 20px;

}
.item {
    width: 20rem;
    background: rgb(255, 255, 255);
    height: 15rem;
    overflow: scroll;
    overflow-x: hidden;
    box-shadow: 0px 0px 5px 0px black;
    padding:10px;
    border-radius: 5px;

  }
  .item::-webkit-scrollbar {
    width: 3px;
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
 .title{
    display: flex;
    justify-content: space-between;
  }


</style>
