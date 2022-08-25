using Apis_DotNet.Model.Persistence;
using Apis_DotNet.Model;
using Microsoft.AspNetCore.Mvc;

namespace Apis_DotNet.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class ProductController : ControllerBase
    {
        private readonly ECommerceDbContext _context;

        public ProductController(ECommerceDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public List<Product> GetProducts()
        {
            return _context.Product.ToList();
        }

        [HttpGet("{id}")]
        public IActionResult GetProductById(int id)
        {
            var product = _context.Product.SingleOrDefault(e => e.Id == id);
            return Ok(product);
        }

        [HttpPut]
        public IActionResult AddProduct(Product product)
        {
            _context.Product.Add(product);
            _context.SaveChanges();
            return Created("Product was created.", product);
        }

        [HttpDelete("{id}")]
        public IActionResult DeleteProduct(int id)
        {
            var product = _context.Product.SingleOrDefault(a => a.Id == id);

            if (product == null)
                return NotFound("Product not found.");

            _context.Product.Remove(product);
            _context.SaveChanges();

            return Ok("Product Deleted");
        }

        [HttpPost("{id}")]
        public IActionResult UpdateProduct(int id, Product product)
        {
            var foundProduct = _context.Product.SingleOrDefault(a => a.Id == id);

            if (foundProduct == null)
                return NotFound("Product not found.");

            if (product.Name != null)
                foundProduct.Name = product.Name;

            if (product.Brand != null)
                foundProduct.Brand = product.Brand;

            if (product.Description != null)
                foundProduct.Description = product.Description;

            if (product.Image != null)
                foundProduct.Image = product.Image;

            if (product.Price != null)
                foundProduct.Price = product.Price;

            if (product.ShippingCost != null)
                foundProduct.ShippingCost = product.ShippingCost;

            _context.Product.Update(foundProduct);
            _context.SaveChanges();

            return Ok(foundProduct);

        }
    }
}
