<template>
  <div class="pos">
    <!-- Left Side: Product Search and Selected Product List -->
    <div class="left-side">
      <div class="selected-products">
        <h3>Selected Products</h3>
        <table>
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Dis</th>
              <th>Subtotal</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in selectedProducts" :key="product.id">
              <td>{{ product.name }}</td>
              <td>{{ product.mrp_price }}</td>
              <td>{{ product.qty }}</td>
              <td><input style="width: 50px"type="text" v-model="product.dis" /></td>
              <td>{{ product.qty * product.mrp_price}}</td>
              <td>
                <button @click="removeFromSelected(product.id)">Remove</button>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td colspan="2"><button class="btn success" style="float: right;" @click="handleSubmit()">Submit</button></td>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>

    <!-- Right Side: All Products Displayed as Cards -->
    <div class="right-side">
      <div class="product-card" v-for="product in products" :key="product.id">
        <img :src="product.imageUrl" alt="Product Image" class="product-image" />
        <div class="product-info">
          <h4>{{ product.name }}</h4>
          <p>{{ product.price }}</p>
          <button @click="addToSelected(product)">Add to Cart</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from '../components/ProductCard.vue';
import { ref, onMounted, getCurrentInstance, computed } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  components: {
    ProductCard,
  },
  setup() {
    const searchQuery = ref("");
    const products = ref([]);
    const isLoading = ref(false);
    const errorMessage = ref(null);
    const toast = useToast();
    const isSubmit = ref(false); // Shows spinner
    const disabled = ref(false); // Disables button while processing 

    const app = getCurrentInstance();
    const app2 = app?.appContext.config.globalProperties || {};

    const fetchProducts = async () => {
      isLoading.value = true;
      errorMessage.value = null;

      try {  

        const response = await axios.get(`${app2.apiUrl}/products`, app2.headerjson); 
        if (response.data && response.data.data) {
          products.value = response.data.data;
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

    const selectedProducts = ref([]);

    const filteredProducts = computed(() => {
      return products.value.filter((product) =>
        product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      );
    }); 

    const addToSelected = (product) => {
      // Check if product already exists in selectedProducts
      const existingProduct = selectedProducts.value.find(
        (item) => item.id === product.id
      );

      if (existingProduct) {
        // If product exists, increment the quantity
        existingProduct.qty += 1;
      } else {
        // If product does not exist, add it with qty initialized to 1
        selectedProducts.value.push({ ...product, qty: 1, dis:0 });
      }
      toast.success(`added to cart!`);
    };

    const removeFromSelected = (productId) => {
      selectedProducts.value = selectedProducts.value.filter(
        (product) => product.id !== productId
      );
    };  
    
    const handleSubmit = async () => {
      if (selectedProducts.value.length === 0) { 
        toast.error('No products selected.');
        return;
      }

      // Prepare the order data with total calculation
      const orderData = selectedProducts.value.map((product) => {
        return {
          product_id: product.id,
          quantity: product.qty,
          mrp_price: product.mrp_price,
          discount: product.dis,
          total: product.qty * product.mrp_price, // Calculate total per item
        };
      });

      // Calculate the overall total
      const overallTotal = orderData.reduce((sum, item) => sum + item.total, 0);

      // Final data to be submitted
      const salesData = {
        items: orderData,
        total: overallTotal,
        sale_date: new Date().toISOString(), // Set to the current date and time
      };

      console.log("Sales Data to Submit:", salesData); // Log data for verification

      try {
        // Send salesData to backend API endpoint
        const response = await axios.post(`${app2.apiUrl}/sales`, salesData,  app2.headerjson);
        toast.success(`Order submitted successfully`); 

        // Clear the selected products after successful submission
        selectedProducts.value = [];
      } catch (error) {
        // Handle errors
        toast.error('Error submitting order.'); 
      }
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
      searchQuery,
      selectedProducts,
      filteredProducts,
      addToSelected,
      removeFromSelected, 
      handleSubmit
    };
  },
};
</script>


<style scoped>
.pos {
  display: flex;
  gap: 20px;
  padding: 20px;
}

.left-side {
  width: 65%;
  border-right: 1px solid #ddd;
  padding-right: 20px;
}

.search-section {
  margin-bottom: 20px;
}

.selected-products h3 {
  margin-top: 0;
}

.selected-products ul {
  list-style: none;
  padding: 0;
}

.selected-products ul li {
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

.right-side {
  width: 43%;
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.product-card {
  width: calc(33.333% - 10px);
  /* 3 cards per row */
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  padding: 10px;
  text-align: center;
}

.product-image {
  width: 100%;
  height: auto;
  max-height: 100px;
  object-fit: cover;
}

.product-info {
  margin-top: 10px;
}

button {
  background-color: #1abc9c;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
  background-color: #16a085;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

table th,
table td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ddd;
}

</style>