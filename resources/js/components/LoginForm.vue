<template>
    <div>
        <div id="login">
            <div class="login">
                <div class="title">
                    <h1>Login</h1>
                </div>
                <form @submit.prevent>
                    <div class="validation">
                       <ul class="navbar nav" v-for="error in validation" :key="error">
                        <li class="list-item text-danger">{{error[0]}}</li>
                       </ul>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Email: </b></label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Email"
                            v-model="data.email"
                        />
                    </div>
                    <div class="form-group">
                        <label for=""><b>Password: </b></label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Password"
                            v-model="data.password"
                        />
                    </div>
                    <div class="forgot-password">
                        <a href="">forgot password</a>
                    </div>
                    <div class="submit">
                        <button class="btn" :disabled='disabled' @click="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="logo">
                <img src="/public/background/abMouldLogo.png" alt="" />
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter()
    const data = ref({
        email: '',
        password: ''
    })
    const validation = ref({})
    const disabled = ref(false)

const submit = async () => {
   await axios({
    method: 'POST',
    url: 'api/login',
    data: {
        email: data.value.email,
        password: data.value.password
    }

   }).then(response => {
  localStorage.setItem('responseTKN', response.data)
  window.location.reload()

   }).catch(err => {
     validation.value = err.response.data.errors
   })
};

const token = localStorage.getItem('responseTKN')
 onMounted(() => {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    axios.get('api/user').then(response => {
        if(response.data.role == 'admin'){
            localStorage.setItem('administrationPermission', response.data.role)
            router.push('/admin-dashboard')

        }else if(response.data.role == 'inventory-manager'){
            localStorage.setItem('inventoryManagerPermission', response.data.role)
            router.push('/inventory-manager-dashboard')

        }else if(response.data.role == 'member'){
            localStorage.setItem('memberPermission',response.data.role)
            router.push('/member-dashboard')
        }
    })
}
 )



</script>
<style scoped>
#login {
    position: fixed;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    gap: 25px;
    align-content: center;
    align-items: center;
    flex-wrap: wrap;
}
#login > div {
    width: 40rem;
    height: 70%;
}
.login {
    display: grid;
    justify-content: center;
    align-content: center;
    gap: 25px;
    background: rgb(146, 178, 202, 0.7);
    backdrop-filter: blur(50px);
    border-radius: 40px;
}
form {
    display: grid;
    gap: 25px;

}
.login form input {
    width: 25rem;
}
.login form a {
    color: gray;
    text-decoration: none;
}

.login .title {
    text-align: center;
}
.login .title h1 {
    font-size: 3rem;
    font-weight: bolder;
}
.login .forgot-password {
    text-align: center;
}
.login .submit,
.login .submit button {
    width: 100%;
    border-radius: 10px;
    height: 3rem;
    background: #4caaf3;
}
#login .logo {
    display: grid;
    justify-content: center;
    align-content: center;
    align-items: center;
}
</style>
