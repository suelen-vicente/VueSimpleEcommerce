using Apis_DotNet.Model.Persistence;
using Apis_DotNet.Model;
using Microsoft.AspNetCore.Mvc;

namespace Apis_DotNet.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class SaleController : ControllerBase
    {
        private readonly ECommerceDbContext _context;

        public SaleController(ECommerceDbContext context)
        {
            _context = context;
        }

        [HttpGet("user/{user}")]
        public List<object> GetSaleByUser(int user)
        {
            List<Sale> sales = _context.Sale
                .Where(e => e.UserId == user)
                .OrderBy(e=> e.LastModification)
                .ToList();

            List<object> result = new List<object>();

            foreach(var sale in sales)
            {
                var products = _context.SaleProduct.Where(e => e.SaleId == sale.Id).ToList();

                result.Add(new
                {
                    id = sale.Id,
                    status = sale.Status,
                    userId = sale.UserId,
                    lastModification = sale.LastModification,
                    subTotal = sale.SubTotal,
                    shippingCost = sale.ShippingTotal,
                    taxes = sale.CalcTax,
                    products = products
                });
            }

            return result;
        }

        [HttpGet("{id}")]
        public object GetSaleById(int id)
        {
            var sale = _context.Sale.FirstOrDefault(e => e.Id == id);

            if (sale == null)
                return NotFound("Sale not found");

            var products = _context.SaleProduct.Where(e => e.SaleId == id).ToList();

            return new
            {
                id = sale.Id,
                status = sale.Status,
                userId = sale.UserId,
                lastModification = sale.LastModification,
                subTotal = sale.SubTotal,
                shippingCost = sale.ShippingTotal,
                taxes = sale.CalcTax,
                products = products
            };
        }

        [HttpPut("user/{user}")]
        public IActionResult CreateSaleByCart(int user)
        {
            var cart = _context.Cart.Where(c => c.UserId == user).ToList();

            if (cart == null)
                return NotFound("User cart not found");

            Sale sale = new Sale();
            sale.UserId = user;
            sale.LastModification = DateTime.Now;
            sale.Status = "CREATED";

            sale.SubTotal = 0;
            sale.ShippingTotal = 0;
            sale.CalcTax = 0;
            sale.Total = 0;

            _context.Sale.Add(sale);
            _context.SaveChanges();

            foreach(var item in cart)
            {
                var product = _context.Product.SingleOrDefault(p => p.Id == item.ProductId);

                SaleProduct saleProduct = new SaleProduct();
                saleProduct.SaleId = sale.Id;
                saleProduct.ProductId = item.ProductId;
                saleProduct.SubTotal = item.Quantity * product.Price;
                saleProduct.ShippingCost = item.Quantity * product.ShippingCost;
                saleProduct.Taxes = (saleProduct.SubTotal + saleProduct.ShippingCost) * 0.13;
                saleProduct.Total = saleProduct.SubTotal + saleProduct.ShippingCost + saleProduct.Taxes;
                
                sale.SubTotal = sale.SubTotal + saleProduct.SubTotal;
                sale.ShippingTotal = sale.ShippingTotal + saleProduct.ShippingCost;
                sale.CalcTax = sale.CalcTax + saleProduct.Taxes;
                sale.Total = sale.Total + saleProduct.Total;
                
                _context.SaleProduct.Add(saleProduct);
            }

            sale.Status = "OPEN";
            _context.Sale.Update(sale);
            _context.SaveChanges();

            return Created("Sale created", sale);
        }

        [HttpPost("cancel/{id}")]
        public IActionResult CancelSale(int id)
        {
            var foundSale = _context.Sale.SingleOrDefault(a => a.Id == id);

            if (foundSale == null)
                return NotFound("Sale not found.");

            foundSale.Status = "CANCELED";
            foundSale.LastModification = DateTime.Now;

            _context.Sale.Update(foundSale);
            _context.SaveChanges();

            return Ok(foundSale);

        }
    }
}
