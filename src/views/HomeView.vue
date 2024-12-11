<script setup>
 import {usePoetStore} from '@/stores/poets';
 import { storeToRefs } from 'pinia';
 import {onMounted} from 'vue'

 const store = usePoetStore();

 let { poets } = storeToRefs(store);

 const { fetchPoets } = store;


 onMounted(async () => {
     poets = await fetchPoets();
     console.log(poets)
 })

</script>

<template>
  <main>
      Hello alphas

      <div v-if="poets && poets.length"></div>
  </main>
</template>
