<template>
    <div class="report">
      <h2>Date-Wise Sales Report</h2>
      <div class="date-range">
        <label>Start Date:</label>
        <input type="date" v-model="startDate" />
        <label>End Date:</label>
        <input type="date" v-model="endDate" />
        <button @click="fetchReport">Generate Report</button>
      </div>
      <table v-if="reportData.length">
        <thead>
          <tr>
            <th>Date</th>
            <th>Total Sales</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in reportData" :key="item.sale_date">
            <td>{{ item.sale_date }}</td>
            <td>{{ item.total_sales }}</td>
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
      // Define reactive variables with ref
      const reportData = ref([]);
      const startDate = ref("");
      const endDate = ref("");
      const app = getCurrentInstance();
      const app2 = app?.appContext.config.globalProperties || {};
  
      // Fetch report function
      const fetchReport = async () => {
        if (!startDate.value || !endDate.value) {
          alert("Please select a valid date range.");
          return;
        } 
  
        try {
          // Perform axios request with parameters and headers
          const response = await axios.get(`${app2.apiUrl}/date-wise-sales-report`, {params: {
              start_date: startDate.value,
              end_date: endDate.value,
            }}, app2.headerjson,  );
          
          // Set the report data with the response data
          reportData.value = response.data;
        } catch (error) {
          console.error("Error fetching date-wise sales report:", error);
        }
      };
  
      // Return all variables and functions to the template
      return {
        reportData,
        startDate,
        endDate,
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
  
  .date-range {
    margin-bottom: 20px;
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
  