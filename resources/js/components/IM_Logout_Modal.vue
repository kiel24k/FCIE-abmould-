<script setup>
import { useRouter } from "vue-router";


const router = useRouter()
const emit = defineEmits(['cancel'])
const logout = () => {
    localStorage.removeItem("responseTKN")
   localStorage.removeItem("inventoryManagerPermission")
   router.push("/")
}

const cancel = () => {
    emit('cancel')
}
</script>

<template>
    <div class="logout">
        <div class="logout-modal">
            <figure class="">
                <div class="text-center">
                    <img src="/public/image/warning-sign.png" width="80" alt="">
                </div>
                <span>Do you want to logout?</span>
            </figure>
            <div class="logout-action text-center">
                <button class="btn btn-primary" @click="cancel">No</button>
                <button class="btn btn-danger" @click="logout">Yes</button>
            </div>
        </div>
    </div>
</template>
<style scoped>
.logout {
    width: 100%;
    position: fixed;
    height: 100%;
    display: grid;
    justify-content: center;
    align-items: center;
    z-index: 999;
    background: rgb(0, 0, 0, 0.4);
    overflow: scroll;


}

figure {
    display: grid;
    justify-content: center;
    align-items: center;
}

figure img {}

.logout-modal {
    width: 25rem;
    height: 25rem;
    padding: 20px;
    background: rgb(226, 225, 221);
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
    box-shadow: 0px 0px 5px 0px gray;


}

.logout-action {
    display: flex;
    gap: 10px;
    justify-content: center;
}
</style>