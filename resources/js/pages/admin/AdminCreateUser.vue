<template>
    <header class="header">
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div  class="row main" >
        <div  key="content">
            <div class="col">
                <div class="create-user">
                    <form @submit.prevent enctype="multipart/form-data">
                        <div class="card card-main">
                            <div class="card-header bg-dark">
                                <h4 class="text-white">
                                    Create User |
                                    <span style="color:white; font-size:15px; font-weight:400">
                                        Enter User Information
                                    </span>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">

                                        <FloatLabel variant="on">
                                            <InputText id="on_label" class="form-control"
                                                :invalid="validation.first_name" v-model="input.firstName" />
                                            <label for="on_label">First Name</label>
                                        </FloatLabel>
                                        <small class="text-danger" v-if="validation.first_name">{{
                                            validation.first_name[0]}}</small>
                                    </div>
                                    <div class="col">
                                        <FloatLabel variant="on">
                                            <InputText id="on_label" class="form-control"
                                                :invalid="validation.middle_name" v-model="input.middleName" />
                                            <label for="on_label">Middle Name</label>
                                        </FloatLabel>
                                        <span class="text-danger" v-if="validation.middle_name">{{
                                            validation.middle_name[0] }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3">
                                        <FloatLabel variant="on">
                                            <InputText id="on_label" class="form-control"
                                                :invalid="validation.last_name" v-model="input.lastName" />
                                            <label for="on_label">Last Name</label>
                                        </FloatLabel>
                                        <span class="text-danger" v-if="validation.last_name">{{ validation.last_name[0]
                                            }}</span>
                                    </div>
                                    <div class="col mt-3">
                                        <FloatLabel variant="on">
                                            <InputNumber id="on_label" v-model="input.telNo"
                                                :invalid="validation.tel_no" :useGrouping="false" fluid/>
                                            <label for="on_label">Tel No.</label>
                                        </FloatLabel>
                                        <span class="text-danger" v-if="validation.tel_no">{{ validation.tel_no[0]
                                            }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3">

                                        <FloatLabel variant="on">
                                            <InputText id="on_label" class="form-control" :invalid="validation.email"
                                                v-model="input.email" />
                                            <label for="on_label">Email</label>
                                        </FloatLabel>
                                        <span class="text-danger" v-if="validation.email">{{ validation.email[0]
                                            }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3">
                                        <FloatLabel variant="on">
                                            <Password v-model="input.password" :feedback="false" :invalid="validation.password" fluid />
                                            <label for="on_label">Password</label>
                                        </FloatLabel>
                                        <span class="text-danger" v-if="validation.password">
                                            {{ validation.password[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <label for="">Role:</label>
                                        <div class="card flex justify-center">
                                            <Select v-model="input.role" :options="optionRole"
                                                :invalid="validation.role" optionLabel="name" placeholder="Select Role"
                                                class="w-full md:w-56" />
                                        </div>
                                        <span class="text-danger" v-if="validation.role">
                                            {{ validation.role[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <img width="250px" height="250px" alt="" :src="imageUrl" class="p-4">
                                        <input type="File" accept="image/*" @change="image">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-end table-action">
                                        <Button icon="pi pi-arrow-circle-left" label="Back" severity="danger" raised
                                            @click="back" />
                                        <Button icon="pi pi-check" label="Save" iconPos="right" severity="success"
                                            raised @click.enter="addUser" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script setup>
//dasd
import Header from '@/components/Admin_Header.vue';
import Sidebar from '@/components/Admin_Sidebar.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { FloatLabel, InputNumber, InputText, Password, Select, Button } from 'primevue';
import Swal from 'sweetalert2';


const isSidebarHidden = ref(false);
const headerHeight = ref(0);
const optionRole = ref([
    { name: 'ADMIN' },
    { name: 'INVENTORY-MANAGER' },
    { name: 'MEMBER' },
    {name: 'TL'}
])


const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const route = useRouter();
const input = ref({
    firstName: '',
    middleName: '',
    lastName: '',
    telNo: null,
    email: '',
    password: '',
    role: '',
    file: ''
});
const fileName = ref('');
const imageUrl = ref('');

const image = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        input.value.file = selectedFile;
        fileName.value = selectedFile.name;
        imageUrl.value = URL.createObjectURL(selectedFile);
    }
};

const validation = ref({});

const addUser = () => {
    axios.get('/sanctum/csrf-cookie');
    axios({
        method: 'POST',
        url: 'api/add-user',
        data: {
            first_name: input.value.firstName,
            middle_name: input.value.middleName,
            last_name: input.value.lastName,
            tel_no: input.value.telNo,
            email: input.value.email,
            password: input.value.password,
            role: input.value.role.name,
            image: input.value.file
        },
        headers: {
            'content-type': 'multipart/form-data'
        }
    }).then(response => {
        console.log(input.value.file);
        if (response.status == 200) {
            route.push('/admin-user-list')
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "User Added Successful",
                showConfirmButton: false,
                timer: 2000
            });
        }
    }).catch(err => {
        if (err.response.status === 422) {
            validation.value = err.response.data.errors;
        }
    })
};
const back = () => {
    history.back()
}
onMounted(() => {
    const headerElement = document.querySelector('.header');
    if (headerElement) {
        headerHeight.value = headerElement.offsetHeight;
    }
});
</script>

<style scoped>
.header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}

.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;
}

form {
    width: 67rem;
    margin: auto;
    display: grid;
    gap: 25px;
    border-radius: 10px;
    margin-top: 10px;


}

.card-main {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.table-action {
    display: flex;
    gap: 10px;
    justify-content: end;
    align-items: center;

}
.main{
    margin-top: 5rem;
}
</style>
