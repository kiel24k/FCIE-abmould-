<template>
    <div class="mt-4">
      <div ref="scanner" class="scanner"></div>
      <div v-if="scanning" class="status">Scanning...</div>
      <div v-else class="status">Not Scanning</div>
 <div class="action text-center">
    <button @click="startScanning" class="btn btn-dark">Start Scanning</button>
    <button @click="stopScanning" class="btn btn-danger">Stop Scanning</button>
 </div>
    </div>


  </template>

  <script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import Quagga from 'quagga';

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
          width: 500,
          height: 480,
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
    emitBarcodeValue('barcodeValue', barcode.value)
    stopScanning(); // Automatically stop after detecting a barcode
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

<style>
.scanner {
  max-width: 500px;
  height: 480px;
  box-shadow: 0px 0px 10px 0px gray;
  margin: auto;
  display: block;
}
.status {
  text-align: center;
  margin: 10px 0;
}
.result {
  text-align: center;
  font-weight: bold;
}
.action{
    display: flex;
    gap:10px;
    justify-content: center;
}


</style>
