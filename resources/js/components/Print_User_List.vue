<script setup lang="ts">
import { Button } from 'primevue';
import { ref } from 'vue';
import Loading from '@/components/Loading.vue'
import html2pdf from 'html2pdf.js';

const props = defineProps(['tableData'])
const emits = defineEmits(['closeUserListModal'])
//COMPONENT VARIABLES
const printContent = ref(null)
//COMPONENT FUNCTION
const closeModal = () => {
    emits('closeUserListModal')
}

const print = () => {
    const elem = printContent.value

    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, allowTaint: false },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();
}


</script>

<template>
    <div id="modal">
        <div class="main p-4">
            <section  ref="printContent">
                <div class="modal_header">
                    <figure>
                        <img src="/public/background/abMouldLogo.png" alt="">
                        <figcaption>
                            <b>Unit C Lot 9, Block 7, First Cavite Industrial Estate (FCIE)</b>
                            <b>Dasmarinas, Cavite, 4114 Philippines</b>
                        </figcaption>
                    </figure>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>First name</th>
                            <th>Middle name</th>
                            <th>Last name</th>
                            <th>Email</th>
                            <th>Tel no.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in tableData">
                            <td>
                                <img :src="`/UserImage/${data.image}`" width="50px" height="50px" alt="">
                            </td>
                            <td>{{ data.first_name }}</td>
                            <td>{{ data.middle_name }}</td>
                            <td>{{ data.last_name }}</td>
                            <td>{{ data.email }}</td>
                            <td>{{ data.tel_no }}</td>
                        </tr>
                    </tbody>

                </table>
            </section>
            <section>
                <div class="row">
                    <div class="col table_action">
                        <Button label="Close" severity="contrast" @click="closeModal()" />
                        <Button label="Print" severity="danger" @click="print()" />
                    </div>
                </div>
            </section>
        </div>
    </div>

</template>
<style scoped>
#modal {
    position: fixed;
    width: 100%;
    height: 100%;
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: start;
    background: rgb(0, 0, 0, 0.5);
    z-index: 999;
    top: 0;
    overflow-x: scroll;
}

.main {
    display: grid;
    gap: 10px;
    background: white;

}

figure {
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
}

figure img {
    width: 90%;
    height: 90%;

}

figcaption {
    display: grid;
    text-align: center;
}

.table_action {
    display: flex;
    gap: 10px;

    justify-content: end;
}

.table td {
    width: 10rem;

}
</style>