<template>
  <div class="">
    <div ref="scanner" class="scanner"></div>
    <Message v-if="scanning" severity="success"  icon="pi pi-barcode">Scanning...</Message>
    <Message v-else severity="error" icon="pi pi-barcode" >Not Scanning</Message>
    <div class="action">
      <Button @click="startScanning" severity="primary" label="Start Scan" v-if="scanning == false" />
      <Button @click="stopScanning" severity="danger" label="Stop Scan" v-else/>
    </div>
  </div>


</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import Quagga from 'quagga';
import { Button, Message } from 'primevue';

const scanner = ref(null);
const scanning = ref(false);
const barcode = ref(null);
const emitBarcodeValue = defineEmits(['barcodeValue'])

const startScanning = () => {
  scanning.value = true;
  Quagga.init(
    {
      inputStream: {
        name: 'Live',
        type: 'LiveStream',
        target: scanner.value,
        constraints: {
          width: 600,
          height: 500,
          facingMode: 'environment', // Use rear camera
        },
        area: { // defines rectangle of the detection/localization area
          top: "0%",    // top offset
          right: "0%",  // right offset
          left: "0%",   // left offset
          bottom: "0%"  // bottom offset
        },
      },
      decoder: {
        readers: ['code_128_reader', 'ean_reader', 'ean_8_reader'],
      },
    },

    (err) => {
      if (err) {
        console.error(err);
        return;
      }
      Quagga.start();
    }
  );

  Quagga.onDetected((result) => {
      const code = result.codeResult.code;
      barcode.value = code;     
      console.log(code);
      
      emitBarcodeValue('barcodeValue', barcode.value)
      stopScanning()
  });
};

const stopScanning = () => {
  scanning.value = false;
  Quagga.stop();
  Quagga.offDetected();
 
};



onMounted(() => {

  // Cleanup Quagga when the component is unmounted
  //   onUnmounted(() => {
  //     stopScanning();
  //   });

});
</script>

<style scoped>
@media screen and (min-width: 887px){
  .scanner {
    width: 604px;
    height: 500px;
    border:rgb(0, 0, 0) 2px solid;
    background: rgb(0, 0, 0);
   
  }
  .action{
    display: flex;
    gap:10px;
    justify-content: center;
    flex-wrap: wrap;
  }
  
 
  
 
  
 

}
</style>
