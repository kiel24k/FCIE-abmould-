<template>
    <transition name="addScheduleTransition">
        <AddSchedule class="addSchedule" v-if="addScheduleModal" :addScheduleModal="addScheduleModal"
            @data="addScheduleModal = false" />
    </transition>
    <Header @toggle-sidebar="toggleSidebar" />
    <div class="row justify-content-center mt-5">
        <div class="col-8">
            <div class="col">
                <div class="row scheduling">
                    <div class="col" style="width:50rem">
                        <ScheduledItems :selectedDate="selectedDate" />
                    </div>
                    <div class="col-3">
                        <div class="add-sched">
                            <button class="btn text-start" @click="addSchedule">
                               <strong class="fs-5">+ Add schedule</strong><br>
                               <p class="lh-sm" style="font-size: 11px;">
                                You set schedule of materials and equipment's here
                               </p>
                            </button>
                        </div>
                        <div class="calendar">
                            <VDatePicker v-model.string='selectedDate' mode="date" :masks="masks" expanded />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Header from '@/components/Admin_Header.vue'
import Sidebar from '@/components/Admin_Sidebar.vue';
import ScheduledItems from '@/components/ScheduledMaterials.vue'
import { onMounted, ref, watch } from 'vue';
import AddSchedule from '../../components/AddSchedule.vue';

const selectedDate = ref({})
const masks = ref({
    modelValue: 'YYYY-MM-DD'
})
const isSidebarHidden = ref(false);
const toggleSidebar = () => {
    isSidebarHidden.value = !isSidebarHidden.value;
};

const addScheduleModal = ref(false)
const addSchedule = () => {
    addScheduleModal.value = true
}

</script>

<style scoped>
.btn strong{
    font-family: 'Poppins', sans-serif;
}
.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}

.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;
}
.scheduling {
    width: 100%;
    margin: auto;
    border-radius: 15px;
}

.calendar {
    width: 100%;
    margin: auto;
    height: 20px;
}

.add-sched {
    margin-top: 20px;
    height: 12rem;
    justify-content: left;
}

.add-sched button {
    width: 100%;
    max-width: 25rem;
    height: 4.8rem;
    padding-left: 1rem;
}

.add-sched button:hover{
    background-color: rgb(10, 135, 218);
    color: #fff;
}
.add-sched button:hover .lh-sm{
    color: #fff;
}

.add-sched button .lh-sm{
    color: #bbb5b5;
}

.side-action {
    display: grid;
    justify-content: center;
    gap: 15px;
}

.calendar,
.add-sched button {
    border-radius: 15px;
    box-shadow: 5px 5px 15px 0px gray;
}

.addSchedule {
    transition: all linear 0.2s;
    transform: translate(0);
}

.addScheduleTransition-enter-from,
.addScheduleTransition-leave-to {
    transform: translateY(-100%);
    opacity: 0;
}
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
</style>
