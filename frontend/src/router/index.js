import { createRouter, createWebHistory } from 'vue-router';
import store from '../store'; // Import the Vuex store
import Login from '../components/AppLogin.vue';
import Dashboard from '../components/AppDashboard.vue';
import Pos from '../components/AppPOS.vue';
import Inventory from '../components/AppInventory.vue';
import Products from '../components/AppProducts.vue';
import DateWiseSalesReport from '../components/reports/DateWiseSalesReport.vue';
import ProductWiseSalesReport from '../components/reports/ProductWiseSalesReport.vue';
import ProductWiseStockReport from '../components/reports/ProductWiseStockReport.vue';

const routes = [
  { path: '/login', name: 'Login', component: Login },
  { path: '/', name: 'Dashboard', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/pos', name: 'Pos', component: Pos, meta: { requiresAuth: true } },
  { path: '/inventory', name: 'Inventory', component: Inventory, meta: { requiresAuth: true } },
  { path: '/products', name: 'Products', component: Products, meta: { requiresAuth: true } },
  { path: '/date-wise-sales-report', name: 'DateWiseSalesReport', component: DateWiseSalesReport, meta: { requiresAuth: true } },
  { path: '/product-wise-sales-report', name: 'ProductWiseSalesReport', component: ProductWiseSalesReport, meta: { requiresAuth: true } },
  { path: '/product-wise-stock-report', name: 'ProductWiseStockReport', component: ProductWiseStockReport, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard to check for authentication
router.beforeEach((to, from, next) => { 
  const isAuthenticated = !!store.getters['login/token']; 
  if (to.name !== 'Login' && !isAuthenticated) {
    next({ name: 'Login' }); // Redirect to login if not authenticated
  } else {
    next(); // Proceed as normal
  }
});

export default router;
