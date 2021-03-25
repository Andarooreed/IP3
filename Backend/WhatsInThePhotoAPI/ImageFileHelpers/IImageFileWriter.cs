using System;
using System.Diagnostics;
using System.IO;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;

namespace WhatsInThePhotoAPI.ImageFileHelpers
{
    /// <summary> Interface to use in DI/IoC </summary>
    public interface IImageFileWriter
    {
        Task<string> UploadImageAsync(IFormFile file, bool keepImages);

        void DeleteImageTempFile(string filePathName);
    }

    /// <summary> Implementation class to inject with DI/IoC </summary>
    public class ImageFileWriter : IImageFileWriter
    {
        private readonly string _imagesTmpFolder = CommonHelpers.GetAbsolutePath(@"../../../TemporaryImages");

        private readonly string _userImages = CommonHelpers.GetAbsolutePath(@"../../../User_Images");

        public async Task<string> UploadImageAsync(IFormFile file, bool keepImages)
        {
            if (CheckIfImageFile(file)) return await WriteFile(file, keepImages);

            return "Invalid image file";
        }

        public void DeleteImageTempFile(string filePathName)
        {
            try
            {
                File.Delete(filePathName);
            }
            catch (Exception exception)
            {
                Debug.WriteLine(exception);
                throw;
            }
        }

        /// <summary> Method to check if file is image file </summary>
        private static bool CheckIfImageFile(IFormFile file)
        {
            byte[] fileBytes;
            using (var ms = new MemoryStream())
            {
                file.CopyTo(ms);
                fileBytes = ms.ToArray();
            }

            return ImageValidationExtensions.GetImageFormat(fileBytes) != ImageValidationExtensions.ImageFormat.Unknown;
        }

        /// <summary> Method to write file onto the disk </summary>
        public async Task<string> WriteFile(IFormFile file, bool keepImages)
        {
            string fileName;
            try
            {
                string? extension = "." + file.FileName.Split('.')[^1];
                fileName = Guid.NewGuid() + extension; //Create a new name for the file 

                string? filePathName = string.Empty;

                filePathName = Path.Combine(Directory.GetCurrentDirectory(),
                    keepImages ? _userImages : _imagesTmpFolder, fileName);

                await using var fileStream = new FileStream(filePathName, FileMode.Create);
                await file.CopyToAsync(fileStream);
            }
            catch (Exception e)
            {
                return e.Message;
            }

            return fileName;
        }
    }
}