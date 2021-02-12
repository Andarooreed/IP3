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

try:
    import matplotlib.pyplot as plt
except:
    print("Installing matplot... could take a minute")
    pip.main(['install','matplotlib'])
    import matplotlib.pyplot as plt

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

root_folder = "ML_Core/User_Images/"
path = root_folder + source_folder

# Call resize.py to normalise folder... this will probably be part of the image upload logic but fuck it, I need it here just now.
os.system("resize.py " + source_folder + " " + str(img_size[0]))

print(os.getcwd())
#os.chdir("ML_Core/User_Images/AdrienVeidt_cups")
#print(os.getcwd())

print(path)
# Generate dataset
ds_train = tf.keras.preprocessing.image_dataset_from_directory(
    "ML_Core/User_Images/AdrienVeidt_cups",
    validation_split=0.2,
    subset="training",
    seed=1337,
    image_size=img_size,
    batch_size=batch_size
)

ds_validate =  tf.keras.preprocessing.image_dataset_from_directory(
    "ML_Core/User_Images/AdrienVeidt_cups",
    validation_split=0.2,
    subset="validation",
    seed=1337,
    image_size=img_size,
    batch_size=batch_size
)

# Lets take a look - currently counting "Thumbs" as a different class because it's in the folder structure... that'll confuse me tomorrow

