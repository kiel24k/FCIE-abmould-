<template>
    <transition name="addScheduleTransition">
        <AddSchedule class="addSchedule" v-if="addScheduleModal" :addScheduleModal="addScheduleModal"
            @data="addScheduleModal = false" :userData="userData" />
    </transition>
    <Header @user="user" />
    <div class="row justify-content-center main">
        <div class="col-8">
            <div class="col">
                <div class="row">
                    <div class="col text-end">
                        <Button label="Add schedule" @click="addSchedule()" />
                    </div>
                </div>
                <div class="row scheduling mt-2" raised>
                    <div class="col" style="width:50rem">
                        <ScheduledItems :selectedDate="selectedDate" />
                    </div>
                    <div class="col">
                        <VDatePicker v-model.string='selectedDate' mode="date" :min-date="minDate" :max-date="maxDate"
                            :masks="masks" expanded />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

import Header from '@/components/IM_Header.vue'
import ScheduledItems from '@/components/ScheduledMaterials.vue'
import { onMounted, ref, watch } from 'vue';
import AddSchedule from '../../components/AddSchedule.vue';
import { Button } from 'primevue';

const userData = ref({})

const user = (data) => {
    userData.value = data
}

const today = new Date()

const minDate = today.toISOString().split('T')[0]

// Set max date to 2 years from today
const futureDate = new Date()
futureDate.setFullYear(today.getFullYear() + 2)


// Add 2 years
const maxDate = new Date()
maxDate.setFullYear(today.getFullYear() + 2)

const selectedDate = ref({})
const masks = ref({
    modelValue: 'YYYY-MM-DD'
})


const addScheduleModal = ref(false)
const addSchedule = () => {
    addScheduleModal.value = true
}
</script>

<style scoped>
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
    height: 10rem;
    display: grid;
    gap: 10px;

}

.add-sched button {
    width: 100%;
    max-width: 25rem;
    height: 3.8rem
}

.add-sched button:hover {
    background-color: rgb(10, 135, 218);
    color: #fff;
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

.main {
    margin-top: 5rem;
}
</style>
