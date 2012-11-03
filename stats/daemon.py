from database.MongoInterface import MongoInterface
from Algorithms.algorithm1 import Algorithm1
from Algorithms.algorithm2 import Algorithm2
from Algorithms.algorithm3 import Algorithm3
import time

db = MongoInterface()
total = 0
now = time.time()
services = ["Twitter", "Google Plus", "Facebook", "Reddit"]

for service in services:
    messages = db.messageByService(service)
    res = Algorithm1.getResult(messages)
    db.saveResult(now, service, Algorithm1.getAlgorithmNumber(), res)
    total += res

print total

total = 0

for service in services:
    messages = db.messageByService(service)
    res = Algorithm2.getResult(messages)
    db.saveResult(now, service, Algorithm2.getAlgorithmNumber(), res)
    total += res

print total

total = 0

for service in services:
    messages = db.messageByService(service)
    res = Algorithm3.getResult(messages)
    db.saveResult(now, service, Algorithm3.getAlgorithmNumber(), res)
    total += res

print total

