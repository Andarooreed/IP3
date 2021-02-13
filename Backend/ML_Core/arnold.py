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

try:
    epochs = int(sys.argv[3])
except:
    epochs = 50

root_folder = "ML_Core/User_Images/"
path = root_folder + source_folder

# Call resize.py to normalise folder... this will probably be part of the image upload logic but fuck it, I need it here just now.
#OFF FOR TESTING    os.system("resize.py " + source_folder + " " + str(img_size[0]))

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

        # Stick in the previous runs shit
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

epochs = epochs # really need to add a leading character to input vars

callbacks = [
    keras.callbacks.ModelCheckpoint("save_at_{epoch}.h5")
]

model.compile(
    optimizer=keras.optimizers.Adam(1e-3),
    loss="binary_crossentropy",
    metrics=["accuracy"] # see what other metrics there are
)

model.fit(
    ds_train, epochs=epochs, callbacks=callbacks, validation_data=ds_validate
)

# Save it

model.save("md2_cupstables50ep.h5")