const { request } = require('express');
const express = require('express');
const router = express.Router();
const {check, validationResult} = require('express-validator')

const Cart = require('../models/cart');
const Product = require('../models/products');

//Add product to the user cart
router.put("/add-product", async (req, res) => {
    try{
        let request = req.body.productInfo;

        let cart = await Cart.findOne({userId: request.userId});

        let product = await Product.findOne({_id: request.productId});

        let productItem = {
                productId: request.productId,
                productName: product.name,
                productImage: product.image,
                productPrice: product.price,
                productShippingCost: product.shippingCost,
                quantity: request.quantity
            };

        if(!cart){
            cart = new Cart({
                userId: request.userId,
                subTotal: product.price * request.quantity,
                shippingCost: product.shippingCost * request.quantity,
                taxes: 0,
                total: 0,
                items: [productItem]
            });
        }else{
            const itemIndex = cart.items.findIndex(item => {
                console.log(item.productId);
                return item.productId == request.productId;
            });
            
            if (itemIndex !== -1) {
                cart.items[itemIndex].quantity += request.quantity;
            }else{
                cart.items.push(productItem)
            }

            cart.subTotal += product.price * request.quantity;
            cart.shippingCost += product.shippingCost * request.quantity;
        }

        cart.taxes = (cart.subTotal + cart.shippingCost) * 0.13;
        cart.total = (cart.subTotal + cart.shippingCost + cart.taxes);

        cart.save().then(result => {
            return res.status(201).json(result);
        }).catch(err => {
            return res.status(400).json({error: err})
        })
    }catch(error){
        return res.status(400).json(error)
    }
});

//Get cart by user
router.get("/user/:id", async (req, res) => {
    try{
        let cart = await Cart.find({userId: req.params.id});
        
        if(!cart || cart.length === 0){
            return res.status(404).json("Cart not found.");
        }

        return res.status(200).json(cart)
    }catch(error){
        return res.status(400).json(error)
    }
});

//Modify quantity
router.post("/", async (req, res) => {
    try{

        let request = req.body.productInfo
        
        let cart = await Cart.findOne({userId: request.userId});
        
        console.log(request);
        if(!cart){
            return res.status(404).json("User cart not found.");
        }
    
        const itemIndex = cart.items.findIndex(item => {
            return item.productId == request.productId;
        });
        
        if (itemIndex == -1) {
            return res.status(404).json("Product not found in user cart.");
        }
    
        cart.items[itemIndex].quantity = request.quantity;
    
        cart = recalculateTotals(cart);
    
        cart.save().then(result => {
            return res.status(200).json(result);
        }).catch(err => {
            return res.status(400).json({error: err})
        })
    }catch(err){
        return res.status(400).json({error: err})
    }
});

//Delete product from user cart
router.post("/delete-product", async (req,res) =>{
    let request = req.body.productInfo
    console.log(request);
    
    try{
        let cart = await Cart.findOne({userId: request.userId});

        if(!cart){
            return res.status(404).json("User cart not found.");
        }

        cart.items = cart.items.filter(function(item) { 
            return item.productId != request.productId; 
        });

        cart = recalculateTotals(cart);

        cart.save().then(result => {
            return res.status(200).json(result);
        }).catch(err => {
            return res.status(400).json({error: err})
        })
    }catch(err){
        return res.status(400).json({error: err})
    }
});

//Clear user cart
router.delete("/user/:id", [
    check("userId").notEmpty().withMessage("UserId is required"),
    check("productId").notEmpty().withMessage("ProductId is required")
], async (req,res) =>{
    try{
        let result = await Cart.deleteOne({userId: req.params.id})
        return res.status(200).json("User cart cleared.")
    }catch(err){
        return res.status(400).json({error: err})
    }
});

function recalculateTotals(cart){
    cart.subTotal = 0;
    cart.shippingCost = 0;

    cart.items.forEach(item => {
        cart.subTotal += item.productPrice * item.quantity;
        cart.shippingCost += item.productShippingCost * item.quantity;
    });

    cart.taxes = (cart.subTotal + cart.shippingCost) * 0.13;
    cart.total = (cart.subTotal + cart.shippingCost + cart.taxes);

    return cart;
}


module.exports = router