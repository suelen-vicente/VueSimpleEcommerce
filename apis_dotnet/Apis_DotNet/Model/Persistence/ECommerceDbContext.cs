using Microsoft.EntityFrameworkCore;

namespace Apis_DotNet.Model.Persistence
{
    public class ECommerceDbContext : DbContext
    {
        public ECommerceDbContext(DbContextOptions options) : base(options)
        {

        }

        public DbSet<User> User { get; set; }
        public DbSet<Product> Product { get; set; }
        public DbSet<Comments> Comments { get; set; }
        public DbSet<Cart> Cart { get; set; }
        public DbSet<Sale> Sale { get; set; }
        public DbSet<SaleProduct> SaleProduct { get; set; }
        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Cart>()
                .HasKey(a => new { a.UserId, a.ProductId});

            modelBuilder.Entity<SaleProduct>()
                .HasKey(a => new { a.SaleId, a.ProductId });
        }

    }
}
