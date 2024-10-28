<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import axios from 'axios';
import { fetchLogs, logContent } from '../displayLogs';
import { router } from '@inertiajs/vue3'
import { useStore } from 'vuex';

const store = useStore();

// import { Inertia } from '@inertiajs/vue3';

// const filesProcessed = ref(0);

// const checkFiles = async () => {
//   try {
//     const response = await Inertia.get('/check-files', {}, { preserveState: true });
//     filesProcessed.value = response.props.filesProcessed;
//   } catch (error) {
//     console.error('Error checking files:', error);
//   }
// };

// onMounted(() => {
//   checkFiles();
//   const interval = setInterval(checkFiles, 60000); // Check every 1 minute

//   onUnmounted(() => {
//     clearInterval(interval);
//   });
// });
// const startProcess = ref(false);
// console.log(startProcess.value);
// const processFiles = async () => {
//   if (startProcess.value) {
//     console.log('Checking files...');
//     let processed = 0;
//     try {
//       const filesProcessed = await axios('/check-files')
//       processed = filesProcessed.data.filesProcessed;
//     } catch (error) {
//       console.error('Error checking files:', error);
//       // if (error.code === 'ECONNABORTED') {
//       //   console.error('Request timed out');
//       //   processed = filesProcessed.data.filesProcessed;
//       // }
//     }
//     if (processed) {
//       console.log('Files processed:', processed);
//       setTimeout(processFiles, 10000);

//     } else {
//       console.log('No files processed, waiting...');
//       setTimeout(processFiles, 10000);
//     }
//     console.log(startProcess.value);
//   }
// };

// const startProcessButton = () => {
//   startProcess.value = true;
//   console.log(startProcess.value);
//   processFiles();
// };
// const cancelProcessButton = () => {
//   startProcess.value = false;
//   console.log(startProcess.value);
//   processFiles();
// };
const startProcess = computed(() => store.state.startProcess);

const formatTime = (dateString) => {
  const options = {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: true
  };
  return new Date(dateString).toLocaleTimeString([], options);
}

onMounted(() => {
  fetchLogs();
  setInterval(fetchLogs, 1000); // Fetch logs every 5 seconds
});

onUnmounted(() => {
  clearInterval(fetchLogs);
});

</script>

<template>
  <div class="flex flex-col justify-between mx-auto max-w-7xl py-10 px-4 space-y-5">

    <div class="shadow-md border-2 rounded-md">
      <div class="bg-light p-2">
        <h3 class="text-xl uppercase font-extrabold text-secondary">Logs</h3>
      </div>
      <div class="w-full p-4">
        <!-- <pre>{{ logContent }}</pre> -->
        <table class="min-w-full divide-y divide-gray-200 border-gray-300 text-xs">
          <thead class="text-left bg-light  uppercase tracking-wider shadow-md">
            <tr>
              <th class="p-2">Number</th>
              <th class="p-2">Message</th>
              <th class="p-2">Code</th>
              <th class="p-2">Status</th>
              <th class="p-2">Timestamp</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="log in logContent" :key="log.id" class="border-b border-gray-300 font-semibold text-accent"
              :class="{ 'text-red-500': log.status == 0 }">
              <td class="p-2 whitespace-nowrap">{{ log.number }}</td>
              <td class="truncate max-w-xs">{{ log.message }}</td>
              <td>{{ log.code }}</td>
              <td>{{ log.status == 1 ? 'Sent' : 'Failed' }}</td>
              <td>{{ formatTime(log.created_at) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>