using System.ComponentModel.DataAnnotations.Schema;

namespace Apis_DotNet.Model
{
    public class Comments
    {
        public int Id { get; set; }
        [ForeignKey("Product")]
        public int ProductId { get; set; }
        [ForeignKey("User")]
        public int UserId { get; set; }
        public int Rating { get; set; }
        public string Image { get; set; }
        public string Text { get; set; }

    }
}
