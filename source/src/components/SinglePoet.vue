<script>
 import { fieldFormating } from '@/utils';

 export default {
     props: ['poet'],
     data() {
         return {
             cols2Filter: window.poetfilterData.cols2Filter,
             cols2Display: window.poetfilterData.cols2Display,
             toggle: false,
         }
     },
     methods: {
         toggling() {
             this.toggle = !this.toggle;
         },
         fieldFormating(col, val) {
             return fieldFormating(col, val);
         }
     }
 }
</script>
<template>
    <header @click="toggling">
        <div v-for="col in cols2Filter">{{poet[col]}}</div>
    </header>
    <div class="pf-hidden" v-if="toggle">
        <span class="pf-bits"
              v-for="col in cols2Display"
              v-html="fieldFormating(col, poet[col])"></span>
    </div>
</template>

<style scoped>
 .pf-tableitem header {
     display: grid;
     grid-template-columns: 1fr 1fr 1fr;
     grid-auto-columns: 1fr;
 }
 header:hover {
     cursor: pointer;
     color: white;
     background-color: #0000ff;
 }

 header > div {
     padding: .5em .5em .4em;
 }
 .pf-hidden {
     display: flex;
     flex-wrap: wrap;
     padding: .5em .5em .4em;
 }
 .pf-bits:not(:empty) {
     margin-right: 2em;
     padding: 0.3em 0;
 }
</style>
