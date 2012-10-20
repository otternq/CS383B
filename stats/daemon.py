from database.MongoInterface import MongoInterface
from algorithm1 import Algorithm1
import time

db = MongoInterface()
total = 0

messages = db.messageByService("Twitter")
res = Algorithm1.getResult(messages)
db.saveResult(time.time(), "Twitter", Algorithm1.getAlgorithmNumber(), res)
total += res


messages = db.messageByService("Google Plus")
res = Algorithm1.getResult(messages)
db.saveResult(time.time(), "Google Plus", Algorithm1.getAlgorithmNumber(), res)
total += res

messages = db.messageByService("Facebook")
res = Algorithm1.getResult(messages)
db.saveResult(time.time(), "Facebook", Algorithm1.getAlgorithmNumber(), res)
total += res

messages = db.messageByService("Reddit")
res = Algorithm1.getResult(messages)
db.saveResult(time.time(), "Reddit", Algorithm1.getAlgorithmNumber(), res)
total += res

print total
