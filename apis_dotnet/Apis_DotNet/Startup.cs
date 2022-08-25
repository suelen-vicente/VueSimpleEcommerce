using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.HttpsPolicy;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Microsoft.EntityFrameworkCore;
using Apis_DotNet.Model.Persistence;

namespace W7Class
{
    public class Startup
    {
        public Startup(IConfiguration configuration)
        {
            Configuration = configuration;
        }

        public IConfiguration Configuration { get; }

        // This method gets called by the runtime. Use this method to add services to the container.
        public void ConfigureServices(IServiceCollection services)
        {
            //services.AddDbContext<ECommerceDbContext>(opts => opts.UseInMemoryDatabase(Configuration.GetConnectionString("MyDb")));
            services.AddDbContext<ECommerceDbContext>(opts => opts.UseSqlServer(Configuration.GetConnectionString("DefaultConfiguration")));
            services.AddControllers();
        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IWebHostEnvironment env, ECommerceDbContext db)
        //public void Configure(IApplicationBuilder app, IWebHostEnvironment env)
        {

            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
            }

            //This does not work on mac
            // LocalDB is not supported on mac
            //db.Database.EnsureCreated();

            app.UseHttpsRedirection();

            app.UseRouting();

            app.UseAuthorization();

            app.UseEndpoints(endpoints =>
            {
                endpoints.MapControllers();
            });
        }
    }
}

//View SQL Server... (To see if the database is on)

//To create new Database 
//Tools > Nuget... > Package Manager Nuget Console
// type in the console add-migration createDatabaseMMigratio
// type update-database
// A new database will be added to the project. You can see it ont the project explorer
//  You also can check if the data is entering in the database by clicking on the DB icon
//   and checking the tables of it

//If you want to add a new entity
// add-migration addAddressEntity
// The line above will add the address entity
// then update-database and our new table will be there

//After we added the foreign key, we need to add a new migration
// add-migration employeeForeignKey
// update-database
// PROBABLY NEED TO CHECK HOW TO MAKE IT A CONSTRAINT