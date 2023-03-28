import tkinter as tk
from tkinter import ttk
from tkinter import *
from tkinter.filedialog import asksaveasfile, asksaveasfilename

import vUtility as vu

class View:
    def __init__(self, parent):
        self.container = parent
    
    def setup(self):
        self.create_widgets()
        self.setup_layout()
    
    def create_widgets(self):
        self.leftFrame = Frame(self.container, width=100, height=vu.windowHeight)
        self.midFrame = Frame(self.container, width=vu.canvasWidth, height=vu.canvasHeight)
        self.rightFrame = Frame(self.container, width=100, height=vu.windowHeight)
        self.rightFrame1 = Frame(self.rightFrame)
        self.rightFrame2 = Frame(self.rightFrame)

        self.statusBar = tk.Label(self.midFrame, text="On the way...", bd=1, relief=tk.SUNKEN, anchor=tk.W, fg="red")

        self.inputLabel = tk.Label(self.leftFrame, text="input layer")
        self.combo1Input = ttk.Label(self.leftFrame, values=[1, 2, 3, 4])

        self.mid1Label = tk.Label(self.leftFrame, text="mid layer 1")
        self.combo2Mid1 = ttk.Combobox(self.leftFrame, values=[1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
        self.mid2Label = tk.Label(self.leftFrame, text="mid layer 2")
        self.combo3Mid2 = ttk.Combobox(self.leftFrame, values=[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
        self.mid3Label = tk.Label(self.leftFrame, text="mid layer 3")
        self.combo4Mid3 = ttk.Combobox(self.leftFrame, values=[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
        
        self.outputLabel = tk.Label(self.leftFrame, text="output layer")
        self.combo5Output = ttk.Combobox(self.leftFrame, values=[1, 2, 3, 4, 5, 6, 7, 8, 9, 10])

        self.createNetworkbutton = tk.Button(self.leftFrame, text="Create Network", command=self.createNodes, width=20, height=1)

        # Training Section
        self.trainDivLabel = tk.Label(self.leftFrame, text="Train")
        self.learningRateLabel = tk.Label(self.leftFrame, text="Learning Rate")
        self.combo6LearningRate = ttk.Combobox(self.leftFrame, values=[0.0001, 0.0005, 0.001, 0.005, 0.01, 0.05, 0.1, 0.5])
        self.epochLabel = tk.Label(self.leftFrame, text="Number of Epcohs")
        self.combo7Epoch = ttk.Combobox(self.leftFrame, values=[10, 5000, 50000, 100000, 200000, 500000, 1000000, 2000000, 5000000, 10000000, 20000000, 50000000])

        self.loadFeatureButton = tk.Button(self.leftFrame, text="Load Features", command=self.loadTrainFeature, width=20)
        self.loadLabelButton = tk.Button(self.leftFrame, text="Load Labels", command=self.loadTrainLabel, width=20)
        self.startTrainButton = tk.Button(self.leftf)
        