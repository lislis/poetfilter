<script setup>
 import {usePoetStore} from '@/stores/poets';
 import { storeToRefs } from 'pinia';
 import {onMounted, computed, reactive} from 'vue'
 import { hasFilter, isAlpha, hasWebsite, hasInsta, hasX, hasTiktok  } from '@/utils';
 import FilterHeader from '@/components/FilterHeader.vue';

 const store = usePoetStore();
 let { poets, columns } = storeToRefs(store);
 const { fetchPoets, filterPoets } = store;

 const cols2Display = ['name', 'city', 'country', 'website', 'facebook', 'alpha', 'pronouns', 'instagram', 'twitter', 'tiktok'];

 const filters = cols2Display.reduce((acc,curr)=> (acc[curr]='',acc),{});

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

            <table>
                <thead>
                    <tr>
                        <template v-for="column in columns" >
                            <th v-if="cols2Display.includes(column)">
                                <FilterHeader :column="column" @filterFunc="filterMe"  />
                            </th>
                        </template>
                    </tr>
                </thead>

                <tbody v-if="poets.length">
                    <tr v-for="poet in poets">
                        <td>{{ poet.name }}</td>
                        <td>{{ poet.city }}</td>
                        <td>{{ poet.country }}</td>
                        <td v-html="hasWebsite(poet.website)"></td>
                        <td>{{ isAlpha(poet.alpha) }}</td>
                        <td>{{ poet.pronouns }}</td>
                        <td v-html="hasInsta(poet.instagram)"></td>
                        <td v-html="hasX(poet.twitter)"></td>
                        <td v-html="hasTiktok(poet.tiktok)"></td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>Keine Poet*innen gefunden</tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>Laden</p>
        </div>
    </main>
</template>
