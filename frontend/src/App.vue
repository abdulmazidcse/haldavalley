<template>
  <div id="app">
    <template v-if="isLoggedIn">
      <AppSidebar />
      <div class="main">
        <AppHeader />
        <div class="body-content"><router-view /> </div><!-- Render the current route content here -->
        <AppFooter />
      </div>
    </template>
    <template v-else>
      <router-view /> <!-- Renders the login page if not logged in -->
    </template>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed } from 'vue';
import AppHeader from './components/include/AppHeader.vue';
import AppSidebar from './components/include/AppSidebar.vue'; 
import AppFooter from './components/include/AppFooter.vue';

export default {
  components: {
    AppFooter,
    AppHeader,
    AppSidebar,
  },
  setup() { 
    const store = useStore();
    // Computed property to check if user is logged in based on the token in Vuex
    const isLoggedIn = computed(() => !!store.getters['login/token']); // Use the correct namespaced path

    return {
      isLoggedIn,
    };
  },
};
</script>


<style>
/* Ensure the HTML and body fill the viewport */
html, body, #app {
  height: 100%;
  margin: 0;
  padding: 0;
  overflow: hidden; /* Prevent scrolling on the main body */
}

.body-content {
  flex: 1; /* Makes this div take up the available space */
  overflow-y: auto; /* Adds scrolling if the content overflows */
  padding: 20px; /* Optional padding for better spacing */
}

/* Main container with flexbox for the sidebar and main content */
#app {
  display: flex;
  min-height: 100vh;
}

button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

/* Sidebar styling */
.sidebar {
  width: 250px;
  background-color: #2c3e50;
  color: #ecf0f1;
  padding: 20px;
  overflow-y: auto; /* Scrollable sidebar if content overflows */
}

/* Main content area */
.main {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden; /* Prevent scrolling on the main container */
  width: calc(100vw - 250px); /* Ensures it fills the remaining width next to the sidebar */
  height: auto;
  overflow: scroll;
}
/* Header styling */
.header {
  background-color: #34495e;
  color: #ecf0f1;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Content area inside the main container */
.content {
  flex: 1;
  overflow-y: auto; /* Scrollable content area */
  padding: 20px;
  background-color: #f4f6f9;
}

/* Footer styling */
.footer {
  background-color: #2c3e50;
  color: #ecf0f1;
  padding: 15px;
  text-align: center;
}
</style>