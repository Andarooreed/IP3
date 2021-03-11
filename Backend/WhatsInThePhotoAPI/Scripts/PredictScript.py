# ML Core Function - Execute existing model
# DM 2021-03-011
# v1 (DM 2021-03-11)
# Reference https://towardsdatascience.com/10-minutes-to-building-a-cnn-binary-image-classifier-in-tensorflow-4e216b2034aa

# Imports/ Installs
import os
import sys
import pip

try:
    import tensorflow as tf
    from tensorflow import keras
    from keras.models import load_model
except:
    import tensorflow as tf
    from tensorflow import keras

# Variable
try:
    len(sys.argv[1])
    model_location = sys.argv[1]
    image_location = sys.argv[2]
except:
    # These are no file errors but handy to have default for now
    model_location = "C:\\Users\\Jargar\\Source\Repos\\Andarooreed\\IP3\\Backend\WhatsInThePhotoAPI\\MachineModels\\md2_cupstables50ep.h5"
    image_location = "C:\\Users\\Jargar\\Source\Repos\\Andarooreed\\IP3\\Backend\WhatsInThePhotoAPI\\TestImages\\testimage4.jpeg"

img_size = (180, 180)

# Predict
print(os.getcwd())
model = keras.models.load_model(model_location)

img = keras.preprocessing.image.load_img(image_location, target_size=img_size)

img_array = keras.preprocessing.image.img_to_array(img)
img_array = tf.expand_dims(img_array, 0)  # Create batch axis

predictions = model.predict(img_array)

# Print Result
print (predictions[0][0])
print(predictions)
print("Results")
print (predictions[0][0])

print("Results" + predictions)