import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home'
import About from '../views/About'
import Products from '../views/product/Products'
import SignUp from '../views/SignUp'
import ProductDetails from '../views/product/ProductDetails'

// All of our routes should be defined and handled here 
const routes = [
    {path: '/', name: 'Home', component: Home},
    {path: '/about', name: 'About', component: About},
    {path: '/products', name: 'Products', component: Products},
    {path: '/signup', name: 'SignUp', component: SignUp},
    // Props is used to pass values from one page to another. 
    {path: '/product/:id', name: 'ProductDetails', component: ProductDetails, props: true},
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

// This export should be the same as the const created above
export default router