export default {
    isInCart: state => itemId => {
        return state.cartItems.some((item) => item.id === itemId)
    },
    isInWishList: state => itemId => {
        return state.wishList.some((item) => item.objectID === itemId)
    },
    isInImagesExport: state => itemId => {
        return state.wishList.some((item) => item === itemId)
    },
    getCartItem: state => itemId => {
        const result = state.cartItems.filter((item) => item.objectID === itemId)
        return result.length ? result.pop() : []
    }
}
