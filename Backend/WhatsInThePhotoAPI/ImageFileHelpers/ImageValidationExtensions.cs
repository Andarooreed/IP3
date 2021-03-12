using System.Linq;
using System.Text;

namespace WhatsInThePhotoAPI.ImageFileHelpers
{
    public static class ImageValidationExtensions
    {
        public enum ImageFormat
        {
            Bmp,
            Jpeg,
            Gif,
            Tiff,
            Png,
            Unknown
        }

        public static bool IsValidImage(this byte[] image)
        {
            ImageFormat imageFormat = GetImageFormat(image);
            return imageFormat == ImageFormat.Jpeg ||
                   imageFormat == ImageFormat.Png;
        }

        public static ImageFormat GetImageFormat(byte[] bytes)
        {
            // see http://www.mikekunz.com/image_file_header.html  
            byte[] bmp = Encoding.ASCII.GetBytes("BM"); // BMP
            byte[] gif = Encoding.ASCII.GetBytes("GIF"); // GIF
            byte[] png = {137, 80, 78, 71}; // PNG
            byte[] tiff = {73, 73, 42}; // TIFF
            byte[] tiff2 = {77, 77, 42}; // TIFF
            byte[] jpeg = {255, 216, 255, 224}; // jpeg
            byte[] jpeg2 = {255, 216, 255, 225}; // jpeg canon
            byte[] jpg1 = {255, 216, 255, 219};
            byte[] jpg2 = {255, 216, 255, 226};

            if (bmp.SequenceEqual(bytes.Take(bmp.Length)))
                return ImageFormat.Bmp;

            if (gif.SequenceEqual(bytes.Take(gif.Length)))
                return ImageFormat.Gif;

            if (png.SequenceEqual(bytes.Take(png.Length)))
                return ImageFormat.Png;

            if (tiff.SequenceEqual(bytes.Take(tiff.Length)))
                return ImageFormat.Tiff;

            if (tiff2.SequenceEqual(bytes.Take(tiff2.Length)))
                return ImageFormat.Tiff;

            if (jpeg.SequenceEqual(bytes.Take(jpeg.Length)) || jpg1.SequenceEqual(bytes.Take(jpg1.Length)) ||
                jpg2.SequenceEqual(bytes.Take(jpg2.Length)))
                return ImageFormat.Jpeg;

            return jpeg2.SequenceEqual(bytes.Take(jpeg2.Length)) ? ImageFormat.Jpeg : ImageFormat.Unknown;
        }
    }
}