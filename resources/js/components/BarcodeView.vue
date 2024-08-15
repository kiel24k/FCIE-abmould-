<template>
    <div>
      <svg ref="barcode"></svg>
      <br>
      <br>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, watch } from 'vue';
  import JsBarcode from 'jsbarcode';

  const props = defineProps(['barcodeValue'])
  const barcode = ref(null);
  const generateBarcode = () => {
    JsBarcode(barcode.value, props.barcodeValue, {
      format: "CODE128",
      lineColor: "#000",
      width: 2,
      height: 100,
      displayValue: true,
    });
  };


  watch(props, (newVal, oldVal) => {
  generateBarcode()
  })
  onMounted(() => {
    generateBarcode()

  });








  </script>
