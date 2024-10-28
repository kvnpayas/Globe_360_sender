<script setup>
import Nav from '../Layouts/Nav.vue';
import { useStore } from 'vuex';
import { ref, computed } from 'vue';

const pathInput = ref('');
const store = useStore();

const startProcessButton = () => {
  store.dispatch('startProcess', pathInput.value);
};

const cancelProcessButton = () => {
  store.dispatch('cancelProcess');
};

store.dispatch('processFiles');

const startProcess = computed(() => store.state.startProcess);
const checkFiles = computed(() => store.state.checkFiles);
const error = computed(() => store.state.error);

</script>
<style>
.process-div {
  transition: min-height 0.5s ease-in-out, max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
  background-color: rgb(231, 228, 228);
}
</style>
<template>
  <div class="flex space-x-4 justify-center">
    <div>
      <div
        :class="{ 'flex flex-col justify-center min-w-80 mt-10 space-x-5 p-10 shadow-2xl rounded-md process-div overflow-hidden': true, 'min-h-56 max-h-56': startProcess, 'max-h-60 min-h-60': !startProcess }">
        <div class="text-center flex flex-col space-y-2" v-if="!startProcess">
          <button @click="startProcessButton"
            class=" text-white font-semibold px-5 py-1.5 text-xs rounded-sm shadow-xl hover:scale-110 transition-all duration-500"
            :class="{ 'bg-green-500': !startProcess, 'bg-light': startProcess }" :disabled="startProcess">Start
            Processing SMS</button>
          <input type="text" class="text-xs p-1 text-accent" v-model="pathInput" placeholder="Enter Folder Path">
          <div v-if="error">
            <span v-if="error.code == 400" class="text-red-500 text-xs font-semibold">{{ error.message }}</span>
            <span v-else class="text-red-500 text-xs font-semibold">Wrong App Key or App Secret.</span>
          </div>
        </div>
        <div
          :class="{ 'transition-opacity duration-1000': true, 'opacity-100': startProcess, 'opacity-0': !startProcess }">
          <div class="text-center" v-if="startProcess">
            <button @click="cancelProcessButton"
              class=" text-white font-semibold px-5 py-1.5 text-xs rounded-sm shadow-xl hover:scale-110 transition-all duration-500"
              :class="{ 'bg-red-500': startProcess, 'bg-light': !startProcess }" :disabled="!startProcess">Stop</button>
          </div>
          <div class="flex flex-col" v-if="startProcess">
            <div class="flex justify-center pt-5">
              <ul>
                <li>
                  <div class="loader">
                    <div class="child"></div>
                  </div>
                </li>

                <li>
                  <div class="text font-semibold text-xs"></div>
                </li>
              </ul>
            </div>
            <div class=" text-center pt-5">
              <span class="block text-sm uppercase font-semibold text-green-500">{{ checkFiles }}</span>
              <span v-if="pathInput" class="block text-sm font-semibold text-primary">PATH: {{ pathInput }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>