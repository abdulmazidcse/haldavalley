<template>
  <div class="login-container">
    <div class="login-box">
      <h2>Login to POS Admin</h2>
      <form @submit.prevent="handleLogin">
        <input type="text" v-model="username" placeholder="Username" required />
        <input type="password" v-model="password" placeholder="Password" required />

        <button type="submit" :disabled="disabled">
          <font-awesome-icon icon="spinner" spin  v-if="isSubmit"/> 
          Login
        </button>
      </form>
    </div>
  </div>
</template>

<script> 
 import {
  ref,
  getCurrentInstance,
} from "vue";
import axios from "axios"; 
import { useStore } from "vuex";
import { useToast } from 'vue-toastification'; 
// import { useRouter } from 'vue-router';

export default {
  setup() {
    const username = ref('');
    const password = ref(''); 
    const isSubmit = ref(false); // Shows spinner
    const disabled = ref(false); // Disables button while processing
    const toast = useToast();
    const store = useStore(); // Correctly initialize the store
    const app = getCurrentInstance();
    const app2 = app.appContext.config.globalProperties;

    const handleLogin = () => {
      isSubmit.value = true;
      disabled.value = true;
      const formData = new FormData();  
      formData.append('email', username.value );
      formData.append('password', password.value);  
      axios.post(app2.apiUrl + '/login', formData, app2.headers)
        .then(res => {  
          // Commit to Vuex store
          toast.success("Login Success");
          store.commit("login/UPDATE_USER", res.data.data.user);
          store.commit("login/UPDATE_USER_TOKEN", res.data.data.access_token);          
          // After successful login, redirect to the dashboard 
          window.location.href = "/";
          
        })
        .catch(res => {
          console.error('Login failed:', res);
          if (res.response) {
            toast.error(res.response.data.error);
            // console.error('Response data:', res.response.data.error); // Show server response
            // console.error('Response data:', res.response.data.message); // Show server response
          }
        })
        .finally (res => {
          isSubmit.value = false;
          disabled.value = false; 
          // toast.info("Info toast");          
          // toast.warning("Warning toast");

        });
    };

    return {
      username,
      password,
      handleLogin,
      disabled,
      isSubmit
    };
  },
}
</script>

<style scoped>
/* Centering the login box in the middle of the viewport */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  width: 100vw;
  background-color: #eaeaea;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

/* Centering the login-box within .login-container */
.login-box {
  background-color: #fff;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
  text-align: center;
  box-sizing: border-box;
}

/* Header styling */
.login-box h2 {
  margin-bottom: 20px;
  color: #2c3e50;
  font-size: 24px;
}

/* Form input styling */
.login-box input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  box-sizing: border-box;
}

/* Button styling */
.login-box button {
  width: 100%;
  padding: 12px;
  background-color: #1abc9c;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.login-box button:hover {
  background-color: #16a085;
}
</style>
