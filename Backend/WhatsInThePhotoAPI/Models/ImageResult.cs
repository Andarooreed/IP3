namespace WhatsInThePhotoAPI.Models
{
    public class ImageResult
    {
        public ImageResult(string label, float percentageResult)
        {
            Label = label;
            PercentageResult = percentageResult;
        }

        public string Label { get; init; }

        public float PercentageResult { get; init; }
    }
}