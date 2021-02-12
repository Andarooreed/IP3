# ML Core Function - train data set
# DM 2021-02-12
# v1 (DM 2021-02-12)
# Reference https://keras.io/examples/vision/image_classification_from_scratch/

# LETS DO SOME SHIETTT!

# Imports/ Installs
import os
import sys
import pip
try:
    import tensorflow as tf
    from tensorflow import keras
    from tensorflow.keras import layers
except:
    print("Installing Tensorflow... could take a minute")
    pip.main(['install','tensorflow'])
    import tensorflow as tf
    from tensorflow import keras
    from tensorflow.keras import layers

# Get user variables
try:
    source_folder = sys.argv[1] + "/"
except:
    source_folder = "AdrienVeidt_cups/"

try:
    img_size = (int(sys.argv[2]), int(sys.argv[2]))
except:
    img_size = (180, 180)

try:
    batch_size = int(sys.argv[2])
except:
    batch_size = 32

# Call resize.py to normalise folder... this will probably be part of the image upload logic but fuck it, I need it here just now.
os.system("resize.py " + source_folder + " " + str(img_size[0]))

