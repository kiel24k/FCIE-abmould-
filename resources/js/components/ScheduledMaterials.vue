<template>
  <div class="container-fluid schedule-wrapper">
    <div class="row">
      <div class="col text-center">
        <h4>Schedules of Materials & Equipments</h4>
      </div>
    </div>

   

    <div class="table-responsive">
      <table class="table table-borderless table-hover">
        <thead>
          <tr>
              <th>Schedule Date</th>
              <th>Date Scheduled</th>
              <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(data, index) in scheduledData" :key="index">
            <td>{{ data.schedule_date }}</td>
            <td>{{ new Date(data.created_at).toISOString().split('T')[0] }}</td>
             <td><b>{{ data.status }}</b></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
const props = defineProps(['selectedDate'])

const scheduledData = ref([])

watch(props, () => {
  axios.get(`/api/scheduled-date/${props.selectedDate}`)
    .then(response => {
      scheduledData.value = response.data.data
    })
})
</script>

<style scoped>
.schedule-wrapper {
  box-shadow: 0px 0px 5px rgb(83, 81, 81);
  border-radius: 15px;
  padding: 30px 20px;
  background-color: #fff;
  max-width: 100%;
  overflow-x: auto;
}

th, tbody {
  text-align: center;
}

@media (max-width: 768px) {
  .schedule-wrapper {
    padding: 20px 10px;
  }

  table {
    font-size: 0.9rem;
  }
}
</style>
