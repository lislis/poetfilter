import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import Papa from 'papaparse';

export const usePoetStore = defineStore('poets', () => {
  let original = ref([]);
  let poets = ref([]);
  let columns = ref([]);
  let jobs = new Set();
  let columnSearch = new Map();
  
  function fetchPoets() {
    // dev
    // /data/alphas20241211.csv
    Papa.parse(window.poetfilterData.dataUrl, {
      download: true,
      header: true,
      complete: (results) => {
        let r = results.data.filter(x => x['id'] != "");
        r.map(x => {
          try {
            x.bookable_as = JSON.parse(x.bookable_as);
          } catch {
            x.bookable_as = [];
          }
          return x;
        })
        original.value = r;
        poets.value = r;

        columns.value = results.meta.fields;
      }
    });
  }

  function metaFilter() {
    poets.value = original.value
      .filter(x => {
        if (jobs.size > 0) {
          return x.bookable_as.some(r => Array.from(jobs).includes(r))
        } else {
          return true
        }
      }).filter(x => {
        if (columnSearch.size > 0) {
          return columnSearch.entries().some(([index, value]) => {
            return x[index].toLowerCase().includes(value);
          })
        } else {
          return true
        }
      })
  }

  function filterPoets(column, myfilter) {
    if (myfilter.length == 0) {
      columnSearch.delete(column);
    } else {
      columnSearch.set(column, myfilter);
    }
    
    metaFilter();
  }

  function filterPoetsByJob(index) {
    if (jobs.has(index)) {
      jobs.delete(index);      
    } else {
      jobs.add(index);      
    }

    metaFilter();
  }

  return { poets, columns, fetchPoets, filterPoets, filterPoetsByJob }
})
