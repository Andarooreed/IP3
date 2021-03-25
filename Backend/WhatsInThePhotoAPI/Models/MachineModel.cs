using System;

namespace WhatsInThePhotoAPI.Models
{
    public class MachineModel
    {
        public int ModelId { get; set; }

        public int UserId { get; set; }

        public string Name { get; set; }

        public int ImageGroupId { get; set; }

        public string Location { get; set; }

        public DateTime LastDateUpdate { get; set; }
    }
}