<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, InputGroup, InputGroupAddon, InputText, Select } from 'primevue';
</script>

<template>

    <header>
        <Header />
    </header>

   

    <section>
        <div class="row">
            <div class="col title">
                <h1>Category List</h1>
            </div>
        </div> 
        <div class="row">
            <div class="col-3 table-option">
                <Select placeholder="Category"/>
                <InputGroup>
                    <InputText placeholder="Search" v-model="search" size="small" />
                    <InputGroupAddon>
                        <Button icon="pi pi-search" severity="contrast" size="small" variant="text" @click="toggle" />
                    </InputGroupAddon>
                </InputGroup>
                <Button label="clear" severity="danger"/>           
            </div>
            <div class="col text-end list-action">
                <Button label="New Category" icon="pi pi-plus" severity="info"/>
                <Button label="Print" icon="pi pi-print" severity="danger"/>
            </div>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>test</td>
                            <td>test1</td>
                            <td>test2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col text-center">
                    <Button label="Prev"/>
                    <span>1 of 2</span>
                    <Button label="Next"/>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.table-option{
    display: flex;
    gap:10px;
}
section{
    padding:10px;
    margin: 20px;
    box-shadow: 1px 1px 5px 0px gray;
}
.list-action{
    display: flex;
    gap:10px;
    justify-content: end;
}
th {
    background-color: #ebe9e9;
    border: white solid 1px;
    transition: all linear 0.4s;
}

.table-head {
    display: flex;
    justify-content: space-between;
    align-content: center;
    align-items: center;
}

th:hover {
    background: #D9D9D9;
    cursor: pointer;
}

td {
    border: white solid 1px;
    background-color: #D9D9D9;
    padding: 20px;
}

</style>