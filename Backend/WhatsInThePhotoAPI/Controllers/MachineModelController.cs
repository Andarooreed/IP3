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
using MySql.Data.MySqlClient;
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
            var context =
                HttpContext.RequestServices.GetService(typeof(MachineModelContext)) as MachineModelContext;

            return context.GetAllMachineModels();
        }


        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/TrainModel")]
        public async Task<IActionResult> TrainModel(string folderName)
        {
            const string trainingScriptLocation = @"Scripts\TrainModel.py";

            string combinedCommand = $"{trainingScriptLocation} {folderName} ";

            string returnValue = PythonScriptEngine.ExecutePythonScript(combinedCommand);

            return Ok(returnValue);
        }

        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/DownloadImage")]
        public async Task<IActionResult> DownloadImages(string imageDownloadQuery,
            int imageAmount)
        {
            const string downloadImagesScriptLocation = @"Scripts\DownloadImages.py";

            string combinedCommand = $"{downloadImagesScriptLocation} {imageDownloadQuery} {imageAmount}";

            string returnValue = PythonScriptEngine.ExecutePythonScript(combinedCommand);
            return Ok(returnValue);
        }


        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/Identify")]
        public async Task<IActionResult> IdentityObjectFromFileAsync(string filename, string modelName)
        {
            try
            {
                _logger.LogInformation("Start processing image...");

                const string predictScriptLocation = @"Scripts\PredictScript.py";

                string imagePath = Path.GetFullPath($"TemporaryImages\\{filename}");
                string modelPath = Path.GetFullPath($"MachineModels\\{modelName}");

                string combinedCommand = $"{predictScriptLocation} {modelPath} {imagePath}";

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


        [HttpPost]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        [Route("api/[controller]/UploadImage")]
        public async Task<IActionResult> UploadImage(IFormFile? imageFile, string modelId)
        {
            if (imageFile == null || imageFile.Length == 0)
                return BadRequest();
            try
            {
                _logger.LogInformation("Start processing image...");

                string temporaryFileLocation = await _imageFileWriter.UploadImageAsync(imageFile, true);

                string imagePath = Path.GetFullPath($"User_Images\\{temporaryFileLocation}");

                return Ok();
            }
            catch (Exception e)
            {
                _logger.LogInformation("Error is: " + e.Message);
                return BadRequest();
            }
        }
    }


    public class MachineModelContext
    {
        public MachineModelContext(string connectionString)
        {
            ConnectionString = connectionString;
        }

        public string ConnectionString { get; set; }

        public List<MachineModel> GetAllMachineModels()
        {
            List<MachineModel> list = new();

            using MySqlConnection conn = GetConnection();
            conn.Open();
            MySqlCommand cmd = new("Select * From model", conn);

            using MySqlDataReader? reader = cmd.ExecuteReader();
            while (reader.Read())
                list.Add(new MachineModel
                {
                    ModelId = Convert.ToInt32(reader["model_id"]),
                    Name = reader["name"].ToString(),
                    UserId = Convert.ToInt32(reader["user_id"]),
                    ImageGroupId = Convert.ToInt32(reader["image_group_id"]),
                    Location = reader["location"].ToString(),
                    LastDateUpdate = Convert.ToDateTime(reader["last_update_dt"])
                });

            return list;
        }

        private MySqlConnection GetConnection()
        {
            return new(ConnectionString);
        }
    }
}