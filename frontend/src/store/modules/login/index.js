import axios from 'axios';
import router from '../../../router'
const state = {
  userData: '',
  token:''
}
const mutations = {
  UPDATE_USER (state, payload) {
    state.userData = payload;
  },
  UPDATE_USER_TOKEN (state, payload) {
    state.token = payload;
  },
  LOGOUT: (state) =>{  
    state.userData = '';
    state.token ='';   
    router.push("/login");
    //window.location.href = "Login"   
  },
}

const actions = {   
  login({ commit }, user) {  
    console.log('Login Data',user); 
  },
  logout ({ commit }) { 
    commit('LOGOUT', '')
  }, 
}

const getters = {
  userData: state => state.userData,
  token: state => state.token
}

const LoginModule = {
  namespaced: true, // Add namespaced to the module
  state,
  mutations,
  actions,
  getters
};

export default LoginModule;