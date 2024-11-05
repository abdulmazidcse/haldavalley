import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Import the router
import store from './store'; // Import Vuex store


import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faSpinner } from '@fortawesome/free-solid-svg-icons';


import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

library.add(faSpinner);


const app = createApp(App); 
app.use(store);
app.config.globalProperties.headers = {headers: {
                      'Authorization' : store.getters['login/token'] ? `Bearer ${store.getters['login/token']}` : "",
                      'Content-Type': 'multipart/form-data' 
                    }};
app.config.globalProperties.headerjson = {headers: {
                      'Authorization' : store.getters['login/token'] ? `Bearer ${store.getters['login/token']}` : "",
                      'Content-Type': 'application/json' 
                    }};

if((location.host == 'localhost:8080') || (location.host == '127.0.0.1:8080')){  
  let baseUrl =  "http://127.0.0.1:8000"; 
	app.config.globalProperties.apiUrl = baseUrl+"/api";
	app.config.globalProperties.baseUrl = baseUrl; 
}
// Use the router
app.use(router);
app.component('font-awesome-icon', FontAwesomeIcon);
app.use(Toast);
app.mount('#app');
