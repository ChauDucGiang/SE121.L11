let cart = window.localStorage.getItem('cart');
export default {
    products: [],
    product: [],
    cartItems: cart ? JSON.parse(cart) : [],
    wishList: [],
    categories: [],
    packages: [],
    subcategories: [],
    customers: [],
    colors: [],
    price: [],
    total: 0,
    order: null,
}
