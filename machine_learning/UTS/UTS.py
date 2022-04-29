import pandas as pd
import numpy as np

#Loading Data Set
df = pd.read_csv('data.csv')

#Dropping the columns
df.drop("City", axis=1, inplace=True)
df.drop("Rank", axis=1, inplace=True)

#Splitting Data Set
x = df.iloc[:,1:]
y = df.iloc[:,0]

from sklearn.model_selection import train_test_split # Splitting 60% for Training Set and 40% for Testing Set
x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.4, random_state=0)

#Linear Regression
from sklearn.linear_model import LinearRegression
from sklearn.linear_model import RidgeClassifier
from sklearn.metrics import mean_squared_error
lin_reg = RidgeClassifier()
lin_reg.fit(x_train, y_train)

y_pred_0 = lin_reg.predict(x_test)
print(y_pred_0)

#rSquared Score
from sklearn.metrics import r2_score
print(r2_score(y_test, y_pred_0))

#Polynomial Regression (Degree 2)
from sklearn.preprocessing import PolynomialFeatures
polynomial_features = PolynomialFeatures(degree=2)
x_poly = polynomial_features.fit_transform(x)

model = RidgeClassifier()
model.fit(x_poly, y)
y_poly_pred = model.predict(x_poly)
print(y_poly_pred)

