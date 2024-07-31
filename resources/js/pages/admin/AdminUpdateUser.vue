<template>
    <div class="row">
        <div class="col-1">
            <Sidebar/>
        </div>
        <div class="col">
            <Header/>
            <div class="update-user">
                <form @submit.prevent enctype="multipart/form-data">
                    <h4>Update User | <span style="color:gray;font-size:15px; font-weight:400">Enter User Information</span></h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="">First Name <span class="text-danger" v-if="validation.first_name">
                                {{ validation.first_name[0] }}
                            </span></label>
                            <input type="text" class="form-control" placeholder="" v-model="userData.first_name">
                        </div>
                        <div class="col">
                            <label for="">Middle Name <span class="text-danger" v-if="validation.middle_name">
                                {{ validation.middle_name[0] }}
                            </span></label>
                            <input type="text" class="form-control" placeholder="" v-model="userData.middle_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Last Name <span class="text-danger" v-if="validation.last_name">
                                {{ validation.last_name[0] }}
                            </span></label>
                            <input type="text" class="form-control" placeholder="" v-model="userData.last_name">
                        </div>
                        <div class="col">
                            <label for="">Telphone Number <span class="text-danger" v-if="validation.tel_no">
                                {{ validation.tel_no[0] }}
                            </span></label>
                            <input type="text" class="form-control" placeholder="" v-model="userData.tel_no">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Email <span class="text-danger" v-if="validation.email">
                                {{ validation.email[0] }}
                            </span></label>
                            <input type="text" class="form-control" placeholder="" v-model="userData.email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Password <span class="text-danger" v-if="validation.password">
                                {{ validation.password[0] }}
                            </span></label>
                            <input type="text" class="form-control" placeholder="" v-model="userData.password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="">Role <span class="text-danger" v-if="validation.role">
                                {{ validation.role[0] }}
                            </span></label>
                            <select id="inputState" class="form-control" v-model="userData.role">
                                <option value="admin">admin</option>
                                <option value="inventory-manager">inventory manager</option>
                                <option value="member">member</option>
                              </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <img  width="250px" height="250px" alt="" :src="`http://127.0.0.1:8000/UserImage/${userData.image}`" class="p-4 bg-white">
                            <input type="File" accept="image/*" @change="image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success" @click.enter="updateUser">Submit</button>
                        </div>
                    </div>
                  </form>

            </div>
        </div>
    </div>
</template>

<script setup>

import Sidebar from '@/components/AdminSidebar.vue'
import Header from '@/components/Header.vue'
import { useRoute } from 'vue-router';
import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
import axios from 'axios';

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
    if(selectedFile){
        newImage.value = selectedFile
        fileName.value = selectedFile.name
        imageUrl.value = URL.createObjectURL(selectedFile)
    }
}

const storeUserData = ()=> {
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
            role: userData.value.role,
            image: newImage.value
        },
        headers: {
            'content-type': 'multipart/form-data'
        }
    }).then(response => {
        if(response.status == 200){
            router.push('/admin-user-list')
        }
    }).catch(err => {
        if(err.response.status == 422){
            validation.value = err.response.data.errors
        }
    })

}

onMounted(() => {
    storeUserData()
})

</script>

<style scoped>
.update-user{

}
form{
    width: 70rem;
    margin: auto;
    display:grid;
    gap:25px;
    background:#ffffff;
    border-radius: 10px;
    padding:10px;
}
</style>
