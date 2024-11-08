<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, Image, Message } from 'primevue';
import { onMounted, ref } from 'vue';
import 'primeicons/primeicons.css'
import Swal from 'sweetalert2';

const userInformation = ref([])


const user = (userData) => {
    userInformation.value = userData
}

const editProfile = () => {
    Swal.fire({
  title: "profile => not done/ ongoing",
  showClass: {
    popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `
  },
  hideClass: {
    popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `
  }
});

}


</script>

<template>
    <header>
        <Header @user="user" />
    </header>
    <section class="row mt-4" id="profile">
        <div class="col">
            <figure>
                <Image v-if="!userInformation.image"
                    src="/public/image/370076_account_avatar_client_male_person_icon.png" alt="" preview />
                <Image v-else-if="userInformation.image" :src="`/UserImage/${userInformation.image}`" width="100" alt=""
                    preview/>
                <figcaption class="profile-figcaption text-dark">
                    <span>{{ userInformation.first_name }}</span> {{ userInformation.middle_name }} {{
                        userInformation.last_name }}
                </figcaption>
            </figure>

        </div>
        <div class="col profile-action">
            <div class="">
                <Button @click="editProfile" icon="pi pi-file-edit" label="edit" raised severity="info"/>
            </div>
        </div>
    </section>

    <section id="info">
        <article>
            <Message severity="contrast" icon="pi pi-user">My Information</Message>
            <div class="content mt-3">
                <figure class="figure-info">
                    <figcaption class="figure-figcaption">
                       <i class="pi pi-envelope"/>
                       <span>{{ userInformation.email }}</span>
                    </figcaption>
                </figure>
            </div>
            <div class="content">
                <figure class="figure-info">
                    <figcaption class="figure-figcaption">
                        <i class="pi pi-phone"/>
                        <span>{{userInformation.tel_no}}</span>
                    </figcaption>
                </figure>
            </div>
            <div class="row">
                <div class="col">
                    <router-link :to="{name: 'admin-dashboard'}">
                        <Button icon="pi pi-home" label="Dashboard" raised/>
                    </router-link>
                </div>
            </div>
        </article>
    </section>
</template>



<style scoped>
#profile {
    max-width: 60rem;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    padding:10px;
}
section {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

}



figure {
    display: flex;
    align-items: center;
    gap: 10px
}

.profile-figcaption {
    font-weight: 600;
}

.profile-action {
    display: flex;
    justify-content: end;
    align-items: center;
}

#info {
    max-width: 60rem;
    margin: auto;
    border-radius: 10px;
    padding: 10px;
    margin-top: 10px;
}

.figure-info {
    display: flex;
}

.figure-figcaption {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap:10px;
}

</style>