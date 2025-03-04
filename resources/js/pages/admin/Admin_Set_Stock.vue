<script setup>
import Header from '@/components/Admin_Header.vue'
import {Button, InputGroupAddon, InputText, Select} from 'primevue'
</script>

<template>
<header>
    <Header/>
</header>

<section>
    <div class="row bg-white p-3">
        <div class="col-3 category">
            <Select v-model="selectedCity" :options="cities" optionLabel="name" size="small" placeholder="Select a City"
            class="w-full md:w-56" />
            <InputGroup>
                <InputText placeholder="Search" size="small"/>
               
            </InputGroup>
        </div>
        <div class="col text-end">
            <Button severity="danger" icon="pi pi-print" label="Print"/>
        </div>
    </div>
</section>

<section>
    <div class="row bg-white p-3">
        <div class="col">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Current Stock</th>
                        <th>Treshold</th>
                        <th>Day until low-out-of-stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>Adjust Stock Level</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>Adjust Stock Level</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>Adjust Stock Level</td>
                    </tr>
                </tbody>
            </table>
            <div class="pag text-center">
              <span>1 2 3 4 5</span>  
            </div>
        </div>
    </div>
</section>
</template>

<style scoped>
section{
    margin:20px;
    box-shadow: 1px 1px 1px 1px gray;
}
.category{
    display: flex;
    align-content: center;
    align-items: center;
    gap:10px;
}
th{
    background-color:#ebe9e9;
    border: white solid 1px;
    transition: all linear 0.4s;
}
td{
    border: white solid 1px;
    background-color:#D9D9D9;
    padding: 20px;
}
</style>