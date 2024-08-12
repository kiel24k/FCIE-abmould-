<template>
     <Header/>
    <div class="row m-2">
        <div class="col">
            <div class="row scheduling">
                <div class="col" style="width:50rem">
                    <ScheduledItems
                     :selectedDate="selectedDate"
                     />
                </div>
                <div class="col-4 side-action">
                    <div class="add-schedule">
                        <button class="btn" @click="addSchedule">
                            Add schedule
                        </button>
                    </div>
                    <div class="calendar">
                        <VDatePicker v-model.string='selectedDate' mode="date" :masks="masks" expanded />
                    </div>
                </div>
            </div>
        </div>
        <transition name="addScheduleTransition">
            <AddSchedule class="addSchedule"
              v-if="addScheduleModal"
             :addScheduleModal="addScheduleModal"
              @data="addScheduleModal = false"/>
        </transition>
       </div>
</template>
<script setup>
import Header from '@/components/Member_Header.vue'
import ScheduledItems from '@/components/ScheduledMaterials.vue'
import { onMounted, ref, watch } from 'vue';
import AddSchedule from '../../components/AddSchedule.vue';

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

    .addSchedule{
        transition: all linear 0.2s;
        transform:translate(0);

    }

    .addScheduleTransition-enter-from,
    .addScheduleTransition-leave-to{
        transform: translateY(-100%);
        opacity: 0;
    }
</style>
