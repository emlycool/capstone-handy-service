
export const state = () => ({
    bearerToken: null,
    user: null
  })
  
  export const mutations = {
    setBearerToken(state, token) {
      state.bearerToken = token;
      localStorage.setItem('bearerToken', token); // Save token to localStorage
    },
    clearBearerToken(state) {
      state.bearerToken = null;
      localStorage.removeItem('bearerToken'); // Remove token from localStorage
    },
    setUser(state, user) {
      state.user = user;
      localStorage.setItem('user', JSON.stringify(user)); // Save user to localStorage
    },
    clearUser(state) {
      state.user = null;
      localStorage.removeItem('user'); // Remove user from localStorage
    }
  }
  
  export const getters = {
    bearerToken(state) {
      return state.bearerToken;
    },
    isLoggedIn(state) {
      return !!state.bearerToken; // Check if token exists (truthy value)
    },
    authUser(state) {
      console.log("user", state.user)
      return state.user;
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
        commit('setUser', response.data.data.user);
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
      let user = localStorage.getItem('user');
      
      if(user) {
        user = JSON.parse(user);
      }
      console.log("user stored", user);
      console.log("token stored", token);

      if (token && user) {
        commit('setBearerToken', token);
        commit('setUser', user);
      }
    },
  
    logout({ commit }) {
      // Clear token from Vuex and localStorage
      commit('clearBearerToken');
      commit('clearUser')
    }
  }
  