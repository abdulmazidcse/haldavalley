<template>
    <div class="report">
      <h2>Product-Wise Stock Report</h2> 
      <div class="date-range"> 
        <button @click="fetchReport">Generate Report</button>
      </div>
      <table v-if="reportData.length">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Stock</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in reportData" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.quantity }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import { ref, getCurrentInstance } from 'vue';
  import axios from 'axios';
  
  export default {
    setup() {
      // Reactive variable for report data
      const reportData = ref([]); 
  
      // Access global properties (apiUrl and headerjson)
      const app = getCurrentInstance();
      const app2 = app?.appContext.config.globalProperties;
  
      // Fetch product-wise stock report
      const fetchReport = async () => {
        try {
            const response = await axios.get(`${app2.apiUrl}/product-wise-stock-report`, app2.headerjson,  );
          reportData.value = response.data;
        } catch (error) {
          console.error("Error fetching product-wise stock report:", error);
        }
      };
  
      // Return reactive data and methods to the template
      return {
        reportData,
        fetchReport,
      };
    },
  };
  </script>
  
  <style scoped>
  .report {
    max-width: 800px;
    margin: 0 auto;
  }
  
  button {
    margin-bottom: 20px;
    padding: 8px 12px;
    cursor: pointer;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  table, th, td {
    border: 1px solid #ddd;
  }
  
  th, td {
    padding: 10px;
    text-align: left;
  }
  </style>
  