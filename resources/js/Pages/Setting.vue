<script setup>
import { useForm } from '@inertiajs/vue3';
import { useStore } from 'vuex';
import { computed } from 'vue';

const store = useStore();

const props = defineProps({
  settings: Object,
});

const form = useForm({
  appKey: props.settings ? props.settings.app_key : null,
  appSecret: props.settings ? props.settings.app_secret : null,
  shortcodeMask: props.settings ? props.settings.shortcode_mask : null,
})

const saveSettings = () => {
  form.post('/setting/create', {
    onError: () => form.reset("appKey", "appSecret"),
  });

  setTimeout(() => {
    form.wasSuccessful = false;
  }, 1000);
}

const startProcess = computed(() => store.state.startProcess);
</script>

<template>
  <div class="flex flex-col justify-between mx-auto max-w-7xl py-10 px-4">
    <transition name="alert">
      <div v-if="form.isDirty"
        class="w-full bg-yellow-500 text-white font-semibold px-4 py-1.5 my-2 rounded-md shadow-xl border border-light">
        There are unsaved form changes.</div>
    </transition>
    <transition name="alert">
      <div v-if="form.recentlySuccessful"
        class="w-full bg-green-700 text-white font-semibold px-4 py-1.5 my-2 rounded-md shadow-xl border border-light">
        Saved!
      </div>
    </transition>
    <div class="border border-light w-full rounded-md shadow-xl">
      <div class="p-4 border-b-2">
        <h1 class="text-2xl uppercase font-extrabold text-secondary">APP Settings</h1>
      </div>
      <div class="p-4 grid w-full sm:w-1/2">
        <p class="text-accent font-semibold text-sm my-5">Please enter APP credentials to enable SMS functionality.
        </p>
        <form @submit.prevent="saveSettings">
          <div class="mb-4">
            <label for="apiKey" class="block text-sm font-medium text-gray-700">App Key</label>
            <input type="password" v-model="form.appKey" placeholder="Enter your App Key"
              class="mt-1 block w-full border rounded-md shadow-sm p-1.5 text-xs focus:border-secondary "
              :class="{ 'border-red-500': form.errors.appKey, 'border-gray-300': !form.errors.appKey, 'bg-light': startProcess  }"
              :disabled="startProcess">
            <small class="text-red-500 font-semibold">{{ form.errors.appKey }}</small>
          </div>
          <div class="mb-4">
            <label for="apiSecret" class="block text-sm font-medium text-gray-700">App Secret</label>
            <input type="password" v-model="form.appSecret" placeholder="Enter your App Secret"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm  p-1.5 text-xs"
              :class="{ 'border-red-500': form.errors.appSecret, 'border-gray-300': !form.errors.appSecret, 'bg-light': startProcess  }"
              :disabled="startProcess">
            <small class="text-red-500 font-semibold">{{ form.errors.appSecret }}</small>
          </div>
          <div class="mb-4 w-full sm:w-1/2">
            <label for="apiSecret" class="block text-sm font-medium text-gray-700">Shortcode Mask</label>
            <input type="text" v-model="form.shortcodeMask" placeholder="Enter your Shortcode Mask"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm  p-1.5 text-xs"
              :class="{ 'border-red-500': form.errors.shortcodeMask, 'border-gray-300': !form.errors.shortcodeMask, 'bg-light': startProcess  }"
              :disabled="startProcess">
            <small class="text-red-500 font-semibold">{{ form.errors.shortcodeMask }}</small>
          </div>
          <button type="submit"
            :class="{ 'text-white px-4 py-2 rounded-md': true, 'bg-primary': !form.processing && !startProcess, 'bg-gray-400': form.processing || startProcess }"
            :disabled="form.processing || startProcess">Save Settings</button>
        </form>
        <p class="mt-4 text-sm text-gray-500">Keep your APP credentials secure and do not share them with unauthorized
          individuals.</p>
      </div>
    </div>
  </div>
</template>