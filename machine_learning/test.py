import pandas as pd
import matplotlib.pyplot as plt
from sklearn.linear_model import LinearRegression
from sklearn.model_selection import train_test_split

df = pd.read_csv('machine_learning\data_1.csv', usecols=['x', 'y'])

df.head()
df.shape()
df.info()
df.describe()
df.isnull().sum()

f = plt.figure(figsize=(12,4))
f.add_subplot(1,2,1)
df['x'].plot(kind='kde')
f.add_subplot(1,2,2)
plt.boxplot(df['x'])
plt.show()

f = plt.figure(figsize=(12,4))
f.add_subplot(1,2,1)
df['y'].plot(kind='kde', c='g')
f.add_subplot(1,2,2)
plt.boxplot(df['y'])
plt.show()

plt.scatter(df['x'], df['y'])
plt.xlabel('x')
plt.ylabel('y')
plt.title('Scatter Plot x vs y')
plt.show()

df.corr()

x = df['x'].values.reshape(-1,1)
y = df['y'].values.reshape(-1,1)

x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.2)

lin_reg = LinearRegression()

lin_reg.fit(x_train, y_train)

print(lin_reg.coef_)
print(lin_reg.intercept_)

lin_reg.score(x_test, y_test)

y_prediksi = lin_reg.predict(x_test)
plt.scatter(x_test, y_test)
plt.plot(x_test, y_prediksi, c='r')
plt.xlabel('X')
plt.ylabel('Y')
plt.title('Plot X vs Y')

lin_reg.predict([[2]])