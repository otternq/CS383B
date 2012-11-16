"""
Calculates the overall sentiment using the data extracted form the database.
The algorithm assign an overall score to each message.
The overall score of each message is calculatedas follow:
    score = relecance * sentiment / elapsedTime

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""


import datetime
from functions.Relevance import Relevance
from functions.Sentiment import Sentiment
from functions.SocialDate import SocialDate
import pytz

class Algorithm1:

    @staticmethod
    def getAlgorithmNumber():
        return 1

    @staticmethod
    def getResult(messages):
        sum = 0.0
        for message in messages:
            relevance = Relevance.getRelevance(message)
            sentiment = Sentiment.getSentiment(message)
            publishedDate = SocialDate.getPublishedDate(message)
            actualDate = datetime.datetime.utcnow()
            actualDate = actualDate.replace(tzinfo=pytz.utc)
            elapsedTime = actualDate - publishedDate
            sum += relevance * sentiment / elapsedTime.total_seconds()
        return sum
