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

model = keras.models.load_model("md2_cupstables50ep.h5")
#model.summary()

img = keras.preprocessing.image.load_img(
    "ML_Core/User_Images/simple_images/teacup/table_102.jpeg", target_size=(180, 180)
)

img_array = keras.preprocessing.image.img_to_array(img)
img_array = tf.expand_dims(img_array, 0)

predictions = model.predict(img_array)
score = predictions[0]

print(
    "This image is %.2f percent Cup and %.2f percent Table."
    % (100 * (1 - score), 100 * score)
)

print(predictions)