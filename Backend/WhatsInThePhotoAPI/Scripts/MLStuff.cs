using System;
using System.Diagnostics;

namespace WhatsInThePhotoAPI.Scripts
{
    /// <summary>
    ///     Machine Learning C# - Python
    /// </summary>
    public static class MLStuff
    {
        private static readonly string _pythonExePath =
            @"C:\Users\Jargar\AppData\Local\Programs\Python\Python38\python.exe";


        private static string imagePathName =
            @"C:\Users\Jargar\Source\Repos\Andarooreed\IP3\Backend\WhatsInThePhotoAPI\TestImages\testimage1.jpeg";

        /// <summary>
        ///     ML Sharp Python class constructor
        /// </summary>
        /// <param name="exePythonPath">Python EXE file path</param>
        static MLStuff()
        {
        }

        // <summary> Execute Python script file </summary>
        /// <param name="filePythonScript">Python script file and input parameter(s)</param>
        /// <param name="standardError">Output standard error</param>
        /// <returns>Output text result</returns>
        public static string ExecutePythonScript(string command)
        {
            string outputText = string.Empty;
            string standardError = string.Empty;

            try
            {
                using var process = new Process
                {
                    StartInfo = new ProcessStartInfo(_pythonExePath)
                    {
                        Arguments = command,
                        UseShellExecute = false,
                        RedirectStandardOutput = true,
                        RedirectStandardError = true,
                        CreateNoWindow = true
                    }
                };
                process.Start();
                outputText = process.StandardOutput.ReadToEnd();
                outputText = outputText.Replace(Environment.NewLine, string.Empty);
                standardError = process.StandardError.ReadToEnd();
                process.WaitForExit();
            }
            catch (Exception ex)
            {
                string exceptionMessage = ex.Message;
            }

            return outputText;
        }
    }
}