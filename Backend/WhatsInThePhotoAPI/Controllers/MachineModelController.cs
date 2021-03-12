using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Globalization;
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

        private readonly IImageFileWriter _imageFileWriter;

        private readonly ILogger<MachineModelController> _logger;

        public MachineModelController(
            ILogger<MachineModelController> logger, IImageFileWriter imageFileWriter)
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
                new() {Name = "3035-cup.h5", DateCreated = DateTime.Now},
                new() {Name = "9001-cup.h5", DateCreated = DateTime.Now}
            };
        }

        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/Identify")]
        public async Task<IActionResult> IdentityObjectFromFileAsync(IFormFile imageFile, string modelName)
        {
            if (imageFile == null || imageFile.Length == 0)
                return BadRequest();
            try
            {
                _logger.LogInformation("Start processing image...");

                string temporaryFileLocation = await _imageFileWriter.UploadImageAsync(imageFile);
                string imagePath = Path.GetFullPath($"TemporaryImages\\{temporaryFileLocation}");
                string modelPath = Path.GetFullPath($"MachineModels\\{modelName}");

                string combinedCommand = $"{ScriptLocation} {modelPath} {imagePath}";

                string returnValue = PythonScript.ExecutePythonScript(combinedCommand);

                string[] splittedValue = returnValue.Split('|');

                string label = splittedValue[0];
                float.TryParse(splittedValue[1], NumberStyles.Float, CultureInfo.InvariantCulture, out float fValue);

                var imageResult = new ImageResult
                {
                    Label = label,
                    PercentageResult = fValue * 100
                };

                switch (returnValue.ToLower())
                {
                    case "1":
                        Console.WriteLine("Image category 1");
                        break;
                    case "0":
                        Console.WriteLine("Image category 0");
                        break;
                    default:
                        Console.WriteLine(returnValue);
                        break;
                }

                return Ok(imageResult);
            }
            catch (Exception e)
            {
                _logger.LogInformation("Error is: " + e.Message);
                return BadRequest();
            }
        }
    }
}


public class ImageResult
{
    public string Label { get; set; }

    public float PercentageResult { get; set; }
}