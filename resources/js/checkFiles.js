import { createStore } from 'vuex';
import { router } from '@inertiajs/vue3'

const store = createStore({
  state: {
    startProcess: false,
    checkFiles: 'Processing Files..',
    error: null,
    path: '',
  },
  mutations: {
    setStartProcess(state, value) {
      state.startProcess = value;
    },
    setPath(state, path) {
      state.path = path;
    },
  },
  actions: {
    async processFiles({ state, dispatch }) {
      state.checkFiles = 'Processing Files..';
      console.log('Processing Files..');

      if (state.startProcess) {
        let processed = 0;
        let errorMessage = null;
        try {
          const filesProcessed = await axios.post('/check-files', { path: state.path });
          processed = filesProcessed.data.filesProcessed;
          errorMessage = filesProcessed.data.errorMessage
          if (filesProcessed.data.error) {
            console.log(filesProcessed.data.error)
            state.error = filesProcessed.data.error;
            state.startProcess = false;
            return
          }
        } catch (error) {
          console.error('Error checking files:', error);
        }

        if (processed) {
          console.log('Files processed:', processed);
          state.checkFiles = 'Files processed:' + processed;
          setTimeout(() => {
            dispatch('processFiles');
          }, 10000);
        } else {
          console.log('No files processed, waiting...');
          state.checkFiles = errorMessage ? errorMessage : 'No files detected, waiting...';
          setTimeout(() => {
            dispatch('processFiles');
          }, 10000);
        }
      }

    },
    startProcess({ commit, dispatch }, path) {
      commit('setStartProcess', true);
      commit('setPath', path);
      dispatch('processFiles');
    },
    cancelProcess({ commit }) {
      commit('setStartProcess', false);
    },
  },
});

export default store;
