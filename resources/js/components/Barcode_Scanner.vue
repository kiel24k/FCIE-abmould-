<template>
    <div>
      <div ref="scanner" class="scanner"></div>
      <div v-if="scanning" class="status">Scanning...</div>
      <div v-else class="status">Not Scanning</div>
      <div v-if="barcode" class="result">
        Detected Barcode: {{ barcode }}
      </div>
      <button @click="startScanning">Start Scanning</button>
      <button @click="stopScanning">Stop Scanning</button>
    </div>
  </template>

  <script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Quagga from 'quagga';

const scanner = ref(null);
const scanning = ref(false);
const barcode = ref(null);

const startScanning = () => {
  scanning.value = true;
  Quagga.init(
    {
      inputStream: {
        name: 'Live',
        type: 'LiveStream',
        target: scanner.value,
        constraints: {
          width: 640,
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
  onUnmounted(() => {
    stopScanning();
  });
});
</script>

<style>
.scanner {
  width: 100%;
  max-width: 640px;
  height: 480px;
  border: 1px solid #000;
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
button {
  display: block;
  margin: 10px auto;
}
</style>
