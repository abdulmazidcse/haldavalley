<template>
    <div class="product-card">
      <img :src="product.imageUrl" :alt="product.name" class="product-image" />
      <div class="product-details">
        <h3 class="product-title">{{ product.name }}</h3>
        <p class="product-description">{{ product.description }}</p>
        <p class="product-price">$ {{ product.price }}</p>
        <button class="add-to-cart-button" @click="addToCart(product)">
          Add to Cart
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      product: {
        type: Object,
        required: true,
      },
    },
    methods: {
      addToCart(product) {
        this.$emit("add-to-cart", product); // Emits event to parent component
      },
    },
  };
  </script>
  
  <style scoped>
  .product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    max-width: 300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
  }
  .product-card:hover {
    transform: translateY(-5px);
  }
  
  .product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  
  .product-details {
    padding: 15px;
  }
  
  .product-title {
    font-size: 18px;
    margin: 10px 0;
    color: #333;
  }
  
  .product-description {
    font-size: 14px;
    color: #777;
    margin-bottom: 15px;
  }
  
  .product-price {
    font-size: 16px;
    color: #2c3e50;
    font-weight: bold;
    margin-bottom: 15px;
  }
  
  .add-to-cart-button {
    background-color: #1abc9c;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .add-to-cart-button:hover {
    background-color: #16a085;
  }
  </style>
  