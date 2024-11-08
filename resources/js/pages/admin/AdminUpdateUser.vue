<template>
    <header>
        <Header />
    </header>
    <div class="row m-2">
        <div class="col">
            <div class="update-user">
                <form @submit.prevent enctype="multipart/form-data">
                    <h4>Update User | <span style="color:gray;font-size:15px; font-weight:400">Enter User
                            Information</span></h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" class="form-control" :invalid="validation.first_name"
                                    :size="large" v-model="userData.first_name" />
                                <label for="on_label">First Name</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="validation.first_name">{{ validation.first_name[0]
                                }}</small>
                        </div>
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" class="form-control" :invalid="validation.middle_name"
                                    :size="large" v-model="userData.middle_name" />
                                <label for="on_label">Middle Name</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="validation.middle_name">{{ validation.middle_name[0]
                                }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" class="form-control" :invalid="validation.last_name"
                                    :size="large" v-model="userData.last_name" />
                                <label for="on_label">Last Name</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="validation.first_name">{{ validation.last_name[0]
                                }}</small>
                        </div>
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputNumber :size="large" :invalid="validation.tel_no" v-model="userData.tel_no"
                                    inputId="on_label" :useGrouping="false" />
                                <label for="on_label">Tel No.</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="validation.tel_no">{{ validation.tel_no[0] }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" class="form-control" :invalid="validation.email" :size="large"
                                    v-model="userData.email" />
                                <label for="on_label">Email</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="validation.email">{{ validation.email[0] }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" class="form-control" :invalid="validation.password"
                                    :size="large" v-model="userData.password" />
                                <label for="on_label">Password</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="validation.password">{{ validation.password[0] }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="">Role</label>
                            <div class="card flex justify-center">
                                <Select v-model="userData.role" :options="userRole" optionLabel="name"
                                    placeholder="Select Role" class="w-full md:w-56" />
                            </div>
                            <small class="text-danger" v-if="validation.role">{{ validation.role[0] }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <img width="250px" height="250px" alt=""
                                :src="`http://127.0.0.1:8000/UserImage/${userData.image}`" class="p-4 bg-white">
                            <input type="File" accept="image/*" @change="image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end update-action">
                            <Button @click="back" label="Back" icon="pi pi-arrow-circle-left" severity="danger" raised
                                iconPos="left" />
                            <Button @click.enter="updateUser" label="Update" icon="pi pi-refresh" severity="success"
                                raised iconPos="right" />
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import { useRoute } from 'vue-router';
import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { Button, FloatLabel, InputNumber, InputText, Select } from 'primevue';

const userRole = ref([
    { name: 'admin' },
    { name: 'inventory-manager' },
    { name: 'member' }
])
const route = useRoute()
const router = useRouter()
const input = ref({})
const userData = ref({

})
const fileName = ref('')
const imageUrl = ref('')
const newImage = ref(null)

const image = (event) => {
    const selectedFile = event.target.files[0]
    if (selectedFile) {
        newImage.value = selectedFile
        fileName.value = selectedFile.name
        imageUrl.value = URL.createObjectURL(selectedFile)
    }
}

const storeUserData = () => {
    axios.get(`/api/updated-user-data/${route.params.id}`).then(response => {
        userData.value = response.data
    })
}

const validation = ref({})
const updateUser = () => {
    console.log(userData.value.first_name);
    axios.get('/sanctum/csrf-cookie')
    axios({
        method: 'POST',
        url: `/api/update-user-data/${route.params.id}`,
        data: {
            first_name: userData.value.first_name,
            middle_name: userData.value.middle_name,
            last_name: userData.value.last_name,
            tel_no: userData.value.tel_no,
            email: userData.value.email,
            password: userData.value.password,
            role: userData.value.role.name,
            image: newImage.value
        },
        headers: {
            'content-type': 'multipart/form-data'
        }
    }).then(response => {
        if (response.status == 200) {
            router.push('/admin-user-list')
        }
    }).catch(err => {
        if (err.response.status == 422) {
            validation.value = err.response.data.errors
        }
    })

}

const back = () => {
    history.back()
}

onMounted(() => {
    storeUserData()
})

</script>

<style scoped>
form {
    width: 70rem;
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.update-action {
    display: flex;
    align-items: center;
    justify-content: end;
    gap: 10px;
}
</style>
