<script setup>
import { Button } from 'primevue'
import { onMounted, ref } from 'vue'


const props = defineProps(['userId'])
const emit = defineEmits(['closeProfileModal'])

//API VARIABLE
const updatedUserData = ref({})

//API FUNCTIONS
const UPDATED_USER_API = async () => {
    console.log(props.userId);

    await axios({
        method: 'GET',
        url: `/api/updated-user-data/${props.userId}`,
    }).then(response => {
        updatedUserData.value = response.data
    })
}

const closeProfileModal = () => {
    emit('closeProfileModal')
}

//HOOKS

onMounted(() => {
    UPDATED_USER_API()
})
</script>

<template>
    <div class="view-modal">
        <div class="card">
            <div class="card-header">
                <h4>User Profile</h4>
                <img src="/public/icon/exit.png" width="20px" height="20px" alt="" @click="closeProfileModal()"
                    style="cursor: pointer;">
            </div>
            <div class="card-body">
                <div class="item">
                    <div class="row">
                        <div class="col">
                          <div class="icon">
                              <i class="pi pi-image"></i>
                          </div>
                          <div class="user_content">
                            <img :src="`UserImage/${updatedUserData.image}`" width="60" height="60" alt="">
                          </div>
                        </div>
                      </div>
                    <div class="row">
                      <div class="col">
                        <div class="icon">
                            <i class="pi pi-user"></i>
                        </div>
                        <div class="user_content">
                            <span>Name</span>
                            <b>{{ updatedUserData.first_name }} {{ updatedUserData.middle_name }} {{ updatedUserData.last_name }}</b>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="icon">
                                <i class="pi pi-question"></i>
                            </div>
                            <div class="user_content">
                                <span>Role</span>
                                <b>{{ updatedUserData.role }}</b>
                            </div>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="icon">
                                <i class="pi pi-envelope    "></i>
                            </div>
                            <div class="user_content">
                                <span>Email</span>
                                <b>{{ updatedUserData.email }}</b>
                            </div>
                          </div>
                    </div>
                    <div class="row" v-if="updatedUserData.tel_no">
                        <div class="col">
                            <div class="icon">
                                <i class="pi pi-phone"></i>
                            </div>
                            <div class="user_content">
                                <span>Contact</span>
                                <b>{{ updatedUserData.tel_no }}</b>
                            </div>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col justify-content-end">
                            <!-- <Button icon="pi pi-pencil" severity="info" raised label="edit"/>
                            <Button  icon="pi pi-list" raised label="User list"/> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

.view-modal {
    position: absolute;
    display: grid;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    width: 100%;
    z-index: 999;
    top:0;
    bottom:0;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-body {
    height: auto;
}

.item {
    width: 40rem;
    background: rgb(255, 255, 255);
    height: auto;
    box-shadow: 0px 0px 5px 0px black;
    padding: 10px;
    border-radius: 5px;
}
.item .col .icon i{

    font-size: 20px;
}
.item .col {
    display: flex;
    gap:20px;
    align-items: center;
    padding:20px;
    border:solid 1px gray;
}
.user_content{
    display: grid;
}


</style>
