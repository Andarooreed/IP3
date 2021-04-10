# ML Core Function - train data set
# DM 2021-03-06
# v2 (DM 2021-03-12)
# Reference https://towardsdatascience.com/10-minutes-to-building-a-cnn-binary-image-classifier-in-tensorflow-4e216b2034aa

# inputs: [Label] [Image Folder Location] [OPTIONAL: Epochs]

# Imports/ Installs
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3' # Suppress TF gpu warning

import configparser
import sys
import tensorflow as tf
from tensorflow import keras
from tensorflow.keras import layers
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from functions.folder_fixer import folder_fixer

# Read Config
cf = configparser.ConfigParser()
cf.read('ML/config.ini')

# Variable - [Image Folder Location] [OPTIONAL: Epochs]

try:
    len(sys.argv[1])
    source_folder = sys.argv[1]
except:
    # Load the default test data if testing set to true, otherwise exit
    if int(cf['test_list']['train_arnold']) == 1:
        source_folder = "ML/user_images/24601-Hugh_Man-Cups"
        epochs = 2   
    else:
        print("Source Folder not found.")
        raise SystemExit

try:
    len(sys.argv[2])
    epochs = int(sys.argv[2])
except:
    if int(cf['test_list']['train_arnold']) == 1:
        epochs = 2   
    else:
        epochs = 15

img_size = (180, 180)
batch_size = 32

# Create required folder structure and capture the relevent folders from it
working_dir = folder_fixer(source_folder)

# Generate dataset
ds_train = tf.keras.preprocessing.image_dataset_from_directory(
    working_dir["train_path"],
    validation_split=0.2,
    subset="training",
    seed=1337,
    image_size=img_size,
    batch_size=batch_size
)

ds_validate =  tf.keras.preprocessing.image_dataset_from_directory(
    working_dir["test_path"],
    validation_split=0.2,
    subset="validation",
    seed=1337,
    image_size=img_size,
    batch_size=batch_size
)

# Set datasets to prefetch so save IO
ds_train = ds_train.prefetch(buffer_size=batch_size)
ds_validate = ds_validate.prefetch(buffer_size=batch_size)

# Augment the data set by inferring "new" images from the set - just tilts them horizontally a bit so the machine see's shit different
data_augmentation = keras.Sequential(
    [
        layers.experimental.preprocessing.RandomFlip("horizontal"),
        layers.experimental.preprocessing.RandomRotation(0.1)
    ]
)

# Build the phreakin' Model man
def make_model(input_shape, num_classes):
    inputs = keras.Input(shape=input_shape)
    x = data_augmentation(inputs)

    # Models are like onions, they got layers
    x = layers.experimental.preprocessing.Rescaling(1.0 / 255)(x)
    x = layers.Conv2D(32, 3, strides=2, padding="same")(x)
    x = layers.BatchNormalization()(x)
    x = layers.Activation("relu")(x)

    x = layers.Conv2D(64, 3, padding="same")(x)
    x = layers.BatchNormalization()(x)
    x = layers.Activation("relu")(x)

    previous_block_activation = x

    for size in [128, 256, 512, 728]:
        x = layers.Activation("relu")(x)
        x = layers.SeparableConv2D(size, 3, padding="same")(x)
        x = layers.BatchNormalization()(x)

        x = layers.Activation("relu")(x)
        x = layers.SeparableConv2D(size, 3, padding="same")(x)
        x = layers.BatchNormalization()(x)

        x = layers.MaxPooling2D(3, strides=2, padding="same")(x)

        # Check against previous run
        residual = layers.Conv2D(size, 1, strides=2, padding="same")(
            previous_block_activation
        )
        x = layers.add([x, residual])
        previous_block_activation = x # reset prev run to this run

    x = layers.SeparableConv2D(1024, 3, padding="same")(x)
    x = layers.BatchNormalization()(x)
    x = layers.Activation("relu")(x)

    x = layers.GlobalAveragePooling2D()(x)
    if num_classes == 2:
        activation = "sigmoid"
        units = 1
    else:
        activation = "softmax"
        units = num_classes

    x = layers.Dropout(0.5)(x)
    outputs = layers.Dense(units, activation=activation)(x)
    return keras.Model(inputs, outputs)

model = make_model(input_shape=img_size + (3,), num_classes = 2)

# Train da models
epochs = epochs 

callbacks = [
    keras.callbacks.ModelCheckpoint("ML/ML_Core/models/callbacks/" + working_dir["source_id"] + "_at_{epoch}.h5")
]

model.compile(
    optimizer=keras.optimizers.Adam(1e-3),
    loss="binary_crossentropy",
    metrics=["accuracy"] # see what other metrics there are
)

model.fit(
    ds_train, epochs=epochs, callbacks=callbacks, validation_data=ds_validate
)

# Name Model
name = working_dir["source_id"] + "-" + working_dir["source_label"] + ".h5"

# Save it
model.save("ML/ML_Core/models/" + name)