<script setup>
 import {usePoetStore} from '@/stores/poets';
 import { storeToRefs } from 'pinia';
 import {onMounted, computed, reactive} from 'vue'

 const store = usePoetStore();
 let { poets, columns } = storeToRefs(store);
 const { fetchPoets, filterPoets } = store;

 const cols2Display = ['name', 'city', 'country', 'website', 'facebook', 'alpha', 'pronouns', 'instagram', 'twitter', 'tiktok'];

 const filters = cols2Display.reduce((acc,curr)=> (acc[curr]='',acc),{});

 function filterMe(ev) {
     //console.log(ev)

     const fieldName = ev.target.name;
     const fieldValue = ev.target.value.toLowerCase();


     filterPoets(fieldName, fieldValue);
 }

 onMounted(() => {
     fetchPoets();
     console.log(columns)
 })

 function hasFilter(columnName) {
     const allowList = ["name", "city", "instagram"];
     return allowList.includes(columnName);
 }

 function isAlpha(pred) {
     return pred == "true" ? "☑️" : "";
 }

 function hasWebsite(pred) {
     return pred != "" ? `<a href="${pred}" target="_blank" rel="nofollow">🌐</a>` : "";
 }

 function hasInsta(pred) {
     return pred != "" ? `<a href="https://instagram.com/${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
 }

 function hasX(pred) {
     return pred != "" ? `<a href="https://x.com/${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
 }

 function hasTiktok(pred) {
     return pred != "" ? `<a href="https://tiktok.com/@${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
 }

</script>

<template>
  <main>
      <div v-if="poets">

          <table>
              <thead>
                  <tr>
                      <template v-for="column in columns" >
                          <th v-if="cols2Display.includes(column)">
                              {{ column }} <input v-if="hasFilter(column)" type="text" :name="column" @input="filterMe">
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
                  <tr>Keine Poet*innen</tr>
              </tbody>
          </table>

      </div>
      <div v-else>
          <p>Laden</p>
      </div>
  </main>
</template>
