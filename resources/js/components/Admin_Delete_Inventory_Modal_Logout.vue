<script setup>


const emit = defineEmits(['cancelItem'])
const props = defineProps(['deleteId'])
const cancelItem = () => {
    emit('cancelItem')
}

const deleteItem = () => {
   axios({
        method: 'DELETE',
        url: `api/delete-item/${props.deleteId}`
    }).then(response => {
     
        
        if (response.status == 200) {
            emit('cancelItem')
        }
    })
}


</script>

<template>
    <div class="logout">
        <div class="logout-modal">
            <figure class="">
                <div class="text-center">
                    <img src="/public/image/warning-sign.png" width="80" alt="">
                </div>
                <span>Do you want to Delete it?</span>
            </figure>
            <div class="logout-action text-center">
                <button class="btn btn-primary" @click="cancelItem">Cancel</button>
                <button class="btn btn-danger" @click="deleteItem">Delete</button>
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