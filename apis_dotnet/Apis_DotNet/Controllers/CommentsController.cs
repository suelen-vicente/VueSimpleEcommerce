using Apis_DotNet.Model.Persistence;
using Apis_DotNet.Model;
using Microsoft.AspNetCore.Mvc;

namespace Apis_DotNet.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class CommentsController : ControllerBase
    {
        private readonly ECommerceDbContext _context;

        public CommentsController(ECommerceDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public List<Comments> GetComments()
        {
            return _context.Comments.ToList();
        }

        [HttpGet("product/{product}")]
        public List<Comments> GetCommentsByProduct(int product)
        {
            return _context.Comments.Where(e => e.ProductId == product).ToList();
        }

        [HttpGet("user/{user}")]
        public List<Comments> GetCommentsByUser(int user)
        {
            return _context.Comments.Where(e => e.UserId == user).ToList();
        }

        [HttpGet("{id}")]
        public IActionResult GetCommentById(int id)
        {
            var comment = _context.Comments.SingleOrDefault(e => e.Id == id);
            return Ok(comment);
        }

        [HttpPut]
        public IActionResult AddComment(Comments comment)
        {
            _context.Comments.Add(comment);
            _context.SaveChanges();
            return Created("Comments was created.", comment);
        }

        [HttpDelete("{id}")]
        public IActionResult DeleteComment(int id)
        {
            var comment = _context.Comments.SingleOrDefault(a => a.Id == id);

            if (comment == null)
                return NotFound("Comment not found.");

            _context.Comments.Remove(comment);
            _context.SaveChanges();

            return Ok("Comments Deleted");
        }

        [HttpDelete("user/{user}")]
        public IActionResult DeleteCommentByUser(int user)
        {
            var comment = _context.Comments.Where(a => a.UserId == user);

            if (comment == null)
                return NotFound("Comment not found.");

            _context.Comments.RemoveRange(comment);
            _context.SaveChanges();

            return Ok("Comments Deleted");
        }

        [HttpDelete("product/{product}")]
        public IActionResult DeleteCommentByProduct(int product)
        {
            var comment = _context.Comments.Where(a => a.ProductId == product);

            if (comment == null)
                return NotFound("Comment not found.");

            _context.Comments.RemoveRange(comment);
            _context.SaveChanges();

            return Ok("Comments Deleted");
        }

        [HttpPost("{id}")]
        public IActionResult UpdateComment(int id, Comments comments)
        {
            var foundComment = _context.Comments.SingleOrDefault(a => a.Id == id);

            if (foundComment == null)
                return NotFound("Comment not found.");

            if (comments.Text != null)
                foundComment.Text = comments.Text;

            if (comments.Image != null)
                foundComment.Image = comments.Image;

            if (comments.Rating != null)
                foundComment.Rating = comments.Rating;

            _context.Comments.Update(foundComment);
            _context.SaveChanges();

            return Ok(foundComment);

        }
    }
}
