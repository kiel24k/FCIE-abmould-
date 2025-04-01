<script setup>
import Header from "@/components/Admin_Header.vue"
import { Button, Message, Select } from "primevue";
import { ref } from "vue";

const roles = ref("admin")
</script>

<template>
    <header>
        <Header />
    </header>

    <section>
        <div class="row">
            <div class="col title">
                <Message severity="white">
                    <h1>Team Members</h1>
                    <span>Manage you organization member</span>
                </Message>
            </div>
        </div>
        
        <div class="row mt-3 ">
            <div class="col">
                <div class="content p-4">
                    <div class="table_title">
                        <b>Team</b>
                    </div>
                    <div class="table_add_member">
                       <router-link :to="{name: 'create-user'}">
                        <Button label="Add member" variant="text" icon="pi pi-plus" severity="contrast"/>
                       </router-link>
                    </div>
                </div>
                <hr>
                <table class="table  table-hover">
                    <tbody>
                        <tr>
                            <td class="figure_class">
                               <figure>
                                <img src="https://randomuser.me/api/portraits/men/11.jpg" width="30px" height="30px" alt="">
                               </figure>
                               <div class="figure_content">
                                <b>KIel Alarcon Bermudez</b>
                                <span>kiel@gmail.com</span>
                               </div>
                            </td>
                            <td>
                                <Select :placeholder="roles"/>
                            </td>
                            <td>
                                <Button icon="pi pi-trash" severity="danger" rounded  variant="text" />
                            </td>
                        </tr>
                        <tr>
                            <td class="figure_class">
                               <figure>
                                <img src="https://randomuser.me/api/portraits/men/36.jpg" width="30px" height="30px" alt="">
                               </figure>
                               <div class="figure_content">
                                <b>KIel Alarcon Bermudez</b>
                                <span>kiel@gmail.com</span>
                               </div>
                            </td>
                            <td>
                                <Select :placeholder="roles"/>
                            </td>
                            <td>
                                <Button icon="pi pi-trash" severity="danger" rounded  variant="text" />
                            </td>
                        </tr>
                        <tr>
                            <td class="figure_class">
                               <figure>
                                <img src="https://randomuser.me/api/portraits/women/64.jpg" width="30px" height="30px" alt="">
                               </figure>
                               <div class="figure_content">
                                <b>KIel Alarcon Bermudez</b>
                                <span>kiel@gmail.com</span>
                               </div>
                            </td>
                            <td>
                                <Select :placeholder="roles"/>
                            </td>
                            <td>
                                <Button icon="pi pi-trash" severity="danger" rounded  variant="text" />
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<style scoped>
section {
    width: 50%;
    margin: auto;
}

.p-message {
    background: white;
    outline: 0px;
}
section > div{

    background: white;
    box-shadow: 0px 0px 4px 0px gray;
    outline: 0px;
    border-radius: 10px;
    

}
.content{
    display: flex;
    align-items: center;
    
    justify-content: space-between;
}
.figure_class{
    display: flex;
    align-items: center;
    align-content: center;
    gap:10px;
}
.figure_class span{
    color:gray;
}
.figure_class img{
    border-radius: 100%;
}
.figure_content{
    display: grid;
}
.table .p-select{
    background: none;
   border:0px;
}
.table .p-select:hover{
    background: none;
}
</style>