#nullable enable
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Globalization;
using System.IO;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
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
        private const string PredictScriptLocation = @"Scripts\PredictScript.py";

        private const string TrainingScriptLocation = @"Scripts\TrainModel.py";

        private readonly IImageFileWriter _imageFileWriter;

        private readonly ILogger<MachineModelController> _logger;

        public MachineModelController(
            ILogger<MachineModelController> logger, IImageFileWriter imageFileWriter)
        {
            //Get injected dependencies
            _logger = logger;
            _imageFileWriter = imageFileWriter;

            string? pythonHome =
                Environment.GetEnvironmentVariable("PYTHONHOME", EnvironmentVariableTarget.Process);
            string? pythonPath =
                Environment.GetEnvironmentVariable("PYTHONPATH", EnvironmentVariableTarget.Process);

            Debug.WriteLine(pythonHome);
            Debug.WriteLine(pythonPath);
        }

        // GET: api/<MachineModelController>
        [HttpGet]
        public IEnumerable<MachineModel> GetAllModels()
        {
            return new List<MachineModel>
            {
                new("3035-cup.h5", DateTime.Now),
                new("9001-cup.h5", DateTime.Now)
            };
        }

        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/TrainModel")]
        public async Task<IActionResult> TrainModel(MachineModel machineModel)
        {
            string imagePath = Path.GetFullPath($"TemporaryImages\\{machineModel.Name}");
            string modelPath = Path.GetFullPath($"MachineModels\\{machineModel.Name}");

            string combinedCommand = $"{TrainingScriptLocation} {modelPath} {imagePath}";

            string returnValue = PythonScriptEngine.ExecutePythonScript(combinedCommand);

            return Ok(returnValue);
        }

        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/Identify")]
        public async Task<IActionResult> IdentityObjectFromFileAsync(IFormFile? imageFile, string modelName)
        {
            if (imageFile == null || imageFile.Length == 0)
                return BadRequest();
            try
            {
                _logger.LogInformation("Start processing image...");

                string temporaryFileLocation = await _imageFileWriter.UploadImageAsync(imageFile);
                string imagePath = Path.GetFullPath($"TemporaryImages\\{temporaryFileLocation}");
                string modelPath = Path.GetFullPath($"MachineModels\\{modelName}");

                string combinedCommand = $"{PredictScriptLocation} {modelPath} {imagePath}";

                string returnValue = PythonScriptEngine.ExecutePythonScript(combinedCommand);

                string[] splitValues = returnValue.Split('|');

                string label = splitValues[0];
                float.TryParse(splitValues[1], NumberStyles.Float, CultureInfo.InvariantCulture, out float fValue);

                var imageResult = new ImageResult(label, fValue * 100);

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