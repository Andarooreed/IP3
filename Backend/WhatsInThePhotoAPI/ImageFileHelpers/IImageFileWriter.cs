using System;
using System.IO;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;

namespace WhatsInThePhotoAPI.ImageFileHelpers
{
    /// <summary> Interface to use in DI/IoC </summary>
    public interface IImageFileWriter
    {
        Task<string> UploadImageAsync(IFormFile file);

        void DeleteImageTempFile(string filePathName);
    }

    /// <summary> Implementation class to inject with DI/IoC </summary>
    public class ImageFileWriter : IImageFileWriter
    {
        string _imagesTmpFolder = CommonHelpers.GetAbsolutePath(@"../../../TemporaryImages");

        public async Task<string> UploadImageAsync(IFormFile file)
        {
            if (CheckIfImageFile(file)) return await WriteFile(file);

            return "Invalid image file";
        }

        public void DeleteImageTempFile(string filePathName)
        {
            try
            {
                File.Delete(filePathName);
            }
            catch (Exception e)
            {
                throw e;
            }
        }

        /// <summary> Method to check if file is image file </summary>
        /// <param name="file"></param>
        /// <returns></returns>
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
        /// <param name="file"></param>
        /// <returns></returns>
        public async Task<string> WriteFile(IFormFile file)
        {
            string fileName;
            try
            {
                var extension = "." + file.FileName.Split('.')[^1];
                fileName = Guid.NewGuid() + extension; //Create a new name for the file 

                var filePathName = Path.Combine(Directory.GetCurrentDirectory(), _imagesTmpFolder, fileName);

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