#Assigning values to the x and y variables
# x = dataset.iloc[:, :-1].values
# y = dataset.iloc[:,4].values

# #Spliting dataset into random train and test subsets
# x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.20)

# #Standarizing features by removing mean and scaling to unit variance
# scaler = StandardScaler()
# scaler.fit(x_train)

# #Using the KNN Classifier to fit data
# classifier = KNeighborsClassifier(n_neighbors=5)
# classifier.fit(x_train, y_train)

# #Predicting y data with classifier
# y_predict = classifier.predict(x_test)

# #Printing result
# print(confusion_matrix(y_test, y_predict))
# print(classification_report(y_test, y_predict))