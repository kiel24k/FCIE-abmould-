<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, Select } from 'primevue';
</script>

<template>
    <header>
        <Header />
    </header>
    <section>
        <div class="container">
            <div class="row">
                <div class="col title">
                    <h2>Activity Log</h2>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container bg-white">
            <div class="row p-2">
                <div class="col">
                    <div class="category">
                        <Select placeholder="Filter" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col notif">
                    <div class="info">
                        <div class="notif-info">
                            <div class="date_and_time d-grid ">
                                <span>11-16-2025</span>
                                <b>12:30 pm</b>
                            </div>
                            <div class="user-info">
                                <Button icon="pi pi-plus" severity="success" rounded raised class="m-3" />
                            </div>
                            <div class="message">
                                <b>Managing Item</b>
                                <p>The User "ABC" Successfull Added new Items from Inventory</p>
                            </div>
                        </div>
                        <div class="notif_info_option">
                            <i class="pi pi-user m-1"></i>
                            <small class="text-warning">View User </small> |
                            <Button label="remove" icon="pi pi-trash" severity="secondary" />
                        </div>
                    </div>

                    <div />
                </div>
            </div>

            <div class="row">
                <div class="col notif">
                    <div class="info">
                        <div class="notif-info">
                            <div class="date_and_time d-grid ">
                                <span>11-16-2025</span>
                                <b>12:30 pm</b>
                            </div>
                            <div class="user-info">
                                <Button icon="pi pi-pencil" severity="info" rounded raised class="m-3" />
                            </div>
                            <div class="message">
                                <b>Managing Item</b>
                                <p>The User "ABC" Successfull edited the Items from Inventory</p>
                            </div>
                        </div>
                        <div class="notif_info_option">
                            <i class="pi pi-user m-1"></i>
                            <small class="text-warning">View User </small> |
                            <Button label="remove" icon="pi pi-trash" severity="secondary" />
                        </div>
                    </div>

                    <div />
                </div>
            </div>

            <div class="row">
                <div class="col notif">
                    <div class="info">
                        <div class="notif-info">
                            <div class="date_and_time d-grid ">
                                <span>11-16-2025</span>
                                <b>12:30 pm</b>
                            </div>
                            <div class="user-info">
                                <Button icon="pi pi-trash" severity="danger" rounded raised class="m-3" />
                            </div>
                            <div class="message">
                                
                                <b>Managing Item</b>
                                <p>The User "ABC" Successfull Deleted The Items From Inventory</p>
                            </div>
                        </div>
                        <div class="notif_info_option">
                            <i class="pi pi-user m-1"></i>
                            <small class="text-warning">View User </small> |
                            <Button label="remove" icon="pi pi-trash" severity="secondary" />
                        </div>
                    </div>

                    <div />
                </div>
            </div>  
        </div>
    </section>

</template>

<style scoped>
section {
    margin-top: 10px;
}

.notif-info {
    display: flex;
    align-items: center;

}

.info {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    border: 1px rgb(177, 207, 8) solid;
    border-width: 0px 0px 1px 0px;
    background: rgb(247, 245, 245);
    border-radius: 15px;
    padding: 10px;
}
</style>