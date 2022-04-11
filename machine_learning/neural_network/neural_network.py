#Neural Network Model with 1 Hidden Layer using python

import numpy as np
import matplotlib.pyplot as plt
from sklearn.model_selection import train_test_split

#Importing dataset (dataset source: http://archive.ics.uci.edu/ml/datasets/banknote+authentication)
data = np.genfromtxt('machine_learning/neural_network/data_banknote_authetication.txt', delimiter = ',')
X = data[:,:4] #4 input variables
y = data[:,4] #1 output variable

#Visualizing dataset before using neural network model
plt.scatter(X[:, 0], X[:, 1], alpha=0.2, c=y, cmap='viridis')
plt.xlabel('variance of wavelet')
plt.ylabel('skewness of wavelet')
plt.show()

#Dividing the data for training and testing
#train_test_split() function can select some data from the dataset for test and train.
#Here the test is 20% of the dataset and rest of the data is for training the model
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

X_train = X_train.T
y_train = y_train.reshape(1, y_train.shape[0])

X_test = X_test.T
y_test = y_test.reshape(1, y_test.shape[0])

print('Train X Shape: ', X_train.shape)
print('Train y Shape: ', y_train.shape)
print('I have m = %d training examples!' % (X_train.shape[1]))

print('\nTest X Shape: ', X_test.shape)


#Building a neural network with a single hidden layer
#Defining the structure
def define_structure(X, y):
    input_unit = X.shape[0]
    hidden_unit = 4
    output_unit = y.shape[0]
    return (input_unit, hidden_unit, output_unit)

(input_unit, hidden_unit, output_unit) = define_structure(X_train, y_train)
print("The size of the input layer is: = " + str(input_unit))
print("The size of the hidden layer is: = " + str(hidden_unit))
print("The size of the output layer is: = " + str(output_unit))


#Initializing model parameter
def parameters_initialization(input_unit, hidden_unit, output_unit):
    np.random.seed(2)
    w1 = np.random.randn(hidden_unit, input_unit)*0.01
    b1 = np.zeros((hidden_unit, 1))
    w2 = np.random.randn(output_unit, hidden_unit)*0.01
    b2 = np.zeros((output_unit, 1))
    parameters = {"w1": w1,
                  "b1": b1,
                  "w2": w2,
                  "b2": b2,}
    return parameters


#Forward propagation
#Hidden layer using tanh activation function
#Output layer using sigmoid activation fuction
#tanh and sigmoid activation funtion source: https://kotakode.com/blogs/3468/10-Konsep-Deep-Learning-yang-Harus-Kamu-Ketahui-untuk-Interview
def sigmoid(z):
    return 1/(1+np.exp(-z))

def forward_propagation(X, parameters):
    w1 = parameters["w1"]
    b1 = parameters["b1"]
    w2 = parameters["w2"]
    b2 = parameters["b2"]

    Z1 = np.dot(w1, X) + b1
    A1 = np.tanh(Z1)
    Z2 = np.dot(w2, A1) + b2
    A2 = sigmoid(Z2)
    cache = {"Z1": Z1,
             "A1": A1,
             "Z2": Z2,
             "A2": A2}
    return A2, cache


#Compute the cross-entropy cost
#formula source: https://www.analyticsvidhya.com/blog/2020/11/binary-cross-entropy-aka-log-loss-the-cost-function-used-in-logistic-regression/
def cross_entropy_cost(A2, y, parameters):
    m = y.shape[1] # training example
    logprobs = np.multiply(np.log(A2), y) + np.multiply((1-y), np.log(1-A2))
    cost = - np.sum(logprobs)/m
    cost = float(np.squeeze(cost))
    return cost


#Backpropagation
# to differentiate parameters
def backward_propagation(parameters, cache, X, y):
    m = X.shape[1] # training example

    w1 = parameters['w1']
    w2 = parameters['w2']
    A1 = cache['A1']
    A2 = cache['A2']

    dZ2 = A2-y
    dw2 = (1/m) * np.dot(dZ2, A1.T)
    db2 = (1/m) * np.sum(dZ2, axis=1, keepdims=True)
    dZ1 = np.multiply(np.dot(w2.T, dZ2), 1 - np.power(A1, 2))
    dw1 = (1/m) * np.dot(dZ1, X.T)
    db1 = (1/m)*np.sum(dZ1, axis=1, keepdims=True)

    grads = {"dw1": dw1,
             "db1": db1,
             "dw2": dw2,
             "db2": db2}
    return grads


#Updating the parameters using the gradient descent rules
def gradient_descent(parameters, grads, learning_rate = 0.01):
    w1 = parameters['w1']
    b1 = parameters['b1']
    w2 = parameters['w2']
    b2 = parameters['b2']

    dw1 = grads['dw1']
    db1 = grads['db1']
    dw2 = grads['dw2']
    db2 = grads['db2']

    w1 = w1 - learning_rate*dw1
    b1 = b1 - learning_rate*db1
    w2 = w2 - learning_rate*dw2
    b2 = b2 - learning_rate*db2

    parameters = {"w1": w1,
                  "b1": b1,
                  "w2": w2,
                  "b2": b2}
    return parameters


#Build the neural network model into a single hidden layer
def neural_network_model(X, y, hidden_unit, num_iterations = 1000):
    np.random.seed(3)
    input_unit = define_structure(X, y)[0]
    output_unit = define_structure(X, y)[2]

    parameters = parameters_initialization(input_unit, hidden_unit, output_unit)
    w1 = parameters['w1']
    b1 = parameters['b1']
    w2 = parameters['w2']
    b2 = parameters['b2']

    for i in range(0, num_iterations):
        A2, cache = forward_propagation(X, parameters)
        cost = cross_entropy_cost(A2, y, parameters)
        grads = backward_propagation(parameters, cache, X, y)
        parameters = gradient_descent(parameters, grads)
        if i%100 == 0:
            print("Cost after iteration %i: %f" %(i, cost))
    return parameters

#Learned parameters
parameters = neural_network_model(X_train, y_train, 4, num_iterations=1000)


#Making prediction using forward propagation
def prediction(parameters, X):
    A2, cache = forward_propagation(X, parameters)
    predictions = np.round(A2)

    return predictions

predictions = prediction(parameters, X_train)
print("Train Accuracy: %d" % float((np.dot(y_train, predictions.T) +
                             np.dot(1 - y_train, 1 - predictions.T))/float(y_train.size)*100) + '%')

predictions = prediction(parameters, X_test)
print("Test Accuracy: %d" % float((np.dot(y_test, predictions.T) +
                            np.dot(1 - y_test, 1 - predictions.T))/float(y_test.size)*100) + '%')