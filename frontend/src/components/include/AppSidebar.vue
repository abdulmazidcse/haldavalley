<template>
    <div class="sidebar">
      <h2>POS Admin</h2>
      <ul>
        <li><router-link to="/">Dashboard</router-link></li>
        <li><router-link to="/pos">POS</router-link></li>
        <li><router-link to="/inventory">Inventory</router-link></li>
        <li><router-link to="/products">Products</router-link></li>
        <li><router-link to="/date-wise-sales-report">Date Wise Sales Report</router-link></li> 
        <li><router-link to="/product-wise-sales-report">Product Wise Sales Report</router-link></li> 
        <li><router-link to="/product-wise-stock-report">Product Wise Stock Report</router-link></li> 
      </ul>
    </div>
  </template>
  
  <style scoped>
  .sidebar {
    width: 200px;
    background-color: #2c3e50;
    color: #ecf0f1;
    display: flex;
    flex-direction: column;
    padding: 20px;
    height: 95vh;
  }
  
  .sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .sidebar ul {
    list-style: none;
    padding: 0;
  }
  
  .sidebar ul li {
    margin: 15px 0;
  }
  
  .sidebar ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 18px;
  }
  
  .sidebar ul li a:hover {
    color: #1abc9c;
  }
  </style>
  