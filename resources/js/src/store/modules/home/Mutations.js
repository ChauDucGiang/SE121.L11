export default {
    SET_PRODUCTS(state, data) {
        state.products = data.products.data;
        state.colors = data.colors;
        state.price = data.price;
    },
    ADD_ORDER(state, data) {
        state.order = data.order;
    },
    SET_CATEGORIES(state, data) {
        state.categories = data.listCategory;
        // state.subcategories = data.subcategories;
    },
    // SET_PACKAGES(state, data) {
    //     state.packages = data.packages;
    //     // state.subcategories = data.subcategories;
    // },
    SET_SUBCATEGORIES(state, data) {
        // state.categories = data.listCategory;
        state.subcategories = data.subcategories;

    },
    SET_CUSTOMERS(state, data) {
        // state.categories = data.listCategory;
        state.customers = data.customers;

    },
    SET_TOTALRECORD(state, data) {
        // state.categories = data.listCategory;
        state.total = data.products.last_page;

    },
    TOGGLE_ITEM_IN_WISH_LIST(state, item) {
        const index = state.wishList.findIndex(i => i.id === item.id)
        if (index < 0) {
            state.wishList.push(item)
        } else {
            state.wishList.splice(index, 1)
        }
        // window.localStorage.setItem('cart', JSON.stringify(state.cartItems));
    },
    REMOVE_ITEM_FROM_CART(state, item) {
        const index = state.cartItems.findIndex(i => i.id === item.id)
        if (index > -1) {
            state.cartItems.splice(index, 1)
        }
        window.localStorage.setItem('cart', JSON.stringify(state.cartItems));
    },
    ADD_ITEM_IN_CART(state, item) {
        state.cartItems.push(Object.assign({}, item))
        window.localStorage.setItem('cart', JSON.stringify(state.cartItems));
    },
    UPDATE_ITEM_PRICE(state, payload) {
        state.cartItems[payload.index].new_price = payload.new_price
        window.localStorage.setItem('cart', JSON.stringify(state.cartItems));
    },
    REMOVE_CART(state) {
        state.cartItems = [];
        window.localStorage.setItem('cart', JSON.stringify(state.cartItems));
    },
    UPDATE_IMAGES(state, payload) {
        state.cartItems[payload.index].images_export[payload.image.type - 1] = payload.image.url;
        // const index = state.cartItems[payload.index].images_export.findIndex(i => i === payload.image.url)
        state.cartItems[payload.index].images_export.push(payload.image.url)
        state.cartItems[payload.index].images_export.splice(3, 1)
        window.localStorage.setItem('cart', JSON.stringify(state.cartItems));
    },
    // SAVE_CART(state) {
    // }
}

