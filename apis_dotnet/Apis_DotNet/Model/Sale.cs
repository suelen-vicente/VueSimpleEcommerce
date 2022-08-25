using System.ComponentModel.DataAnnotations.Schema;

namespace Apis_DotNet.Model
{
    public class Sale
    {
        public int Id { get; set; }
        [ForeignKey("User")]
        public int UserId { get; set; }
        public double SubTotal { get; set; }
        public double CalcTax { get; set; }
        public double ShippingTotal { get; set; }
        public double Total { get; set; }
        public string Status { get; set; }

    }
}
