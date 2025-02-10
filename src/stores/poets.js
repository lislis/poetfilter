import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import Papa from 'papaparse';

export const usePoetStore = defineStore('poets', () => {
  let original = ref([]);
  let poets = ref([]);
  let columns = ref([]);

  function fetchPoets() {
    Papa.parse('/data/alphas20241211.csv', {
      download: true,
      header: true,
      complete: (results) => {
        let r = results.data.filter(x => x['id'] != "");
        original.value = r;
        poets.value = r;
        columns.value = results.meta.fields;
      }
    });
  }

  function filterPoets(column, filter) {
    poets.value = original.value
      .filter(x => Object.keys(x).includes(column))
      .filter(x => x[column].toLowerCase().includes(filter));

    if (filter.length == 0) poets.value = original.value;
  }

  return { poets, columns, fetchPoets, filterPoets }
})
