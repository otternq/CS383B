from database.MongoInterface import MongoInterface
from algorithms.Algorithm1 import Algorithm1
from algorithms.Algorithm2 import Algorithm2
from algorithms.Algorithm3 import Algorithm3
import time

db = MongoInterface()
total = 0
now = time.time()
#services = ["Twitter", "Google Plus", "Facebook", "Reddit"]
services = [ "Facebook" ]

days = 0
while ( days < 10):
    end = now - (days * 24 * 60 * 60)
    start = now - ((days+1) * 24 * 60 * 60)



    for service in services:
        messages = db.messageByService(service, start, end)
        res = Algorithm1.getResult(messages)
        db.saveResult(now, service, Algorithm1.getAlgorithmNumber(), res)
        total += res

    print total

    total = 0

    for service in services:
        messages = db.messageByService(service, start, end)
        res = Algorithm2.getResult(messages)
        db.saveResult(now, service, Algorithm2.getAlgorithmNumber(), res)
        total += res

    print total

    total = 0

    for service in services:
        messages = db.messageByService(service, start, end)
        res = Algorithm3.getResult(messages)
        db.saveResult(now, service, Algorithm3.getAlgorithmNumber(), res)
        total += res

    print total

    days += 1

