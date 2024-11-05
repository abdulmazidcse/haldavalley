<template>
  <div class="header">
    <div class="title">POS Admin Panel</div>
    <div class="user-info">
      <span>Welcome, Admin</span>
      <button @click="handleLogout">Logout</button>
    </div>
  </div>
</template>

<script> 
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

export default {
  setup() { 
    const router = useRouter();
    const store = useStore();
    const handleLogout = () => {
      store.commit('login/UPDATE_USER_TOKEN', '');
      store.commit('login/UPDATE_USER', null); 
      router.push('/login'); // Redirect to login page
    };

    return {
      handleLogout,
    };
  },
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background-color: #34495e;
  color: #ecf0f1;
}
.title {
  font-size: 20px;
  font-weight: bold;
}
.user-info span {
  margin-right: 10px;
}
</style>
