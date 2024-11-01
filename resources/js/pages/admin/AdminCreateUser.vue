<template>
<header>
    <Header/>
</header>
    <div class="row m-2">
        <div class="col">
            <div class="create-user">
                <form @submit.prevent enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h4 class="text-white">Create User | <span style="color:white;font-size:15px; font-weight:400">Enter User Information</span></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <label for="">First Name: <span class="text-danger" v-if="validation.first_name">
                                        {{ validation.first_name[0]}}
                                   </span>
                                   </label>

                                    <input type="text" class="form-control" placeholder="" v-model="input.firstName">
                                </div>
                                <div class="col">
                                    <label for="">Middle Name: <span class="text-danger" v-if="validation.middle_name">
                                        {{ validation.middle_name[0]}}
                                   </span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="" v-model="input.middleName">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="">Last Name: <span class="text-danger" v-if="validation.last_name">
                                        {{ validation.last_name[0]}}
                                   </span></label>
                                    <input type="text" class="form-control" placeholder="" v-model="input.lastName">
                                </div>
                                <div class="col">
                                    <label for="">Telephone Number: <span class="text-danger" v-if="validation.tel_no">
                                        {{ validation.tel_no[0]}}
                                   </span></label>
                                    <input type="text" class="form-control" placeholder="" v-model="input.telNo">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="">Email <span class="text-danger" v-if="validation.email">
                                        {{ validation.email[0]}}
                                   </span></label>
                                    <input type="text" class="form-control" placeholder="" v-model="input.email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="">Password <span class="text-danger" v-if="validation.password">
                                        {{ validation.password[0]}}
                                   </span></label>
                                    <input type="password" class="form-control" placeholder="" v-model="input.password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Role <span class="text-danger" v-if="validation.role">
                                        {{ validation.role[0]}}
                                   </span></label>
                                    <select id="inputState" class="form-select" v-model="input.role">
                                        <option value="admin">admin</option>
                                        <option value="inventory-manager">inventory manager</option>
                                        <option value="member">member</option>
                                      </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <img  width="250px" height="250px" alt="" :src="imageUrl" class="p-4">
                                    <input type="File" accept="image/*" @change="image">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-success" @click.enter="addUser">Submit</button>
                                </div>
                            </div>
                        </div>
                      </div>
                  </form>

            </div>
        </div>

    </div>
</template>
<script setup>

import Header from '@/components/Admin_Header.vue'
import { ref } from 'vue';
import axios from 'axios';
import { useRouter} from 'vue-router';

const route = useRouter()

const input = ref({
    firstName: '',
    middleName: '',
    lastName: '',
    telNo: '',
    email: '',
    password: '',
    role:'',
    file: ''
})
const fileName = ref('')
const imageUrl = ref('')
const image = (event) => {
    const selectedFile = event.target.files[0]
    if(selectedFile){
        input.value.file = selectedFile
        fileName.value = selectedFile.name
        imageUrl.value = URL.createObjectURL(selectedFile)
    }
}

//formValidation
const validation = ref({})


// form submition / add user
const addUser = () => {
    axios.get('/sanctum/csrf-cookie')
    axios({
        method: 'POST',
        url:'api/add-user',
        data: {
            first_name: input.value.firstName,
            middle_name: input.value.middleName,
            last_name: input.value.lastName,
            tel_no: input.value.telNo,
            email: input.value.email,
            password: input.value.password,
            role: input.value.role,
            image: input.value.file
        },
        headers: {
            'content-type': 'multipart/form-data'
        }
    }).then(response => {
        console.log(input.value.file);
        
        if(response.status == 200){
            route.push('/admin-user-list')
        }
    }).catch(err => {
        if(err.response.status == 422){
            validation.value = err.response.data.errors
        }
    })
}




</script>

<style scoped>
.create-user{


}
form{
    width: 70rem;
    margin: auto;
    display:grid;
    gap:25px;
    border-radius: 10px;
    padding:10px;
}

</style>
