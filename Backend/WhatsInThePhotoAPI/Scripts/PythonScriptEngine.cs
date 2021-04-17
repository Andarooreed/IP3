using System;
using System.Diagnostics;

namespace WhatsInThePhotoAPI.Scripts
{
    /// <summary> C# Python Interpreter, executes python scripts </summary>
    public static class PythonScriptEngine
    {
        private static readonly string _pythonExePath =
            @"C:\Users\andy\AppData\Local\Programs\Python\Python38\python.exe";

        // <summary> Execute Python script file </summary>
        /// <param name="command">Python script file and input parameter(s)</param>
        /// <returns> Output text result</returns>
        public static string ExecutePythonScript(string command)
        {
            string outputText = string.Empty;

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
                string standardError = process.StandardError.ReadToEnd();

                Debug.WriteLine(standardError);
                Debug.WriteLine(outputText);

                process.WaitForExit();
            }
            catch (Exception ex)
            {
                string exceptionMessage = ex.Message;
                Debug.WriteLine(exceptionMessage);
            }

            return outputText;
        }
    }
}