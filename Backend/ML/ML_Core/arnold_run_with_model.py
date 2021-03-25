# ML Core Function - Execute existing model
# DM 2021-03-011
# v2 (DM 2021-03-12)
# Reference https://towardsdatascience.com/10-minutes-to-building-a-cnn-binary-image-classifier-in-tensorflow-4e216b2034aa

# Imports/ Installs
import os
import sys
import pip

# Suppress TF gpu warning
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'

try:
    import tensorflow as tf
    from tensorflow import keras
    from keras.models import load_model
except:
    # Run Imports
    print("Didn't install your stuff, man.")
    pip.main(['install','tensorflow'])
    import tensorflow as tf
    from tensorflow import keras
    from keras.models import load_model
    

# Variable
try:
    len(sys.argv[1])
    model_location = sys.argv[1]
    image_location = sys.argv[2]
except:
    # These are no file errors but handy to have default for now
    model_location = "C:/Users/danie/OneDrive/Documents/git/IP3/Backend/ML/ML_Core/models/3035-cup.h5"
    image_location = "C:/Users/danie/OneDrive/Documents/Uni Shit/Year 3/Tri_Bute/IPFreely/IP3/Backend/ML_Core/User_Images/test/test_cup_2.jpeg"

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