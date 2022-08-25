using System.ComponentModel.DataAnnotations.Schema;

namespace Apis_DotNet.Model
{
    public class SaleProduct
    {
        [ForeignKey("Sale")]
        public int SaleId { get; set; }
        [ForeignKey("Product")]
        public int ProductId { get; set; }
        public double SubTotal { get; set; }
        public double Taxes { get; set; }
        public double ShippingCost { get; set; }
        public double Total { get; set; }

    }
}
