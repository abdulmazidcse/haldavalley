import { createStore } from 'vuex' 
import cart from './modules/cart';
import login from './modules/login'; 
import createPersistedState from "vuex-persistedstate";
export default createStore({
  modules: { 
    cart,
    login, 
  },
  plugins: [createPersistedState()],
})