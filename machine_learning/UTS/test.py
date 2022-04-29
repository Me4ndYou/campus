import imp
from traceback import print_tb
from unittest import result
#Importing Library
import numpy as np
import sklearn
from sklearn import model_selection
from sklearn.model_selection import cross_validate
from sklearn.svm import SVC
from sklearn.tree import DecisionTreeClassifier
from sklearn.neighbors import KNeighborsClassifier
from sklearn.metrics import classification_report
from sklearn.metrics import accuracy_score
from pandas.plotting import scatter_matrix
import matplotlib.pyplot as plt
import pandas as pd
import seaborn as sns

#Importing Data Set
data = pd.read_csv('Cost_of_living_index.csv')

#Check missing data and preprocess data
data.replace('?',-99999,inplace=True)
print(data.axes)
print(data.columns)
print(data.astype(object))

#Visualizing random data
print(data.loc[30])
#Print the shape of the dataset
print(data.shape)

#Describing data excluding NaN values
print(data.describe())

#Plotting the data into histogram graph
data.hist(figsize=(15,15))
plt.show()

#Scaterring the Plot
scatter_matrix(data, figsize=(20,20))
plt.show()

#Correlation Matrix
correlation_matrix = data.corr()
plt.figure(figsize=(10,10))
sns.heatmap(correlation_matrix, cmap='viridis', annot=True, linewidths=0.5,)
plt.show()

#Getting all the columns from the dataframe
columns = data.columns.tolist()
#Filtering the columns to remove data we do not want
columns = [c for c in columns if c not in ["Rank", "City"]]
#Storing the variable we will be predicting on
target = "City"
x = data[columns]
y = data[target]
print(x.shape)
print(y.shape)

#Random Checking
print(x.loc[45])
print(y.loc[45])

#Creating x and y datasets for training
x_train, x_test, y_train, y_test = model_selection.train_test_split(x, y, test_size=0.05)
#Specifying the testing option
seed = 5
scoring = 'accuracy'
print(x_train.shape, x_test.shape)
print(y_train.shape, y_test.shape)

#Ignoring all future warnings
from warnings import simplefilter
simplefilter(action='ignore', category=FutureWarning)

from sklearn.ensemble import RandomForestClassifier
#Defining models to train
models = []
models.append(('KNN', KNeighborsClassifier(n_neighbors=5)))
models.append(('SVM', SVC(gamma='auto')))
models.append(('CART', DecisionTreeClassifier()))
models.append(('RFC', RandomForestClassifier(max_depth=5, n_estimators=40)))
#Evaluating each model in turn
results = []
names = []
for name, model in models:
    kfold = model_selection.KFold(n_splits=10, random_state = None)
    cv_results = model_selection.cross_val_score(model, x_train, y_train, cv=kfold, scoring=scoring)
    print(cv_results)
    results.append(cv_results)
    names.append(name)
    msg = "%s: %f (%f)" % (name, cv_results.mean(), cv_results.std())
    print(msg)

#Compare Algorithms
fig = plt.figure()
fig.suptitle('Algorithm Comparison')
ax = fig.add_subplot(111)
plt.boxplot(results)
ax.set_xticklabels(names)
plt.show()

from sklearn.model_selection import StratifiedKFold
from yellowbrick.model_selection import CVScores
_, ax = plt.subplots()
cv = StratifiedKFold(10)
oz = CVScores(RandomForestClassifier(max_depth=5, n_estimators=40), ax=ax, cv=cv, scoring="accuracy")
oz.fit(x,y)
oz.poof()

#Make predictions on validation dataset
for name, model in models:
    model.fit(x_train, y_train)
    predictions = model.predict(x_test)
    print(name)
    print(accuracy_score(y_test, predictions))
    print(classification_report(y_test, predictions))

#Plotting Confusion matrix
from sklearn.metrics import confusion_matrix
predict = model.predict(x_test)
print("#### CONFUSION MATRIX ####")
print(confusion_matrix(y_test, predict))
print('\n')

from sklearn import metrics
confuse_matrix = metrics.confusion_matrix(y_test, predict)
p = sns.heatmap(pd.DataFrame(confuse_matrix), annot=True, cmap="YlGnBu", fmt='g')
plt.title('Confusion Matrix', y=1.1)
plt.ylabel('Actual Label')
plt.xlabel('Predicted Label')
plt.show()

#Findign Kappa Score and MCC Score
from sklearn.metrics import cohen_kappa_score
cohen_score = cohen_kappa_score(y_test, predictions)
print("Kappa Score: ", cohen_score)

from sklearn.metrics import matthews_corrcoef
MCC = matthews_corrcoef(y_test, predictions)
print("MCC Score: ", MCC)