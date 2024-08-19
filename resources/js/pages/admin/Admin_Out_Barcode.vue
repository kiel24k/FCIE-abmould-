<template>
    <header>
        <Header/>
    </header>
    <div>
        <div id="scanner">
            <Scanner @barcodeValue="barcodeValue"/>
        </div>
    </div>
</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import Scanner from '@/components/Barcode_Scanner.vue'
import { ref, watch } from 'vue';




</script>

<style scoped>

</style>
