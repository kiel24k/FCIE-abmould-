<template>
    <div class="body">
        <div class="content">
            <div class="">
                <div id="login" class="">
                    <div class="text-center">
                        <img src="/public/background/abMouldLogo.png" width="150px" height="50px" alt="">
                        <hr>
                    </div>
                    <div class="row">
                        <h1>Login</h1>
                        <b>Hi, Welcome back</b>
                        <div class="validation">
                            <ul
                                class="navbar nav"
                                v-for="error in validation"
                                :key="error"
                            >
                                <li class="list-item text-danger">
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <form @submit.prevent>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="">Email</label>
                                    <div class="input-group">
                                        <span
                                            class="input-group-text"
                                            id="basic-addon1"
                                        >
                                            <img
                                                src="/public/icon/email_logo.png"
                                                width="20px"
                                                alt=""
                                            />
                                        </span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter you Email"
                                            aria-label="Username"
                                            aria-describedby="basic-addon1"
                                            v-model="data.email"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="">Password</label>
                                    <div class="input-group">
                                        <span
                                            class="input-group-text"
                                            id="basic-addon1"
                                        >
                                            <img
                                                src="/public/icon/password1.png"
                                                width="20px"
                                                alt=""
                                            />
                                        </span>
                                        <input
                                            type="password"
                                            class="form-control"
                                            placeholder="Enter you password"
                                            aria-label="Username"
                                            aria-describedby="basic-addon1"
                                            v-model="data.password"
                                        />
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row mt-3">
                            <div class="col">
                                <input type="checkbox" />
                                <label for="">Remember-me</label>
                            </div>
                            <div class="col text-end">
                                <a href="">Forgot Password?</a>
                            </div>
                        </div> -->
                            <div class="row mt-3">
                                <div class="col">
                                    <button
                                        class="btn submit"
                                        :disabled="disabled"
                                        @click="submit"
                                    >
                                        Login
                                    </button>
                                </div>
                            </div>
                            <!-- <div class="row mt-3 text-center">
                            <span>
                                <small>Not register yet?</small>
                                <a href="">Create an account</a>
                            </span>
                        </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const data = ref({
    email: "",
    password: "",
});
const validation = ref({});
const disabled = ref(false);

//submit login JWT
const submit = async () => {
    await axios({
        method: "POST",
        url: "api/login",
        data: {
            email: data.value.email,
            password: data.value.password,
        },
    })
        .then((response) => {
            localStorage.setItem("responseTKN", response.data);
            window.location.reload();
        })
        .catch((err) => {
            validation.value = err.response.data.errors;
        });
};

const token = localStorage.getItem("responseTKN");
onMounted(() => {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    axios.get("api/user").then((response) => {
        if (response.data.role == "admin") {
            localStorage.setItem(
                "administrationPermission",
                response.data.role,
            );
            router.push("/admin-dashboard");
        } else if (response.data.role == "inventory-manager") {
            localStorage.setItem(
                "inventoryManagerPermission",
                response.data.role,
            );
            router.push("/inventory-manager-dashboard");
        } else if (response.data.role == "member") {
            localStorage.setItem("memberPermission", response.data.role);
            router.push("/member-scheduling");
        }
    });
});
</script>
<style scoped>
.body {
    position: absolute;
    height: 100%;
    width: 100%;
    display: grid;
    align-items: center;
    justify-content: center;
    background-image: url("/public/background/AI-Capabilities.png")
}

#login {
    width: 25rem;
    margin: auto;
    background: rgb(255, 255, 255);
    padding: 20px;
    box-shadow: 0px 0px 15px 0px gray;
    border-width: 1px 0px 1px 1px;
}
.submit {
    width: 100%;
    background-color: rgb(104, 77, 224);
    color: white;
}
a {
    text-decoration: none;
    font-weight: 500;
}
</style>
