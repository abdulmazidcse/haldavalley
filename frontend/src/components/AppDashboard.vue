<template>
    <div class="content">
      <h3>Overview</h3>
      <div class="cards">
        <div class="card">
          <h4>Total Sales</h4>
          <p>$10,000</p>
        </div>
        <div class="card">
          <h4>Products in Stock</h4>
          <p>150</p>
        </div>
        <div class="card">
          <h4>Orders Today</h4>
          <p>23</p>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .content {
    padding: 20px;
  }
  
  .cards {
    display: flex;
    gap: 20px;
    margin-top: 20px;
  }
  
  .card {
    flex: 1;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .card h4 {
    font-size: 18px;
    color: #333;
  }
  
  .card p {
    font-size: 24px;
    font-weight: bold;
    color: #1abc9c;
    margin-top: 10px;
  }
  </style>
  