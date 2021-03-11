using System;
using System.IO;
using System.Linq;
using Keras.Datasets;
using Keras.Layers;
using Keras.Models;
using Keras.Utils;
using Numpy;

namespace WhatsInThePhotoAPI.Train_Model
{
    /// <summary>
    /// https://www.codeproject.com/Articles/5286497/Starting-with-Keras-NET-in-Csharp-Train-Your-First
    /// </summary>
    public class ModelTraining
    {
        public void TrainModel()
        {

            var batch_size = 1000; //Size of the batches per epoch
            var num_classes = 10; //We got 10 outputs since 
            //we can predict 10 different labels seen on the 
            //dataset: https://github.com/zalandoresearch/fashion-mnist#labels
            var epochs = 30; //Amount on trainingperiods, 
            //I figure it out that the maximum is something about 
            //700 epochs, after this it won't increase the 
            //accuracy siginificantly

            // input image dimensions
            int img_rows = 28, img_cols = 28;

            // the data, split between train and test sets
            var ((x_train, y_train), (x_test, y_test)) =
                FashionMNIST.LoadData(); // Load the datasets from 
            // fashion MNIST, Keras.Net implement this directly

            x_train.reshape(-1, img_rows, img_cols).astype(np.float32); //ByteArray needs 
            //to be reshaped to fit the dimmensions of the y arrays

            y_train = Util.ToCategorical(y_train, num_classes); //here, you modify the 
            //forecast data to 10 outputs
            //as we have 10 different 
            //labels to predict (see the 
            //Labels on the Dataset)
            y_test = Util.ToCategorical(y_test, num_classes); //same for the test data 
            //[hint: you can change this 
            //in example you want to 
            //make just a binary 
            //crossentropy as you just 
            //want to figure, i.e., if 
            //this is a angleboot or not

            var model = new Sequential();

            model.Add(new Dense(100, 784, "sigmoid")); //hidden dense layer, with 100 neurons, 
            //you have 28*28 pixel which make 
            //784 'inputs', and sigmoid function 
            //as activationfunction
            model.Add(new Dense(10, null, "sigmoid")); //Ouputlayer with 10 outputs,...
            model.Compile("sgd", "categorical_crossentropy",
                new[] {"accuracy"}); //we have a crossentropy as prediction 
            //and want to see as well the 
            //accuracy metric.

            var X_train = x_train.reshape(60000, 784); //this is actually very important. 
            //C# works with pointers, 
            //so if you have to reshape (again) 
            //the function for the correct 
            //processing, you need to write this 
            //to a different var
            var X_test = x_test.reshape(10000, 784);

            model.Fit(X_train, y_train, batch_size, epochs); //now, we set the data to 
            //the model with all the 
            //arguments (x and y data, 
            //batch size...the '1' is 
            //just verbose=1

            Console.WriteLine("---------------------");
            Console.WriteLine(X_train.shape);
            Console.WriteLine(X_test.shape);
            Console.WriteLine(y_train[0]);
            Console.WriteLine(y_train[1]); //some outputs...you can play with them

            var y_train_pred = model.Predict(X_train); //prediction on the train data
            Console.WriteLine(y_train_pred);

            model.Evaluate(X_test.reshape(-1, 784), y_test); //-1 tells the code that 
            //it can figure out the size of 
            //the array by itself
        }

        private byte[] openDatas(string path, int skip) //just the open Data function. 
            //As I mentioned, I did not work 
            //with unzip stuff, you have 
            //to unzip the data before 
            //by yourself
        {
            var file = File.ReadAllBytes(path).Skip(skip).ToArray();
            return file;
        }

        //Hint: First, I was working by opening the data locally and 
        //I wanted to figure it out how to present data to the arrays. 
        //So you can use something like this and call this within the TrainModel() function:
        //x_train = openDatas(@"PATH\OF\YOUR\DATAS\train-images-idx3-ubyte", 16);
        //y_train = openDatas(@"PATH\OF\YOUR\DATAS\train-labels-idx1-ubyte", 8);
        //x_test = openDatas(@"PATH\OF\YOUR\DATAS\t10k-images-idx3-ubyte", 16);
        //y_test = openDatas(@"PATH\OF\YOUR\DATAS\t10k-labels-idx1-ubyte", 8);
    }
}