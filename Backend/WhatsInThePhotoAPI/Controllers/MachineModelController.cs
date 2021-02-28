using System;
using System.Collections.Generic;
using Microsoft.AspNetCore.Mvc;
using WhatsInThePhotoAPI.Models;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860
namespace WhatsInThePhotoAPI.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class MachineModelController : ControllerBase
    {
        // GET: api/<MachineModelController>
        [HttpGet]
        public IEnumerable<MachineModel> GetAllModels()
        {
            return new List<MachineModel>
            {
                new() {Name = "Model1", DateCreated = DateTime.Now, ModelLocation = "Look at me MrMeeseks"},
                new() {Name = "Model2", DateCreated = DateTime.Now, ModelLocation = "Look at me MrMeeseks"},
                new() {Name = "Model3", DateCreated = DateTime.Now, ModelLocation = "Look at me MrMeeseks"},
                new() {Name = "Model4", DateCreated = DateTime.Now, ModelLocation = "Look at me MrMeeseks"},
                new() {Name = "Model5", DateCreated = DateTime.Now, ModelLocation = "Look at me MrMeeseks"}
            };
        }

        // GET api/<MachineModelController>/5
        [HttpGet("{id}")]
        public string Get(int id)
        {
            return "value";
        }

        // POST api/<MachineModelController>
        [HttpPost]
        public void UploadImage([FromBody] string value)
        {
        }

        // PUT api/<MachineModelController>/5
        [HttpPut("{id}")]
        public void Put(int id, [FromBody] string value)
        {
        }

        // DELETE api/<MachineModelController>/5
        [HttpDelete("{id}")]
        public void Delete(int id)
        {
        }
    }
}