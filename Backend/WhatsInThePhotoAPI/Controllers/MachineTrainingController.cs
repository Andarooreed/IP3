using System;
using Keras;
using Keras.Datasets;
using Keras.Layers;
using Keras.Models;
using Keras.Optimizers;
using Keras.Utils;
using Numpy;

namespace WhatsInThePhotoAPI.Controllers
{
    public class MachineTrainingController
    {
        public static void Run()
        {
            int batch_size = 128;
            int num_classes = 10;
            int epochs = 100;

            // the data, split between train and test sets
            ((NDarray x_train, NDarray y_train), (NDarray x_test, NDarray y_test)) = Cifar10.LoadData();

            Console.WriteLine("x_train shape: " + x_train.shape);
            Console.WriteLine(x_train.shape[0] + " train samples");
            Console.WriteLine(x_test.shape[0] + " test samples");

            // convert class vectors to binary class matrices
            y_train = Util.ToCategorical(y_train, num_classes);
            y_test = Util.ToCategorical(y_test, num_classes);


            // Build CNN model
            var model = new Sequential();
            model.Add(new Conv2D(32, (3, 3).ToTuple(),
                padding: "same",
                input_shape: new Shape(32, 32, 3)));
            model.Add(new Activation("relu"));
            model.Add(new Conv2D(32, (3, 3).ToTuple()));
            model.Add(new Activation("relu"));
            model.Add(new MaxPooling2D((2, 2).ToTuple()));
            model.Add(new Dropout(0.25));

            model.Add(new Conv2D(64, (3, 3).ToTuple(),
                padding: "same"));
            model.Add(new Activation("relu"));
            model.Add(new Conv2D(64, (3, 3).ToTuple()));
            model.Add(new Activation("relu"));
            model.Add(new MaxPooling2D((2, 2).ToTuple()));
            model.Add(new Dropout(0.25));

            model.Add(new Flatten());
            model.Add(new Dense(512));
            model.Add(new Activation("relu"));
            model.Add(new Dropout(0.5));
            model.Add(new Dense(num_classes));
            model.Add(new Activation("softmax"));

            model.Compile(loss: "categorical_crossentropy",
                optimizer: new RMSprop(0.0001f, decay: 1e-6f), metrics: new[] {"accuracy"});

            x_train = x_train.astype(np.float32);
            x_test = x_test.astype(np.float32);
            x_train /= 255;
            x_test /= 255;

            model.Fit(x_train, y_train,
                batch_size,
                epochs,
                1,
                validation_data: new[] {x_test, y_test},
                shuffle: true);

            //Save model and weights
            //string model_path = "./model.json";
            //string weight_path = "weights.h5";
            //string json = model.ToJson();
            //File.WriteAllText(model_path, json);
            model.SaveWeight("weights.h5");
            model.Save("model.h5");
            model.SaveTensorflowJSFormat("./");

            //Score trained model.
            double[] score = model.Evaluate(x_test, y_test, verbose: 0);
            Console.WriteLine("Test loss:" + score[0]);
            Console.WriteLine("Test accuracy:" + score[1]);
        }
    }
}