import csv
from collections import OrderedDict

filename="symptoms.csv"
diseasesdict = {}
symptomss = []
 

with open(filename, 'r') as csvfile:  
    csvreader = csv.reader(csvfile)
    field=next(csvreader)
    for d,s in csvreader:
        symptomss.append(s)

    
print(len(symptomss))
print(list(OrderedDict.fromkeys(symptomss)))