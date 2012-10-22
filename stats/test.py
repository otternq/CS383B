from database.MongoInterface import MongoInterface
from algorithm3 import Algorithm3
import time

db = MongoInterface()
total = 0

messages = db.messageByService("Twitter")
res = Algorithm3.getResult(messages)

