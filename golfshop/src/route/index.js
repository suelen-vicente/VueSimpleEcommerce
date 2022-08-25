import {createRouter, createWebHistory} from 'vue-router'
import ShoppingCart from '../views/ShoppingCart'
import Products from '../views/product/Products'
import SignUp from '../views/SignUp'
import Account from '../views/Account'
import ProductDetails from '../views/product/ProductDetails'
import CustomerInfo from '../views/CustomerInfo'
import Orders from '../views/order/OrderHistory'

const routes = [
    {path: '/', name: 'root', component: Products},
    {path: '/shoppingCart', name: 'ShoppingCart', component: ShoppingCart},
    {path: '/products', name: 'Products', component: Products},
    {path: '/sign', name: 'SignUp', component: SignUp}, 
    // {path: '/account/:id', name: 'Account', component: Account, props: true}, 
    {path: '/account', name: 'Account', component: Account,props: true}, 
    {path: '/product/:id', name: 'ProductDetails', component: ProductDetails, props: true},
    {path: '/customerInfo', name: 'CustomerInfo', component: CustomerInfo},
    {path: '/orders', name: 'Orders', component: Orders}, 
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})
// router.replace({ path: '*', redirect: '/products' })

export default router