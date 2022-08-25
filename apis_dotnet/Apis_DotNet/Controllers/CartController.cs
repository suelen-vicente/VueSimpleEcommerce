using Apis_DotNet.Model.Persistence;
using Apis_DotNet.Model;
using Microsoft.AspNetCore.Mvc;

namespace Apis_DotNet.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class CartController : ControllerBase
    {
        private readonly ECommerceDbContext _context;

        public CartController(ECommerceDbContext context)
        {
            _context = context;
        }

        [HttpGet("user/{user}")]
        public object GetCartByUser(int user)
        {
            List<Cart> cart = _context.Cart.Where(e => e.UserId == user).ToList();

            if (cart.Count() == 0)
                return NotFound("Cart not found.");

            double subTotal = 0;
            double shippingCost = 0;

            foreach (Cart cartItem in cart)
            {
                var product = _context.Product.SingleOrDefault(p => p.Id == cartItem.ProductId);

                subTotal += product.Price;
                shippingCost += product.ShippingCost;
            }

            var taxes = (subTotal + shippingCost) * 0.13;
            var total = subTotal + shippingCost + taxes;

            return new
            {
                userdId = user,
                subTotal = subTotal,
                shippingCost = shippingCost,
                taxes = taxes,
                total = total,
                cartItems = cart
            };
        }

        [HttpPut]
        public IActionResult AddProductToCart(Cart cart)
        {
            Cart foundCart = _context.Cart.FirstOrDefault(e => e.UserId == cart.UserId && e.ProductId == cart.ProductId);

            if(foundCart == null)
            {
                _context.Cart.Add(cart);
            }
            else
            {
                foundCart.Quantity = foundCart.Quantity + cart.Quantity;
                _context.Cart.Update(foundCart);
            }

            _context.SaveChanges();
            return Created("Product added to cart.", foundCart == null ? cart : foundCart);
        }

        [HttpDelete("user/{user}")]
        public IActionResult ClearUserCart(int user)
        {
            var userCart = _context.Cart.Where(a => a.UserId == user);

            if (userCart == null)
                return NotFound("Cart not found.");

            _context.Cart.RemoveRange(userCart);
            _context.SaveChanges();

            return Ok("Cart Deleted");
        }

        [HttpDelete]
        public IActionResult DeleteProduct(Cart cart)
        {
            var userCart = _context.Cart.SingleOrDefault(a => a.UserId == cart.UserId && a.ProductId == cart.ProductId);

            if (userCart == null)
                return NotFound("Product not found.");

            _context.Cart.Remove(userCart);
            _context.SaveChanges();

            return Ok("Product Deleted");
        }

        [HttpPost]
        public IActionResult UpdateProductQuantity(Cart cart)
        {
            var foundCart = _context.Cart.SingleOrDefault(a => a.UserId == cart.UserId && a.ProductId == cart.ProductId);

            if (foundCart == null)
                return NotFound("Product not found.");

            if (!cart.Quantity.Equals(null))
                foundCart.Quantity = cart.Quantity;

            _context.Cart.Update(foundCart);
            _context.SaveChanges();

            return Ok(foundCart);

        }
    }
}
