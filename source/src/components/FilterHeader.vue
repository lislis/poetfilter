<script >
 import { hasFilter } from '@/utils.js';

 export default {
     props: ['column', 'filterFunc'],
     emits: ['filtering'],
     data() {
         return {
             toggle: true,
             jobDict: {},
         }
     },
     mounted() {
         this.jobDict = {}
         window.poetfilterData.jobDict.map((x, ind) => this.jobDict[ind] = x)
     },
     methods: {
         filterFunc(ev) {
             this.$emit('filterFunc', ev);
         },
         toggleMe() {
             this.toggle = !this.toggle;
         },
         filterJobs(ev) {
             this.$emit('filterJob', ev.target.dataset.value); 
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
    <span>{{ column }}</span>
    <template v-if="isFilter">
        <template v-if="isJobCol">
            <button @click="toggleMe" :title="`${column} Optionen ausklappen`">
                <span v-if="toggle">👇</span>
                <span v-else>👍</span>
            </button>
            <div v-if="!toggle && jobDict">
                <template  v-for="([key, value], index) in Object.entries(jobDict)">
                <label><input type="checkbox" :name="value" :data-value="key" @change="filterJobs">{{value}}</label><br>
                </template>
            </div>
        </template>
        <template v-else>
            <button @click="toggleMe" :title="`Filter Spalte ${column}`">
                <span v-if="toggle">👇</span>
                <span v-else>👍</span>
            </button>
            <div v-if="!toggle">
                <input type="text" :name="column" @input="filterFunc" />
            </div>
            
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
