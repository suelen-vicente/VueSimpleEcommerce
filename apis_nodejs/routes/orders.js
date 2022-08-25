const express = require('express');
const router = express.Router();

const Order = require('../models/orders');
const Cart = require('../models/cart');

//Create a new order
router.put("/:userId", async (req, res) => {
    try{
        let cart = await Cart.findOne({userId: req.params.userId});
        
        if (!cart){
            return res.status(400).json("No cart found.");
        }

        let order = new Order({
            userId: req.params.userId,
            status: "OPEN",
            lastModified: new Date(),
            subTotal: cart.subTotal,
            shippingCost: cart.shippingCost,
            taxes: cart.taxes,
            total: cart.total,
            items: cart.items
        });

        order.save().then(result => {
            return res.status(201).json(result);
        }).catch(err => {
            return res.status(400).json({error: err})
        });
    }catch(error){
        return res.status(400).json(error)
    }
});

//Get order by user
router.get("/user/:id", async (req, res) => {
    try{
        let orders = await Order.find({userId: req.params.id});

        if(!orders || orders.length === 0){
            return res.status(404).json("Order not found.");
        }

        return res.status(200).json(orders)
    }catch(error){
        return res.status(400).json(error)
    }
});

//Get order by id
router.get("/:id", async (req, res) => {
    try{
        let orders = await Order.findOne({_id: req.params.id});

        if(!orders || orders.length === 0){
            return res.status(404).json("Order not found.");
        }

        return res.status(200).json(orders)
    }catch(error){
        return res.status(400).json(error)
    }
});

//Cancel Order
router.post("/cancel/:orderId", async (req, res) => {
    try{
        let order = await Order.findOne({_id: req.params.orderId});
    
        if(!order){
            return res.status(404).json("Order not found.");
        }
    
        order.status = "CANCELED";
        order.lastModified = new Date();
    
        order.save().then(result => {
            return res.status(200).json(result);
        }).catch(err => {
            return res.status(400).json({error: err})
        })
    }catch(err){
        return res.status(400).json({error: err})
    }
});

module.exports = router