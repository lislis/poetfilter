import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const usePoetStore = defineStore('poets', () => {
  let poets = [];

  function fetchPoets() {
    return fetch('/data/alphas20241211.csv')
      .then(data => data.text())
      .then(resp => resp)
  }

  return { poets, fetchPoets }
})
