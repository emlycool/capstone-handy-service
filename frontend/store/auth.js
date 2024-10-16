export const state = () => ({
    bearerToken: null,
  })
  
  export const mutations = {
    setBearerToken(state, token) {
      state.bearerToken = token;
      localStorage.setItem('bearerToken', token); // Save token to localStorage
    },
    clearBearerToken(state) {
      state.bearerToken = null;
      localStorage.removeItem('bearerToken'); // Remove token from localStorage
    }
  }
  
  export const getters = {
    bearerToken(state) {
      return state.bearerToken;
    },
    isLoggedIn(state) {
      return !!state.bearerToken; // Check if token exists (truthy value)
    }
  }
  
  export const actions = {
    setBearerToken({ commit }, token) {
      commit('setBearerToken', token);
    },
  
    async login({ commit }, { email, password }) {
      try {
        // Make login request using Axios
        const response = await this.$axios.post('/api/v1/auth/login', { email, password });
        const token = response.data.data.auth.token;
        
        // Set token in the store and localStorage
        commit('setBearerToken', token);
  
        // Optionally set the token in axios for all future requests
        // this.$axios.setToken(token, 'Bearer');
        return response
      } catch (error) {
        console.error('Error logging in:', error);
        throw error; // Handle error in the component
      }
    },
  
    initializeAuth({ commit, state }) {
      // Check if token exists in localStorage and set it in the store
      const token = localStorage.getItem('bearerToken');
      
      if (token) {
        commit('setBearerToken', token);
      }
    },
  
    logout({ commit }) {
      // Clear token from Vuex and localStorage
      commit('clearBearerToken');
      // this.$axios.setToken(false); // Optionally unset axios token
    }
  }
  