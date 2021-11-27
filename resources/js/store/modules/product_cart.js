import axios from 'axios';

// state list
const state = {
    sub_total: 0,
    total: 0,
    carts: [],
    latest_saved_cart: {},
    selected_cart: {},
    delivery_charge: 0,
    billing_info: {
        full_name : '',
        phone : '',
        email : '',
        district : '',
        street_address : '',
        order_note : '',
    },
}

// get state
const getters = {
    get_carts: state => state.carts,
    get_sub_total: state => state.sub_total,
    get_total: state => state.total,
    get_selected_cart: state => state.selected_cart,
    get_latest_saved_cart: state => state.latest_saved_cart,
    get_delivery_charge: state => state.delivery_charge,
    get_billing_info: state => state.billing_info,
}

// actions
const actions = {
    fetch_latest_saved_cart: function(state){
        axios.get('/get_latest_checkout_information')
            .then((res)=>{
                this.commit('save_latest_saved_cart',res.data);
            })

    },
}

// mutators
const mutations = {
    set_carts: function(state,cart){
        let temp_cart = state.carts.filter((item)=>item.product.id != cart.product.id);
        state.carts = temp_cart;
        state.carts.unshift(cart);
        this.commit('calculate_cart_total');
    },
    set_selected_cart: function(state,cart){
        state.selected_cart = cart;
    },
    set_delivery_charge: function(state,delivery_charge){
        state.delivery_charge = delivery_charge;
        this.commit('calculate_total');
    },
    remove_from_carts: function(state,cart){
        let temp_cart = state.carts.filter((item)=>item.product.id != cart.product.id);
        state.carts = temp_cart;
        this.commit('calculate_cart_total');
    },
    change_cart_qty: function(state,product_info){
        // console.log(product_info);
        let product = state.carts.find((item) => {
            return item.product.id  === product_info.product_id;
        });
        product.qty = product_info.qty;
        this.commit('calculate_cart_total');
    },
    calculate_cart_total: function(state,cart){
        state.sub_total = state.carts.reduce((total,item)=>total += (item.product_price * item.qty),0);
        this.commit('calculate_total');
    },
    calculate_total: function(state,total){
        state.total = state.sub_total + state.delivery_charge;
    },
    reset_cart: function(state){
        state.sub_total= 0;
        state.total= 0;
        state.delivery_charge= 0;
        state.carts= [];
        state.selected_cart= {};
        state.latest_saved_cart= {};
    },
    save_latest_saved_cart: function(state,info){
        state.latest_saved_cart = info;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
