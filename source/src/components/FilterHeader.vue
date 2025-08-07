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
         isJobCol() {
             return this.column === 'bookable_as';
         }
     }
 }

</script>

<template>
    {{ column }}
    <template v-if="isFilter">
        <template v-if="isJobCol">
            <button @click="toggleMe" :title="`${column} Optionen ausklappen`">👇</button>
            
            <div v-if="toggle">
            <label><input type="checkbox" name="poet" data-value="0">Poet*in</label><br>
            <label><input type="checkbox" name="orga" data-value="1">Veranstalter*in</label><br>
            <label><input type="checkbox" name="mc" data-value="2">Moderator*in</label><br>
            <label><input type="checkbox" name="feat" data-value="3">Featured Artist</label>
            </div>
        </template>
        <template v-else>
            <button v-if="toggle" @click="toggleMe" :title="`Filter Spalte ${column}`">🔍</button>
            <input v-else type="text" :name="column" @input="filterFunc" @blur="toggleMe" />
        </template>
    </template>
    
</template>

<style scoped>
 button {
     background-color: #0000ff;
     border: none;
     border-radius: 15%;
     cursor: pointer;
     margin-left: .5em;
 }
</style>
