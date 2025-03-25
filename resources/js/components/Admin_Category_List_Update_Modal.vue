<script setup>
import { Button, FloatLabel, InputText, Textarea } from 'primevue';
import { onMounted, ref } from 'vue';

const emit = defineEmits(['closeCategoryListModal'])
const props = defineProps(['categoryLIstId'])




//INPUT VARIABLES
//API VARIABLES

const getUpdateCategoryListData = ref({})
const validation = ref({})
//COMPONENTS VARIABLES


 //API FUNCTIONS
const getUpdateCategoryList = async () => {
    await axios({
        method: 'GET',
        url: 'api/get-update-category-list',
        params: {
            id: props.categoryLIstId
        }
    }).then(response => {
        getUpdateCategoryListData.value = response.data
    }).catch(e => {
        console.log(e);
    })
}

 const submit = async () => {
    axios({
        method: 'POST',
        url: 'api/update-category-list',
        data: {
            id: getUpdateCategoryListData.value.id,
            name: getUpdateCategoryListData.value.name,
            details: getUpdateCategoryListData.value.details
        }
    }).then(response => {
        console.log(response);
        
    }).catch(e => {
        console.log(e.response.data.errors);
        
    })
   
}


 //COMPONENTS  
 const closeCategoryListModal = () => {
    emit('closeCategoryListModal')
}
 
 
 //HOOKS   
onMounted(() => {

    getUpdateCategoryList()
})
</script>
<template>
    <div class="modal-main">
        <div class="content">
            <fieldset>
                <form action="">
                    <input type="hidden" v-model="getUpdateCategoryListData.id">
                    <div class="form-title ">
                        <h5>Update Category</h5>
                    </div>
                    <div class="row mt-4 ">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" fluid v-model="getUpdateCategoryListData.name"/>
                                <label for="on_label">Category Name</label>
                            </FloatLabel>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <FloatLabel variant="on">
                                <Textarea id="over_label" v-model="getUpdateCategoryListData.details" rows="5" cols="30" style="resize: none" />
                                <label for="on_label">Details</label>
                            </FloatLabel>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-end form-action">
                            <Button label="Cancel" severity="danger" @click="closeCategoryListModal()" />
                            <Button severity="info" label="Save" raised @click="submit()" />
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</template>
<style scoped>
.modal-main {
    position: absolute;
    z-index: 999;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
}

form {
    background: #ffffff;
    padding: 20px;
}


.form-action {
    display: flex;
    gap: 5px;
    justify-content: end;
}
</style>