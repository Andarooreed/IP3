using System;
using System.IO;

namespace WhatsInThePhotoAPI
{
    public static class CommonHelpers
    {
        public static string GetAbsolutePath(string relativePath)
        {
            var dataRoot = new FileInfo(typeof(Program).Assembly.Location);
            string? assemblyFolderPath = dataRoot?.Directory?.FullName;

            string? fullPath = Path.Combine(assemblyFolderPath ?? throw new InvalidOperationException(), relativePath);

            return fullPath;
        }
    }
}