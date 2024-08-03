<template>
    <div class="row">
        <div class="col-1">
            <Sidebar/>
        </div>
        <div class="col">
            <Header/>
            <div class="profile">
                <div class="bg-danger">
                    <h1>d</h1>
                </div>
                </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
.profile{
    position:absolute;
    width:100%;
    height: 100%;
    top:0;
    background: rgb(207, 203, 203, 0.5);
    backdrop-filter: blur();
    display: grid;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

</style>
