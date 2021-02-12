# Batch process images to get scaled down and thumbnail
# DM 2021-02-12
# Reference https://stackoverflow.com/questions/21517879/python-pil-resize-all-images-in-a-folder

import pip
import os
import sys
print(os.getcwd())
try:
    from PIL import Image
except:
    pip.main(['install','Pillow'])
    from PIL import Image

try:
    source_folder = sys.argv[1] + "/"
except:
    source_folder = "simple_images/tea_cup/"

try:
    size_x = int(sys.argv[2])
except:
    size_x = 250

try:
    size_y = int(sys.argv[3])
except:
    size_y = size_x

size_thumb = (125,125)

root_folder = "ML_Core/User_Images/"

path = root_folder + source_folder

#print(path)

images = os.listdir(path)

print("Normalising Images")

try:
    os.mkdir(path + "/thumbs")
except:
    pass


def normalise():
    for item in images:
        if os.path.isfile(path + item):
            print(path)
            im = Image.open(path + item)
            f, e = os.path.splitext(path + item)
           # Thumb Me
            image_thumb = im.resize(size_thumb, Image.ANTIALIAS)
            image_thumb.save(path + "thumbs/" + item + '_thumb.png', 'PNG', quality=90)
            # Downscaled image
            image_resized = im.resize((size_x, size_y), Image.ANTIALIAS)
            image_resized.save(f + e , 'JPEG', quality=90)
            print("Image '" + f + "' Completed.")

normalise()

        
