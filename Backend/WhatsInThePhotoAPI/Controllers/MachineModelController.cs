using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.IO;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using Python.Runtime;
using WhatsInThePhotoAPI.ImageFileHelpers;
using WhatsInThePhotoAPI.Models;
using WhatsInThePhotoAPI.Scripts;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860
namespace WhatsInThePhotoAPI.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class MachineModelController : ControllerBase
    {
        private const string ScriptLocation = @"Scripts\PredictScript.py";

        private static readonly string[] labels =
            {"airplane", "automobile", "bird", "cat", "deer", "dog", "frog", "horse", "ship", "truck"};

        private readonly IImageFileWriter _imageFileWriter;


        private readonly ILogger<ObjectDetectionController> _logger;

        public MachineModelController(
            ILogger<ObjectDetectionController> logger, IImageFileWriter imageFileWriter)
        {
            //Get injected dependencies
            _logger = logger;
            _imageFileWriter = imageFileWriter;


            //if (!PythonEngine.IsInitialized) PythonEngine.Initialize();
            string? pythonHome =
                Environment.GetEnvironmentVariable("PYTHONHOME", EnvironmentVariableTarget.Process);
            string? pythonPath =
                Environment.GetEnvironmentVariable("PYTHONPATH", EnvironmentVariableTarget.Process);

            Debug.WriteLine(PythonEngine.PythonHome);
            Debug.WriteLine(PythonEngine.Version);
            Debug.WriteLine(PythonEngine.PythonPath);
        }

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

        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/Identify")]
        public async Task<IActionResult> IdentityObjectFromFileAsync(IFormFile imageFile)
        {
            if (imageFile == null || imageFile.Length == 0)
                return BadRequest();
            try
            {
                _logger.LogInformation("Start processing image...");


                string temporaryFileLocation = await _imageFileWriter.UploadImageAsync(imageFile);
                string imagePath = Path.GetFullPath($"TemporaryImages\\{temporaryFileLocation}");
                string modelPath = Path.GetFullPath("MachineModels\\new_model_big_set.h5");

                string combinedCommand = $"{ScriptLocation} {modelPath} {imagePath}";

                string returnvalue = MLStuff.ExecutePythonScript(combinedCommand);

                switch (returnvalue.ToLower())
                {
                    case "1":
                        Console.WriteLine("Image category 1");
                        break;
                    case "0":
                        Console.WriteLine("Image category 0");
                        break;
                    default:
                        Console.WriteLine(returnvalue);
                        break;
                }

                //dynamic testFunction = _scope.GetVariable("test_func");
                //dynamic result = testFunction(imagePath, modelPath);

                return Ok(returnvalue);
            }
            catch (Exception e)
            {
                _logger.LogInformation("Error is: " + e.Message);
                return BadRequest();
            }
        }
    }
}