<template>
    <div class="quantity">
        <p class="quantity-text">Quantity</p>
        <div class="quantity-selector">
            <button class="button-selector-left" @click="subtract()">-</button>
            <input class="value" :value="quantity" readonly>
            <button class="button-selector-right"  @click="add()">+</button>
        </div>
    </div>
</template>

<script>
export default {
    props:["product"],
    data () {
        return {
            quantity: this.$store.getters.getQuantityByProductId(this.product.id)
        }
    },

    methods: {
        add () {
            if(this.quantity === 10){
                alert('Maximum quantity allowed is 10')
            }else{
                this.quantity++
                this.$emit('clicked', this.quantity)
            }
        },
        subtract () {
            if(this.quantity === 1) {
                alert('Negative quantity not allowed')
            } else {
                this.quantity--
                this.$emit('clicked', this.quantity)
            }
        },
    },

}
</script>

<style>
    .quantity{
        width:100%;
        float:left;
        align-items: center;
        display: flex;
        flex-direction: column;
        margin-right: 10%;
        margin-left: 5%;
    }

    .quantity-text{
        margin:0px;
        font-size: 0.85em;
    }

    .quantity-selector{
        display:flex;
        flex-direction: row;
        width: 100%;
        border-radius: 10px;
        height: 100%;
    }

    .button-selector-right{
        width: 20%;
        text-align: center;
        display: block;
        background-color: #058C42;
        color: white;
        margin: 0px;
        border-radius: 0px 10px 10px 0px;
        border: none;
    }

    .button-selector-left{
        width: 20%;
        text-align: center;
        display: block;
        background-color: #058C42;
        color: white;
        margin: 0px;
        border-radius: 10px 0px 0px 10px;
        border: none;
    }

    .value{
        width: 40%;
        text-align: center;
        border: none;
    }
</style>