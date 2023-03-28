import numpy as np
import matplotlib.pyplot as plt
import pandas as pd

# Dataset
df = pd.read_csv("data.csv")
print(df)

# Analisa Dataset
df.shape
df.columns
df.dtypes
df.head()
df.tail()

# Libraries for visualization
import matplotlib.pyplot as plt
import seaborn as sns

# Menampilkan jumlah costumer yang keluar dalam data set
plt.figure(figsize=(8,8))
sns.countplot(x="Exited", data=df)
plt.xlabel("0: Costumers masih dengan bank, 1: Costumer keluar dari bank")
plt.ylabel('Count')
plt.title('Bank Costumers Churn Visualizartion')
plt.show()

# Mengecek data yang kosong
df.isna().any()

df.drop(['RowNumber', 'CustomerId', 'Surname'], axis=1, inplace=True)
df.columns

# Convert setiap fitur ke dalam bentuk angka
geography = pd.get_dummies(df['Geography'], drop_first=True)
gender = pd.get_dummies(df['Gender'], drop_first=True)

# Menambahkan column baru ke dataframe
df = pd.concat([df, geography, gender], axis=1)
df.columns
df.drop(['Geography', 'Gender'], axis=1, inplace=True)

# Data Preprocessing
## Membagi dataset menjadi independent features (x) dan label (y)
x = df.drop('Exited', axis=1)
y = df['Exited']

from sklearn.model_selection import train_test_split
X_train, X_test, Y_train, Y_test = train_test_split(x, y, test_size = 0.2, random_state = 0)

from sklearn.preprocessing import StandardScaler
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)

# use to implement the k-cross validation
from keras.wrappers.scikit_learn import KerasClassifier
from sklearn.model_selection import cross_val_score
from keras.models import Sequential
from keras.layers import Dense

#ann main function
def build_classifier():
	classifier = Sequential()
	
	classifier.add(Dense(units = 6, kernel_initializer="he_uniform",activation="relu",input_dim = 11))
	
	classifier.add(Dense(units = 6,kernel_initializer="he_uniform",activation="relu"))
	
	classifier.add(Dense(units = 1,kernel_initializer="he_uniform",activation="sigmoid"))
	
	classifier.compile(optimizer = "adam",loss="binary_crossentropy",metrics=['accuracy'])
	
	return classifier

#this classifier will be use to the 10 different training fold 
#for k-cross validation on 1 test fold
classifier = KerasClassifier(build_fn = build_classifier,batch_size = 10,nb_epoch = 100 )

# model_history = classifier.fit(X_train, Y_train, batch_size=10, validation_split=0.33, epochs=100)

accuracies = cross_val_score(estimator=classifier, X = X_train, y = Y_train, cv=10)

# #after we got the accuracies, find the mean
# mean = accuracies.mean()
# variance = accuracies.std()