// import { notify } from "@kyvg/vue3-notification";
// import { useToast } from 'vue-toastification'
// const toast = useToast()

import axios from 'axios'; 
const state = {
  cartItems:[],
  cartInfo:{}, 
  countCartItems: 0,
}

const mutations = {
  UPDATE_CART_ITEMS (state, payload) {  
    const cartItemProduct = JSON.stringify(payload);  
    const itemProduct = JSON.parse(cartItemProduct);  
    const newCartProduct = {
      product_id: itemProduct.product_id,
      product_stock_id: itemProduct.product_stock_id,
      product_name: itemProduct.product_name, 
      mrp_price: itemProduct.mrp_price,
      product_code: itemProduct.product_code, 
      quantity: itemProduct.min_order_qty ? itemProduct.min_order_qty : 1,
      stock_quantity: itemProduct.stock_quantity, 
    }; 
    const cartProducts =  state.cartItems;
    let cartProductExists = false;
    cartProducts.map((cartProduct) => {
      if((cartProduct.product_id === newCartProduct.product_id) && (cartProduct.product_stock_id === newCartProduct.product_stock_id)){
        cartProduct.quantity++;
        cartProductExists = true;
      }
    });
    if (!cartProductExists) cartProducts.push(newCartProduct);     
  }, 
  SELECT_CARTINFO (state, payload) { 
    Object.assign(state.cartInfo, payload);
  } 
}

const actions = { 
  addCartItem ({ commit }, cartItem) {   
    commit('UPDATE_CART_ITEMS', cartItem);    
  },  
  selectCartInfo ({ commit }, infoData) {   
    commit('SELECT_CARTINFO', infoData);      
  }
}

const getters = {  
  cartItems: state => state.cartItems,
  cartInfo: state => state.cartInfo, 
  cartTotal: state => {
    return state.cartItems.reduce((acc, cartItem) => {
      return (cartItem.quantity * cartItem.price) + acc;
    }, 0).toFixed(2);
  },
  cartQuantity: state => {
    return state.cartItems.reduce((acc, cartItem) => {
      return cartItem.quantity + acc;
    }, 0);
  }
} 

const cartModule = {
  state,
  mutations,
  actions,
  getters
}
export default cartModule;