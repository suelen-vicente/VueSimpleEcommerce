using Apis_DotNet.Model.Persistence;
using Apis_DotNet.Model;
using Microsoft.AspNetCore.Mvc;

namespace Apis_DotNet.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class UserController : ControllerBase
    {
        private readonly ECommerceDbContext _context;

        public UserController(ECommerceDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public List<User> GetUsers()
        {
            return _context.User.ToList();
        }

        [HttpGet("{id}")]
        public IActionResult GetUserById(int id)
        {
            var user = _context.User.SingleOrDefault(e => e.Id == id);
            return Ok(user);
        }

        [HttpPut]
        public IActionResult AddUser(User user)
        {
            _context.User.Add(user);
            _context.SaveChanges();
            return Created("User was created.", user);
        }

        [HttpDelete("{id}")]
        public IActionResult DeleteUser(int id)
        {
            var user = _context.User.SingleOrDefault(a => a.Id == id);

            if (user == null)
                return NotFound("User not found.");

            _context.User.Remove(user);
            _context.SaveChanges();

            return Ok("User Deleted");


        }

        [HttpPost("{id}")]
        public IActionResult UpdateUser(int id, User user)
        {
            var foundUser = _context.User.SingleOrDefault(a => a.Id == id);

            if (foundUser == null)
                return NotFound("User not found.");

            if (user.Name != null)
                foundUser.Name = user.Name;

            if (user.Email != null)
                foundUser.Email = user.Email;

            if (user.Password != null)
                foundUser.Password = user.Password;

            if (user.ShippingAddress != null)
                foundUser.ShippingAddress = user.ShippingAddress;

            _context.User.Update(foundUser);
            _context.SaveChanges();

            return Ok(foundUser);

        }
    }
}
