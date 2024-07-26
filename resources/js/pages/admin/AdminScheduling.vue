<template>
   <div class="row">
    <div class="col-1">
        <Sidebar/>
    </div>
    <div class="col">
        <Header/>

        <div class="row scheduling">
            <div class="col" style="width:50rem">
                <Schedule :data="selectedDate"/>

            </div>
            <div class="col-4 side-action">
                <div class="add-schedule">
                    <button class="btn">
                        Add schedule
                    </button>
                </div>
                <div class="calendar">
                    <VDatePicker v-model.string='selectedDate' mode="date" :masks="masks" expanded />
                </div>
            </div>
        </div>

    </div>
   </div>
</template>
<script setup>
import Sidebar from '@/components/AdminSidebar.vue'
import Header from '@/components/AdminHeader.vue'
import Schedule from '@/components/ScheduledMaterials.vue'
import { onMounted, ref, watch } from 'vue';

const selectedDate = ref({})
const masks = ref({
    modelValue: 'YYYY-MM-DD hh-mm-ss'
})




</script>

<style scoped>
.scheduling{
width: 90%;
margin:auto;
border-radius: 15px;
}
.calendar{
    width: 30rem;

}
.add-schedule button{
    width: 100%;
    margin:auto;
    height:8rem
}
.side-action{
    display: grid;
    justify-content: center;
    gap:15px;
}
.calendar, .add-schedule button{
    border-radius:15px;
    box-shadow: 5px 5px 15px 0px gray;
}

</style>
