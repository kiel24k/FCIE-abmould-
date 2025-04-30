<script setup>
import Header from '@/components/TL_Header.vue'

import Scanner from '@/components/Barcode_Scanner.vue'
import BarcodeView from '@/components/BarcodeView.vue'
import { Button, FloatLabel, InputNumber, Message } from 'primevue'
import Swal from 'sweetalert2'
import { onMounted, ref, watch } from 'vue'
//COMPONENTS VARIABLE
const barcodeData = ref({})
const quantity = ref(1)
const validation = ref({})
const barcodeItem = ref('')

//API FUNCTIONS
const barcodeValue = (data) => {
    barcodeItem.value = data
}

const GET_SCAN_BARCODE_API = async () => {
    await axios({
        method: 'GET',
        url: '/api/view-scan-barcode',
        params: {
            barcode: barcodeItem.value
        }
    }).then(response => {
        barcodeData.value = response.data
    })
}

//COMPONENTS FUNCTIONS
const submit = async () => {
    await axios({
        method: 'POST',
        url: '/api/reduce-quantity-submit',
        data: {
            item_id: barcodeData.value[0].id,
            quantity: quantity.value
        }
    }).then(response => {
        if (response.status === 200) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Data has been saved",
                showConfirmButton: false,
                timer: 1500
            });
            GET_SCAN_BARCODE_API()
            quantity.value = 1
            validation.value = ''
        }
    }).catch(e => {
        validation.value = e.response.data.errors

    })
}


//HOOKS
watch(barcodeItem, (oldVal, newVal) => {
    GET_SCAN_BARCODE_API()
})
onMounted(() => {
    GET_SCAN_BARCODE_API()
})
</script>

<template>
    <header>
        <Header />
    </header>
    <div id="main">
        <section>
            <div class="page_title">
                <Message icon="pi pi-list" severity="secondary">
                    <h4>View Item</h4>
                </Message>
            </div>
            <div class="page mt-2">
                <div class="scanner">
                    <Scanner @barcodeValue="barcodeValue" />
                </div>
                <div class="barcode_data bg-white p-4">
                    <div class="barcode_header">
                        <h4>Barcode Data</h4>
                        <hr>
                    </div>
                    <div class="barcode_item" v-if="barcodeData[0]">
                        <div class="name">
                            <ul>
                                <li>
                                    <div class="li_data">
                                        <b>Types:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>{{ barcodeData[0].category }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Supplier name:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>{{ barcodeData[0].supplier_name }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Brand:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>{{ barcodeData[0].brand }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Quantity:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>{{ barcodeData[0].quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                            ',')
                                            }}x</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Treshold:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>{{ barcodeData[0].treshold.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                            ',')
                                            }}x</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Unit cost:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>₱{{ barcodeData[0].unit_cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                            ',')
                                            }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Total cost:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>₱{{ barcodeData[0].total_cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                            ',')
                                            }}.00</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="li_data">
                                        <b>Description:</b>
                                    </div>
                                    <div class="li_info">
                                        <span>{{ barcodeData[0].description }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="barcode_photo" v-if="barcodeData[0]">
                                        <BarcodeView :barcodeValue="barcodeData[0].item_code" />
                                    </div>
                                </li>
                                <hr>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
</template>



<style scoped>
#main {
    margin-top: 5rem;

}

section {
    display: grid;
    justify-content: center;
}

.page {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.barcode_data {
    width: 40rem;
}

.barcode_item {
    display: flex;
    gap: 10px;
}

.barcode_item ul {
    display: grid;
    gap: 20px;
}

.barcode_item li {
    display: flex;
}

.barcode_item .li_data {
    width: 10rem;
    display: grid;
    gap: 10px;
}

.barcode_item .li_info {
    width: 20rem;

}

.list_field {
    display: grid;
    gap:10px;
}

.list_action {
    display: grid;
    gap: 10px;
}

.field {
    display: flex;
    align-items: center;
    align-content: center;
}
</style>
