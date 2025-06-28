<script setup>
import Header from '@/components/Admin_Header.vue'
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { FloatLabel, InputText, Message, InputNumber, Select, Textarea, Button, InputGroup, DatePicker } from 'primevue';
import Swal from 'sweetalert2';

const router = useRouter()
const userInformation = ref()


const validation = ref({})
const input = ref({
  name: '',
  details: ''
})

const user = (id) => {
    userInformation.value = id
}
const submit = () => {
    axios({
        method: 'POST',
        url: 'api/post-category',
        data: {
           name: input.value.name,
           details: input.value.details
        }
    }).then(response => {
        console.log(response);
        if (response.status = 200) {
            router.push('/admin-category-list')
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Item Added!",
                showConfirmButton: false,
                timer: 2000
            });
        }
    }).catch(res => {
        console.log(res);
        if (res.response.status == 422) {
            validation.value = res.response.data.errors
        }
    })
}

const clicktBtn = () => {
    router.push("admin-category-list")
}
</script>

<template>
    <header>
        <Header @user="user" />
    </header>
    <div class="row main">
        <div class="col">
            <form @submit.prevent enctype="multipart/form-data">
                <div class="card card-main">
                    <div class="card-header bg-dark">
                        <h4 class="text-white">New Category | <span
                                style="color:white;font-size:15px; font-weight:400">Enter Category Information</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <i class="text-danger" v-if="validation.name">{{ validation.name[0]
                                    }}</i>
                                <FloatLabel variant="on">
                                    <InputText id="Item Code" :invalid="validation.name" v-model="input.name"
                                        variant="filled" size="large" class="form-control" />
                                    <label for="Item Code">Category Name</label>
                                </FloatLabel>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col">
                                 <i class="text-danger" v-if="validation.details">
                                        {{ validation.details[0] }}
                                    </i>
                                    <FloatLabel variant="on">
                                        <Textarea name="" :invalid="validation.details" id="" cols="30" rows="10" autoResize
                                        class="form-control" v-model="input.details"></Textarea>
                                        <label for="Item Code">Details</label>
                                    </FloatLabel>
                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-action">
                                <Button label="List" severity="danger" icon="pi pi-list" @click="clicktBtn()"/>
                                <Button label="submit" severity="success" icon="pi pi-check" @click="submit()" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>



<style scoped>
.main{
    margin-top: 5rem;
}
form {
    max-width: 100%;
    width: 100%;
    margin: auto;
    display: grid;
    gap: 25px;
    border-radius: 10px;
    padding: 20px;
}

.card-main {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    max-width: 900px;
    margin: auto;
    padding: 15px;
    width: 100%;
}

label {
    font-weight: 500;
}

.form-action {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .form-action {
        flex-direction: column;
        align-items: stretch;
    }

    .card-header h4 {
        font-size: 18px;
    }

    .card-body .row {
        flex-direction: column;
    }

    .form-control,
    .p-inputtext,
    .p-textarea {
        width: 100%;
    }
}
</style>

