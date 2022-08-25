using System.ComponentModel.DataAnnotations.Schema;

namespace Apis_DotNet.Model
{
    public class Cart
    {
        [ForeignKey("Product")]
        public int ProductId { get; set; }
        [ForeignKey("User")]
        public int UserId { get; set; }
        public int Quantity { get; set; }

    }
}
