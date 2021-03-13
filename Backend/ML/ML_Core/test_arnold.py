# ML Core Function - Execute existing model
# DM 2021-03-011
# v2 (DM 2021-03-12)
# Reference https://towardsdatascience.com/10-minutes-to-building-a-cnn-binary-image-classifier-in-tensorflow-4e216b2034aa

# Imports/ Installs
import os
import sys
import configparser

# Suppress TF gpu warning
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'

import tensorflow as tf
from tensorflow import keras
from keras.models import load_model   

# Read Config
cf = configparser.ConfigParser()
cf.read('ML/config.ini')

# Variable
try:
    len(sys.argv[1])
    model_location = sys.argv[1]
    image_location = sys.argv[2]
except:
    # Load the default test data if testing set to true, otherwise exit
    if int(cf['test_list']['test_arnold']) == 1:
        model_location = "ML/ML_Core/models/3035-cup.h5"
        image_location = "ML/test_cup.jpeg"
    else:
        print("Image or Model not found.")
        raise SystemExit

img_size = (180, 180)
label = model_location.split("-")[1].replace(".h5","").title()

# Predict
model = keras.models.load_model(model_location)

img = keras.preprocessing.image.load_img(image_location, target_size=img_size)

img_array = keras.preprocessing.image.img_to_array(img)
img_array = tf.expand_dims(img_array, 0)  # Create batch axis

predictions = model.predict(img_array)

# Print Result
print(label + "|" + str(predictions[0][0]))