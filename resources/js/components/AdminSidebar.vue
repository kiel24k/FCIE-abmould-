<template>
    <div>
        <aside>
            <div class="title">
                <img
                    src="/public/background/abMouldLogo.png"
                    width="200px"
                    alt=""
                />
            </div>
            <div class="dashboard">
                <ul class="navbar nav">
                    <li class="nav-item title-dashboard">
                        <b>Dashboard</b>
                    </li>
                    <li class="nav-item" @click="showInventory">
                        <a class="nav-link">
                            <div class="item">
                                <img
                                    src="/public/icon/inventoryIcon.svg"
                                    width="25px"
                                    alt=""
                                />
                                <b>Inventory</b>
                            </div>
                            <div class="other">
                                <p>></p>
                            </div>
                        </a>
                    </li>

                    <!--inventory option animation  -->
                    <div
                        class="inventory-option"
                        :class="{ inventoryOptionStyle: isInventory }"
                    >
                        <li class="nav-item">
                            <router-link :to="{name: 'admin-inventory-list'}" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>inventory List</b>
                                </div>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'admin-new-item'}" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>New Item</b>
                                </div>
                            </router-link>
                        </li>
                    </div>
                    <!--end inventory option animation-->

                    <li class="nav-item">
                        <a class="nav-link">
                            <div class="item">
                                <img
                                    src="/public/icon/analyticsIcon.svg"
                                    width="25px"
                                    alt=""
                                />
                                <b>Analytics</b>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'admin-scheduling'}" class="nav-link">
                            <div class="item">
                                <img
                                    src="/public/icon/schedulingIcon.svg"
                                    width="25px"
                                    alt=""
                                />
                                <b>Scheduling</b>
                            </div>
                        </router-link>
                    </li>
                    <li class="nav-item" @click="showAccount">
                        <a class="nav-link">
                            <div class="item">
                                <img
                                    src="/public/icon/accountsIcon.svg"
                                    width="25px"
                                    alt=""
                                />
                                <b>Accounts</b>
                            </div>
                            <div class="other">
                                <p>></p>
                            </div>
                        </a>
                    </li>

                    <!--account option animation  -->
                    <div
                        class="account-option"
                        :class="{ accountStyle: isAccountStyle }"
                    >
                        <li class="nav-item">
                            <router-link :to="{ name: 'create-user' }" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>New User</b>
                                </div>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'admin-user-list'}" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>User List</b>
                                </div>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>User Roles</b>
                                </div>
                            </a>
                        </li>
                    </div>
                    <!--end account option animation-->

                    <li class="nav-item" @click="showSetings">
                        <a class="nav-link">
                            <div class="item">
                                <img
                                    src="/public/icon/analyticsIcon.svg"
                                    width="25px"
                                    alt=""
                                />
                                <b>Settings</b>
                            </div>
                            <div class="other">
                                <p>></p>
                            </div>
                        </a>
                    </li>

                    <!-- show settings animation -->
                    <div
                        class="setting-option"
                        :class="{ settingStyle: isSettingStyle }"
                    >
                        <li class="nav-item">
                            <a href="" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>Company Profile</b>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-white">
                                <div class="item">
                                    <img
                                        src="/public/icon/inventoryIcon.svg"
                                        width="25px"
                                        alt=""
                                    />
                                    <b>Change password</b>
                                </div>
                            </a>
                        </li>
                    </div>
                    <!-- end settings animation -->
                    <li class="nav-item" @click="logout">
                        <a href="" class="nav-link text-danger"
                            ><b>Logout</b></a
                        >
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</template>

<script setup>
import { ref } from "vue";

//inventory option animation
const isInventory = ref(false);
const showInventory = () => {
    if (isInventory.value == false) {
        isInventory.value = true;
    } else if (isInventory.value == true) isInventory.value = false;
};

//account option animation
const isAccountStyle = ref(false);
const showAccount = () => {
    if (isAccountStyle.value == false) {
        isAccountStyle.value = true;
    } else if (isAccountStyle.value == true) {
        isAccountStyle.value = false;
    }
};

//setting option animation
const isSettingStyle = ref(false);
const showSetings = () => {
    if (isSettingStyle.value == false) {
        isSettingStyle.value = true;
    } else if ((isSettingStyle.value = true)) {
        isSettingStyle.value = false;
    }
};

//logout method
const logout = () => {
    localStorage.removeItem("responseTKN");
    localStorage.removeItem("administrationPermission");
    localStorage.removeItem("inventoryManagerPermission");
};
</script>
<style scoped>
aside {
    left: 0;
    position: relative;
    height: 100vh;
    background: rgb(241, 237, 237);
    width: 15rem;
}
aside .navbar {
    display: grid;
}
aside .nav-item {
    width: 15rem;
    padding: 10px;
    cursor: pointer;
}
aside .nav-item:hover {
    background: rgb(204, 202, 202);
}
aside .title-dashboard {
    border-radius: 15px;
    background: white;
    padding: 10px;
    text-align: center;
}
aside .title-dashboard:hover {
    background: white;
}
aside .nav-item a {
    color: gray;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
aside .other {
    height: 35px;
}
aside .other p {
    font-size: 20px;
    font-weight: 800;
}
aside .item {
    display: flex;
    gap: 15px;
}
aside .inventory-option {
    height: 0;
    overflow: hidden;
    transition: all linear 0.2s;
    background: #90a4df;
}
aside .inventoryOptionStyle {
    height: 120px;
}
aside .account-option {
    height: 0;
    overflow: hidden;
    transition: all linear 0.2s;
    background: #90a4df;
}
aside .accountStyle {
    height: 180px;
}
aside .setting-option {
    height: 0;
    overflow: hidden;
    transition: all linear 0.2s;
    background: #90a4df;
}
aside .settingStyle {
    height: 120px;
}
</style>
