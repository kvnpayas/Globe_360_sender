import axios from 'axios';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

export const logContent = ref('');

export const fetchLogs = async () => {
  try {
    const response = await axios.get('/logs');

    logContent.value = response.data.logs;
  } catch (error) {
    console.error('Error fetching logs:', error);
  }
};