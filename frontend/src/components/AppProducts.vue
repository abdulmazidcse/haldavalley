<template>
  <div class="product-list"> 
    <div v-if="isLoading">Loading products...</div>
    <div v-if="errorMessage">{{ errorMessage }}</div>
    <ProductCard
      v-for="product in products"
      :key="product.id"
      :product="product"
      @add-to-cart="handleAddToCart"
    />
  </div>
</template>

<script>
import ProductCard from '../components/ProductCard.vue';
import { ref, onMounted, getCurrentInstance } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  components: {
    ProductCard,
  },
  setup() {
    const products = ref([]);
    const isLoading = ref(false);
    const errorMessage = ref(null);
    const toast = useToast();
    
    const app = getCurrentInstance();
    const app2 = app?.appContext.config.globalProperties || {};

    const fetchProducts = async () => {
      isLoading.value = true;
      errorMessage.value = null;

      try {
        if (!app2.apiUrl) {
          throw new Error("API URL is not defined in globalProperties");
        }
        console.log(app2.headerjson);
        
        const response = await axios.get(`${app2.apiUrl}/products`, app2.headerjson);

        console.log("API response:", response.data);

        if (response.data && response.data.data) {
          products.value = response.data.data;
          toast.success("Products loaded successfully!");
        } else {
          throw new Error("Unexpected response structure from API");
        }
      } catch (error) {
        console.error("Error fetching products:", error);
        errorMessage.value = error.response?.data?.message || "Failed to load products. Please try again.";
        toast.error(errorMessage.value);
      } finally {
        isLoading.value = false;
      }
    };

    const handleAddToCart = (product) => {
      console.log("Product added to cart:", product);
      toast.success(`${product.name} added to cart!`);
    };

    // Trigger fetchProducts on component mount
    onMounted(() => {
      console.log("Component mounted, fetching products...");
      fetchProducts();
    });

    return {
      products,
      isLoading,
      errorMessage,
      handleAddToCart,
    };
  },
};
</script>


<style>
.product-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}
</style>

  <style scoped>
  .product {
    padding: 20px;
  }
  
  .product h1 {
    font-size: 24px;
    color: #333;
  }

  .product-list {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }
  </style>
  