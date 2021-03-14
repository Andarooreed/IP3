using System;

namespace WhatsInThePhotoAPI.Models
{
    public class MachineModel
    {
        public MachineModel(string name, DateTime dateCreated)
        {
            Name = name;
            DateCreated = dateCreated;
        }

        public string Name { get; set; }

        public DateTime DateCreated { get; set; }
    }
}