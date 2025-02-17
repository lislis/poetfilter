<script >
 import { hasFilter } from '@/utils.js';

 export default {
     props: ['column', 'filterFunc'],
     emits: ['filtering'],
     data() {
         return {
             toggle: true,
         }
     },
     methods: {
         filterFunc(ev) {
             this.$emit('filterFunc', ev);
         },
         toggleMe() {
             this.toggle = !this.toggle;
         }
     },
     computed: {
         isFilter() {
             return hasFilter(this.column);
         },
     }
 }

</script>

<template>
    {{ column }}
    <template v-if="isFilter">
        <button v-if="toggle" @click="toggleMe" :title="`Filter Spalte ${column}`">🔍</button>
        <input v-else type="text" :name="column" @input="filterFunc" @blur="toggleMe" />
    </template>
</template>
