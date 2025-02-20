<script setup>
 import {usePoetStore} from '@/stores/poets';
 import { storeToRefs } from 'pinia';
 import {onMounted, computed, reactive} from 'vue'
 import { hasFilter, isAlpha, hasWebsite, hasInsta, hasX, hasTiktok  } from '@/utils';
 import FilterHeader from '@/components/FilterHeader.vue';
 import SinglePoet from '@/components/SinglePoet.vue';

 const store = usePoetStore();
 let { poets, columns } = storeToRefs(store);
 const { fetchPoets, filterPoets } = store;

 const cols2Display = window.poetfilterData.cols2Display;
 const filters = cols2Display.reduce((acc,curr)=> (acc[curr]='',acc),{});

 const cols2Filter = window.poetfilterData.cols2Filter;

 function filterMe(ev) {
     const fieldName = ev.target.name;
     const fieldValue = ev.target.value.toLowerCase();

     filterPoets(fieldName, fieldValue);
 }

 onMounted(() => {
     fetchPoets();
     console.log(columns)
 })

</script>

<template>
    <main>
        <div v-if="poets">

            <div class="pf-table">
                <div class="pf-tableheader">
                    <div v-for="col in cols2Filter">
                        <FilterHeader :column="columns[columns.indexOf(col)]" @filterFunc="filterMe" />
                    </div>
                </div>
                <ol class="pf-tablebody" v-if="poets.length">
                    <li class="pf-tableitem" v-for="poet in poets">
                        <SinglePoet :poet="poet" />
                    </li>
                </ol>
                <div v-else>Keine Poet*innen gefunden.</div>
            </div>
        </div>
        <div v-else>
            <p>Laden</p>
        </div>
    </main>
</template>

<style scoped>
 .pf-tableheader {
     display: grid;
     grid-template-columns: 1fr 1fr 1fr;
     grid-auto-columns: 1fr;
 }
 .pf-tablebody {
     list-style: none;
     margin: 0;
     padding: 0;
 }
 .pf-tableheader {
     padding: 1em;
     font-weight: bold;
     text-transform: uppercase;
 }
 .pf-tableitem {
     border-bottom: 2px solid black;
 }
</style>
