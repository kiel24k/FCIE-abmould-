<template>
    <div class="row header">
        <a >
         <figure class="text-end" style="background: rgb(241, 237, 237);padding:8px;">
             {{ userInformation.first_name }}
             <img @click="profileModal" src="/public/icon/user-profile.svg" height="60px" alt="" style="margin-right:10px;">
            </figure>
        </a>
        <div class="profile-modal" v-if="showModal" ref="target">
            <div class="view-profile text-center">
                <b>Profile</b>
            </div>
            <div class="view-profile text-center">
                <b>Logout</b>
            </div>
        </div>

        </div>
</template>

<script setup>
import { ref } from 'vue';
import { onClickOutside } from '@vueuse/core';

const props = defineProps(['userInformation'])

//modal
const target = ref(null)
onClickOutside(target, event => showModal.value = false)

const showModal = ref(false)
const profileModal = () => {
    showModal.value = true
}
</script>

<style scoped>

img{
    cursor: pointer;
}
.profile-modal{
    max-width: 15rem;
    margin-right:10px;
    border-radius: 10px;
    height:10rem;
    display: grid;
    position:absolute;
    right:0;
    top:5rem;

}
.profile-modal > div{
    width: 100%;
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    background: rgb(241, 237, 237);
    border:solid 1px black;
    cursor: pointer;
    transition: all linear 0.1s;
}
.profile-modal > div:hover{
    background: rgb(216, 214, 214);

}

</style>
